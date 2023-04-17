import template from './sw-demoplugin-detail.html.twig';

const {Component, Mixin, Data: {Criteria}} = Shopware;

const {mapPropertyErrors} = Shopware.Component.getComponentHelper();

Component.register('sw-demoplugin-create', {
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
            demoplugin: null,
            customFieldSets: [],
            isLoading: false,
            isSaveSuccessful: false,
            country:null,
            state:[],
            product:[],
            media:[]
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

        customFieldSetRepository() {
            return this.repositoryFactory.create('custom_field_set');
        },

        customFieldSetCriteria() {
            const criteria = new Criteria(1, null);
            criteria.addFilter(Criteria.equals('relations.entityName', 'swag_demo'),);

            return criteria;
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
        'countryId',
        'countryStateId',
        'product',
        ]),
    },

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

    watch: {
        demopluginId() {
            this.createdComponent();
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            Shopware.ExtensionAPI.publishData({
                id: 'sw-demoplugin-detail__manufacturer',
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

        async loadEntityData() {
            this.isLoading = true;

            const [demopluginResponse, customFieldResponse] = await Promise.allSettled([
                this.demopluginRepository.get(this.demopluginId),
                this.customFieldSetRepository.search(this.customFieldSetCriteria),
            ]);

            if (demopluginResponse.status === 'fulfilled') {
                this.manufacturer = demopluginResponse.value;
            }

            if (customFieldResponse.status === 'fulfilled') {
                this.customFieldSets = customFieldResponse.value;
            }

            if (demopluginResponse.status === 'rejected' || customFieldResponse.status === 'rejected') {
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationLoadingDataErrorMessage',
                    ),
                });
            }

            this.isLoading = false;
        },

        abortOnLanguageChange() {
            return this.demopluginRepository.hasChanges(this.manufacturer);
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

            this.demopluginRepository.save(this.manufacturer).then(() => {
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
