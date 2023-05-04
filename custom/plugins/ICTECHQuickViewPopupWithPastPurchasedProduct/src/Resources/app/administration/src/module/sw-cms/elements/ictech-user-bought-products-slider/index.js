import './component';
import './config';
import'./preview';

const Criteria = Shopware.Data.Criteria;
const criteria = new Criteria(1, 25);
// criteria.addAssociation('crossSellings.assignedProducts.product');

/**
 * @private since v6.5.0
 * @package content
 */
Shopware.Service('cmsService').registerCmsElement({
    name: 'ictech-user-bought-products-slider',
    label: 'sw-cms.elements.ictech-user-bought-products-slider.label',
    component: 'sw-cms-el-ictech-user-bought-products-slider',
    configComponent: 'sw-cms-el-config-ictech-user-bought-products-slider',
    previewComponent: 'sw-cms-el-preview-ictech-user-bought-products-slider',
    defaultConfig: {
        title: {
            source: 'static',
            value: '',
        },
        displayMode: {
            source: 'static',
            value: 'standard',
        },
        boxLayout: {
            source: 'static',
            value: 'standard',
        },
        elMinWidth: {
            source: 'static',
            value: '300px',
        },
        navigation: {
            source: 'static',
            value: true,
        },
        rotate: {
            source: 'static',
            value: false,
        },
        border: {
            source: 'static',
            value: false,
        },
        verticalAlign: {
            source: 'static',
            value: null,
        },
    },
    collect: Shopware.Service('cmsService').getCollectFunction(),
});