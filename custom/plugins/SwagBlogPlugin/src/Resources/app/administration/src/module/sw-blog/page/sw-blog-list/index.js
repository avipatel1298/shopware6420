/*
 * @package inventory
 */

import template from './sw-blog-list.html.twig';

const {Component, Mixin} = Shopware;
const {Criteria} = Shopware.Data;

Component.register('sw-blog-list', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('listing'),
    ],

    data() {
        return {
            blog: null,
            isLoading: true,
            sortBy: 'blogName',
            sortDirection: 'ASC',
            total: 0,
            searchConfigEntity: 'blog',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(),
        };
    },

    computed: {
        blogRepository() {
            return this.repositoryFactory.create('blog');
        },

        blogColumns() {
            return [{
                property: 'blogName',
                dataIndex: 'blogName',
                allowResize: true,
                routerLink: 'sw.blog.detail',
                label: 'Blog Name',
                inlineEdit: 'string',
                primary: true,
            },

                {
                    property: "releaseDate",
                    label:"Release Date"
                },

                {
                    property: "author",
                    label:"Author"
                },

                {
                    property: "active",
                    label:"Active"
                },

            ];
        },

        blogCriteria() {
            const blogCriteria = new Criteria(this.page, this.limit);

            blogCriteria.setTerm(this.term);
            blogCriteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));

            return blogCriteria;
        },
    },

    methods: {
        onChangeLanguage(languageId) {
            this.getList(languageId);
        },

        async getList() {
            this.isLoading = true;

            const criteria = await this.addQueryScores(this.term, this.blogCriteria);

            if (!this.entitySearchable) {
                this.isLoading = false;
                this.total = 0;

                return false;
            }

            if (this.freshSearchTerm) {
                criteria.resetSorting();
            }

            return this.blogRepository.search(criteria)
                .then(searchResult => {
                    this.blog = searchResult;
                    this.total = searchResult.total;
                    this.isLoading = false;
                });
        },

        updateTotal({total}) {
            this.total = total;
        },
    },
});
