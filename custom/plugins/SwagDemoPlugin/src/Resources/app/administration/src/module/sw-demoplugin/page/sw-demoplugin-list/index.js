/*
 * @package inventory
 */

import template from './sw-demoplugin-list.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('sw-demoplugin-list', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('listing'),
    ],

    data() {
        return {
            demoplugin: null,
            isLoading: true,
            sortBy: 'name',
            sortDirection: 'ASC',
            total: 0,
            searchConfigEntity: 'swag_demo',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(),
        };
    },

    computed: {
        demopluginRepository() {
            return this.repositoryFactory.create('swag_demo');
        },

        demopluginColumns() {
            return [{
                property: 'name',

                dataIndex: 'name',
                allowResize: true,
                routerLink: 'sw.demoplugin.detail',
                label: 'sw-demoplugin.list.columnName',
                inlineEdit: 'string',
                primary: true,
            }, {
                property: 'link',
                label: 'sw-demoplugin.list.columnLink',
                inlineEdit: 'string',
            }];
        },

        demopluginCriteria() {
            const demopluginCriteria = new Criteria(this.page, this.limit);

            demopluginCriteria.setTerm(this.term);
            demopluginCriteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));

            return demopluginCriteria;
        },
    },

    methods: {
        onChangeLanguage(languageId) {
            this.getList(languageId);
        },

        async getList() {
            this.isLoading = true;

            const criteria = await this.addQueryScores(this.term, this.demopluginCriteria);

            if (!this.entitySearchable) {
                this.isLoading = false;
                this.total = 0;

                return false;
            }

            if (this.freshSearchTerm) {
                criteria.resetSorting();
            }

            return this.demopluginRepository.search(criteria)
                .then(searchResult => {
                    this.demoplugin = searchResult;
                    this.total = searchResult.total;
                    this.isLoading = false;
                });
        },

        updateTotal({ total }) {
            this.total = total;
        },
    },
});
