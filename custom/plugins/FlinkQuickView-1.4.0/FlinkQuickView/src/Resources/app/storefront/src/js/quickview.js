import Plugin from 'src/plugin-system/plugin.class';

import DomAccess from 'src/helper/dom-access.helper';
import HttpClient from 'src/service/http-client.service';
import ElementReplaceHelper from 'src/helper/element-replace.helper';
import ElementLoadingIndicatorUtil from 'src/utility/loading-indicator/element-loading-indicator.util';

export default class FlinkQuickView extends Plugin {

    static options = {
        elementId: 'flinkQuickView',
    };

    init() {
        this._httpClient = new HttpClient();
        this._registerEvents();
    }

    _registerEvents() {
        document.$emitter.subscribe('updateBuyWidget', this._handleUpdateBuyWidget.bind(this));
        this._registerOpenOffCanvasCartEvent();
    }

    _registerOpenOffCanvasCartEvent() {
        const cartForm = DomAccess.querySelector(this.el, '[data-add-to-cart]', false);
        if (cartForm) {
            const addToCartPlugin = window.PluginManager.getPluginInstanceFromElement(cartForm, 'AddToCart');
            addToCartPlugin.$emitter.subscribe('openOffCanvasCart', this._handleOpenOffCanvasCart.bind(this));
        }
    }

    _handleUpdateBuyWidget(event) {
        if (!event.detail || this.options.elementId !== event.detail.elementId) {
            return;
        }

        const quickView = document.getElementById(this.options.elementId);
        ElementLoadingIndicatorUtil.create(quickView);

        this._httpClient.get(`${event.detail.url}`, (response) => {
            ElementReplaceHelper.replaceFromMarkup(response, `#${this.options.elementId}`, false);
            ElementLoadingIndicatorUtil.remove(quickView);
            window.PluginManager.initializePlugins();
            this._registerOpenOffCanvasCartEvent();
        });
    }

    _handleOpenOffCanvasCart(event) {
        $('.modal.quickview').modal('hide');
    }

}
