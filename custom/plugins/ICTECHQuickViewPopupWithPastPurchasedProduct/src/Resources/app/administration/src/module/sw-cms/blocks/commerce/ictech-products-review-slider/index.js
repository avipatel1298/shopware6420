import './component';
import './preview';

/**
 * @private since v6.5.0
 * @package content
 */
Shopware.Service('cmsService').registerCmsBlock({
    name: 'ictech-products-review-slider',
    label: 'sw-cms.blocks.commerce.ictechProductsReviewSlider.label',
    category: 'commerce',
    component: 'sw-cms-block-ictech-products-review-slider',
    previewComponent: 'sw-cms-preview-ictech-products-review-slider',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed',
    },
    slots: {
        ictechProductsReviewSlider: 'ictech-products-review-slider',
    },
});
