import template from './sw-demoplugin-detail.html.twig';

const {Component, Mixin, Data: {Criteria}} = Shopware;

const {mapPropertyErrors} = Shopware.Component.getComponentHelper();

Component.register('sw-demoplugin-detail', {
    template, inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('placeholder'),
        Mixin.getByName('notification'),
        Mixin.getByName('discard-detail-page-changes')('demoplugin'),
    ],

    props: {
        demopluginId: {
            type: String,
            required: false,
            default: null,
        },
    },

    data() {
        return {
            demoplugin: [],
            isLoading: false,
            isSaveSuccessful: false,
            country: null,
            state: [],
            product: [],
            media: []
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(this.identifier)
        };
    },

    computed: {
        identifier() {
            return this.placeholder(this.demoplugin, 'name');
        },

        demopluginIsLoading() {
            return this.isLoading || this.demoplugin == null;
        },

        demopluginRepository() {
            return this.repositoryFactory.create('swag_demo');
        },

        mediaRepository() {
            return this.repositoryFactory.create('media');
        },

        countryRepository() {
            return this.repositoryFactory.create('country')
        },

        countryStateRepository() {
            return this.repositoryFactory.create('country_state')
        },

        productRepository() {
            return this.repositoryFactory.create('product')
        },

        mediaUploadTag() {
            return `sw-demoplugin-detail--${this.demoplugin.id}`;
        },

        tooltipSave() {
            if (this.acl.can('swag_demo.editor')) {
                const systemKey = this.$device.getSystemKey();

                return {
                    message: `${systemKey} + S`,
                    appearance: 'light',
                };
            }
            return {
                showDelay: 300,
                message: this.$tc('sw-privileges.tooltip.warning'),
                disabled: this.acl.can('order.editor'),
                showOnDisabledElements: true,
            };
        },
        tooltipCancel() {
            return {
                message: 'ESC',
                appearance: 'light',
            };
        },
        ...mapPropertyErrors('demoplugin', ['name',
            'city',
        ]),

        countryId: {
            get() {
                return this.demoplugin.countryId;
            },

            set(countryId) {
                this.demoplugin.countryId = countryId;
            },
        },

        countryCriteria() {
            const criteria = new Criteria(1, 25);
            criteria.addSorting(Criteria.sort('position', 'ASC'));
            return criteria;
        },

        stateCriteria() {
            if (!this.demoplugin.countryId) {
                return null;
            }

            const criteria = new Criteria(1, 25);
            criteria.addFilter(Criteria.equals('countryId', this.demoplugin.countryId));
            return criteria;
        },

        productCriteria() {
            const criteria = new Criteria(1, 25);
            return criteria;
        },
    },

    watch: {
        demopluginId() {
            this.createdComponent();
        },

        countryId: {
            immediate: true,
            handler(newId, oldId) {
                if (typeof oldId !== 'undefined') {
                    this.demoplugin.countryStateId = null;
                }

                if (!this.countryId) {
                    this.country = null;
                    return Promise.resolve();
                }

                return this.countryRepository.get(this.countryId).then((country) => {
                    this.country = country;
                    this.getCountryStates();
                });
            },
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            Shopware.ExtensionAPI.publishData({
                id: 'sw-demoplugin-detail',
                path: 'demoplugin',
                scope: this,
            });
            if (this.demopluginId) {
                this.loadEntityData();
                return;
            }

            Shopware.State.commit('context/resetLanguageToDefault');
            this.demoplugin = this.demopluginRepository.create();
        },

        getCountryStates() {
            if (!this.country) {
                return Promise.resolve();
            }

            return this.countryStateRepository.search(this.stateCriteria).then((response) => {
                this.states = response;
            });
        },

        async loadEntityData() {
            this.isLoading = true;

            const [demopluginResponse] = await Promise.allSettled([
                this.demopluginRepository.get(this.demopluginId)
            ]);


            if (demopluginResponse.status === 'fulfilled') {
                this.demoplugin = demopluginResponse.value;
            }

            if (demopluginResponse.status === 'rejected') {
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationLoadingDataErrorMessage',
                    ),
                });
            }

            this.isLoading = false;
        },

        abortOnLanguageChange() {
            return this.demopluginRepository.hasChanges(this.demoplugin);
        },

        saveOnLanguageChange() {
            return this.onSave();
        },

        onChangeLanguage() {
            this.loadEntityData();
        },

        setMediaItem({targetId}) {
            this.demoplugin.mediaId = targetId;
        },

        setMediaFromSidebar(media) {
            this.demoplugin.mediaId = media.id;
        },

        onUnlinkLogo() {
            this.demoplugin.mediaId = null;
        },

        openMediaSidebar() {
            this.$refs.mediaSidebarItem.openContent();
        },

        onDropMedia(dragData) {
            this.setMediaItem({targetId: dragData.id});
        },

        onSave() {
            if (!this.acl.can('swag_demo.editor')) {
                return;
            }

            this.isLoading = true;

            this.demopluginRepository.save(this.demoplugin).then(() => {
                this.isLoading = false;
                this.isSaveSuccessful = true;
                if (this.demopluginId === null) {
                    this.$router.push({name: 'sw.demoplugin.detail', params: {id: this.demoplugin.id}});
                    return;
                }

                this.loadEntityData();
            }).catch((exception) => {
                this.isLoading = false;
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationSaveErrorMessageRequiredFieldsInvalid',
                    ),
                });
                throw exception;
            });
        },

        onCancel() {
            this.$router.push({name: 'sw.demoplugin.index'});
        },
    },

});
