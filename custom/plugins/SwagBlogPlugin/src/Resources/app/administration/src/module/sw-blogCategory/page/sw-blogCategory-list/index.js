/*
 * @package inventory
 */

import template from './sw-blogcategory-list.html.twig';

const {Component, Mixin} = Shopware;
const {Criteria} = Shopware.Data;

Component.register('sw-blogCategory-list', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('listing'),
    ],

    data() {
        return {
            blogCategory: null,
            isLoading: true,
            sortBy: 'categoryName',
            sortDirection: 'ASC',
            total: 0,
            searchConfigEntity: 'blog_category',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(),
        };
    },

    computed: {
        blogCategoryRepository() {
            return this.repositoryFactory.create('blog_category');
        },

        blogCategoryColumns() {
            return [{
                property: 'categoryName',
                dataIndex: 'categoryName',
                allowResize: true,
                routerLink: 'sw.blogCategory.detail',
                label: 'Name',
                inlineEdit: 'string',
                primary: true,
            },
                {
                    property: 'createdAt',
                    label: 'Created At',
                }

            ];
        },

        blogCategoryCriteria() {
            const blogCategoryCriteria = new Criteria(this.page, this.limit);

            blogCategoryCriteria.setTerm(this.term);
            blogCategoryCriteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));

            return blogCategoryCriteria;
        },
    },

    methods: {
        onChangeLanguage(languageId) {
            this.getList(languageId);
        },

        async getList() {
            this.isLoading = true;

            const criteria = await this.addQueryScores(this.term, this.blogCategoryCriteria);

            if (!this.entitySearchable) {
                this.isLoading = false;
                this.total = 0;

                return false;
            }

            if (this.freshSearchTerm) {
                criteria.resetSorting();
            }

            return this.blogCategoryRepository.search(criteria)
                .then(searchResult => {
                    this.blogCategory = searchResult;
                    this.total = searchResult.total;
                    this.isLoading = false;
                });
        },

        updateTotal({total}) {
            this.total = total;
        },
    },
});
