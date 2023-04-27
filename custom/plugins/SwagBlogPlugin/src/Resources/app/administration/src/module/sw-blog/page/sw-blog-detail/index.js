import template from './sw-blog-detail.html.twig';

const {Component, Mixin,Context , Data: {Criteria}} = Shopware;
const { EntityCollection } = Shopware.Data;

const {mapPropertyErrors} = Shopware.Component.getComponentHelper();

Component.register('sw-blog-detail', {
    template, inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('placeholder'),
        Mixin.getByName('notification'),
        Mixin.getByName('discard-detail-page-changes')('blog'),
    ],

    props: {
        blogId: {
            type: String,
            required: false,
            default: null,

        },
    },

    data() {
        return {
            blog: [],
            isLoading: false,
            isSaveSuccessful: false,
            product: [],
            category:[],
            categories: null


        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(this.identifier)
        };
    },

    computed: {
        identifier() {
            return this.placeholder(this.blog, 'name');
        },

        blogIsLoading() {
            return this.isLoading || this.blog == null;
        },

        blogRepository() {
            return this.repositoryFactory.create('blog');
        },

        categoryRepository() {
            return this.repositoryFactory.create('blog_category');
        },

        productRepository() {
            return this.repositoryFactory.create('product')
        },

        tooltipSave() {
            if (this.acl.can('blog.editor')) {
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
        ...mapPropertyErrors('blog', ['name',

        ]),

        blogCategoryCriteria() {
            const criteria = new Criteria(1, 25);
            return criteria;
        },

        productCriteria() {
            const criteria = new Criteria(1, 25);
            return criteria;
        },
    },

    watch: {
        blogId() {
            this.createdComponent();
        },

        categoryId() {
            this.setCategory();
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
                this.categories = new EntityCollection(
                    this.categoryRepository.route,
                    this.categoryRepository.entityName,
                    Context.api,
                );
                console.log(this.categories);

                this.product = new EntityCollection(
                    this.productRepository.route,
                    this.productRepository.entityName,
                    Context.api,
                );

            Shopware.ExtensionAPI.publishData({
                id: 'sw-blog-detail',
                path: 'blog',
                scope: this,
            });

            if (this.blogId) {
                this.loadEntityData();
                return;
            }
            Shopware.State.commit('context/resetLanguageToDefault');
            this.blog = this.blogRepository.create();


        },
        setCategoryIds(cat) {
            this.categoryIds = cat.getIds();
            // this.categories = this.categories;
            console.log(cat)
        },

        // setProductIds(categories) {
        //     this.productIds = products.getIds();
        //     this.productsIds = this.categories;
        //
        // },

        // setIds(categories) {
        //     this.categoryIds = categories.getIds();
        //     this.categories = this.categories;
        //
        // },

        async loadEntityData() {
            this.isLoading = true;

            const [blogResponse] = await Promise.allSettled([
                this.blogRepository.get(this.blogId)
            ]);


            if (blogResponse.status === 'fulfilled') {
                this.blog = blogResponse.value;
            }

            if (blogResponse.status === 'rejected') {
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationLoadingDataErrorMessage',
                    ),
                });
            }

            this.isLoading = false;
        },


        abortOnLanguageChange() {
            return this.blogRepository.hasChanges(this.blog);
        },

        saveOnLanguageChange() {
            return this.onSave();
        },

        onChangeLanguage() {
            this.loadEntityData();
        },

        onSave() {
            if (!this.acl.can('blog.editor')) {
                return;
            }

            this.isLoading = true;
            console.log(this.blog);
            this.blogRepository.save(this.blog).then(() => {
                this.isLoading = false;
                this.isSaveSuccessful = true;
                if (this.blogId === null) {
                    this.$router.push({name: 'sw.blog.detail', params: {id: this.blog.id}});
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
            this.$router.push({name: 'sw.blog.index'});
        },
    },

});
