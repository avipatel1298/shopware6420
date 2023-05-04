import template from './sw-cms-el-config-ictech-products-review-slider.html.twig';
import './sw-cms-el-config-ictech-products-review-slider.scss';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

/**
 * @private since v6.5.0
 * @package content
 */
Component.register('sw-cms-el-config-ictech-products-review-slider', {
    template,

    inject: ['repositoryFactory'],

    mixins: [
        Mixin.getByName('cms-element'),
    ],

    computed: {
        productRepository() {
            return this.repositoryFactory.create('product');
        },

        productSelectContext() {
            return {
                ...Shopware.Context.api,
                inheritance: true,
            };
        },

        productCriteria() {
            const criteria = new Criteria(1, 25);
            criteria.addAssociation('options.group');

            return criteria;
        },

        selectedProductCriteria() {
            const criteria = new Criteria(1, 25);
            // criteria.addAssociation('crossSellings.assignedProducts.product');

            return criteria;
        },

        isProductPageType() {
            return this.cmsPageState?.currentPage?.type === 'product_detail';
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('ictech-products-review-slider');
        },
        //
        onProductChange(productId) {
            if (!productId) {
                this.element.config.product.value = null;
                this.$set(this.element.data, 'product', null);
            } else {
                this.productRepository.get(productId, this.productSelectContext, this.selectedProductCriteria)
                    .then((product) => {
                        this.element.config.product.value = productId;
                        this.$set(this.element.data, 'product', product);
                    });
            }

            this.$emit('element-update', this.element);
        },
    },
});
