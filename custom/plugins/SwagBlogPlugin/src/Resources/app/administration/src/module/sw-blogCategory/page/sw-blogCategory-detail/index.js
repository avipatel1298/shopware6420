import template from './sw-blogCategory-detail.html.twig';

const {Component, Mixin, Data: {Criteria}} = Shopware;

const {mapPropertyErrors} = Shopware.Component.getComponentHelper();

Component.register('sw-blogCategory-detail', {
    template, inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('placeholder'),
        Mixin.getByName('notification'),
        Mixin.getByName('discard-detail-page-changes')('blogCategory'),
    ],

    props: {
        blogCategoryId: {
            type: String,
            required: false,
            default: null,
        },
    },

    data() {
        return {
            blogCategory: [],
            isLoading: false,
            isSaveSuccessful: false,
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(this.identifier)
        };
    },

    computed: {
        identifier() {
            return this.placeholder(this.blogCategory, 'name');
        },

        blogCategoryIsLoading() {
            return this.isLoading || this.blogCategory == null;
        },

        blogCategoryRepository() {
            return this.repositoryFactory.create('blog_category');
        },


        tooltipSave() {
            if (this.acl.can('blog_category.editor')) {
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
        ...mapPropertyErrors('blogCategory', ['name',

        ]),
    },

    watch: {
        blogCategoryId() {
            this.createdComponent();
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            Shopware.ExtensionAPI.publishData({
                id: 'sw-blogCategory-detail',
                path: 'blogCategory',
                scope: this,
            });
            if (this.blogCategoryId) {
                this.loadEntityData();
                return;
            }

            Shopware.State.commit('context/resetLanguageToDefault');
            this.blogCategory = this.blogCategoryRepository.create();
        },

        async loadEntityData() {
            this.isLoading = true;

            const [blogCategoryResponse] = await Promise.allSettled([
                this.blogCategoryRepository.get(this.blogCategoryId)
            ]);


            if (blogCategoryResponse.status === 'fulfilled') {
                this.blogCategory = blogCategoryResponse.value;
            }

            if (blogCategoryResponse.status === 'rejected') {
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationLoadingDataErrorMessage',
                    ),
                });
            }

            this.isLoading = false;
        },

        abortOnLanguageChange() {
            return this.blogCategoryRepository.hasChanges(this.blogCategory);
        },

        saveOnLanguageChange() {
            return this.onSave();
        },

        onChangeLanguage() {
            this.loadEntityData();
        },

        onSave() {
            if (!this.acl.can('blog_category.editor')) {
                return;
            }

            this.isLoading = true;

            this.blogCategoryRepository.save(this.blogCategory).then(() => {
                this.isLoading = false;
                this.isSaveSuccessful = true;
                if (this.blogCategoryId === null) {
                    this.$router.push({name: 'sw.blogCategory.detail', params: {id: this.blogCategory.id}});
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
            this.$router.push({name: 'sw.blogCategory.index'});
        },
    },

});
