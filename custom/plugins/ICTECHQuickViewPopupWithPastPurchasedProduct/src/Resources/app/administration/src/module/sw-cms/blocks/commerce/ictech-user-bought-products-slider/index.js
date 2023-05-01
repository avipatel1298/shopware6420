import './preview';
import './component';

/**
 * @private since v6.5.0
 * @package content
 */
Shopware.Service('cmsService').registerCmsBlock({
    name: 'ictech-user-bought-products-slider',
    label: 'sw-cms.blocks.commerce.ictech-user-bought-products-slider.label',
    category: 'commerce',
    component: 'sw-cms-blocks-ictech-user-bought-products-slider',
    previewComponent: 'sw-cms-preview-ictech-user-bought-product-slider',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed',
    },
    slots: {
        ictechUserBoughtProductsSlider: 'ictech-user-bought-products-slider',
    },
});
