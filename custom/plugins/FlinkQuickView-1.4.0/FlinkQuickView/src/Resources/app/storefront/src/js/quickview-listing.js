import Plugin from 'src/plugin-system/plugin.class';
import AjaxModalExtensionUtil from 'src/utility/modal-extension/ajax-modal-extension.util';

export default class FlinkQuickViewListing extends Plugin {
    init() {
        // Make button work in listings when listing filter changes
        const listingPlugin = window.PluginManager.getPluginInstanceFromElement(this.el, 'Listing');
        if (listingPlugin) {
            listingPlugin.$emitter.subscribe('Listing/afterRenderResponse', function() {
                new AjaxModalExtensionUtil();
            });
        }
    }
}
