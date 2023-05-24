import FlinkQuickView from './js/quickview';
// import FlinkQuickViewListing from './js/quickview-listing';

const PluginManager = window.PluginManager;
PluginManager.register('FlinkQuickView', FlinkQuickView, '[data-flink-quick-view]');
// PluginManager.register('FlinkQuickViewListing', FlinkQuickViewListing, '.cms-element-product-listing-wrapper');

if (module.hot) {
    module.hot.accept();
}