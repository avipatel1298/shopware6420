import template from './sw-cms-block-test.html.twig';
import './sw-cms-block-test.scss';

const { Component } = Shopware;

/**
 * @private since v6.5.0
 * @package content
 */
Component.register('sw-cms-preview-test', {
    template,
});
