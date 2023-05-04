import './preview';
import './component';
import './config';

const Criteria = Shopware.Data.Criteria;
const criteria = new Criteria(1, 25);
criteria.addAssociation('cover');

/**
 * @private since v6.5.0
 * @package content
 */
Shopware.Service('cmsService').registerCmsElement({
    name: 'ictech-products-review-slider',
    label: 'sw-cms.elements.ictechProductsReviewSlider.label',
    component: 'sw-cms-el-ictech-products-review-slider',
    configComponent: 'sw-cms-el-config-ictech-products-review-slider',
    previewComponent: 'sw-cms-el-preview-ictech-products-review-slider',
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
