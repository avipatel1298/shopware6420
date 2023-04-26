import template from './sw-cms-preview-images.html.twig';
import './sw-cms-preview-images.scss';

const { Component } = Shopware;

/**
 * @private since v6.5.0
 * @package content
 */
Component.register('sw-cms-preview-images', {
    template,
});
