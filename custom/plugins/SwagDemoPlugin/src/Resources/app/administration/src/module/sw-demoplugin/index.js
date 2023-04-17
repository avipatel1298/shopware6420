import './page/sw-demoplugin-list';
import './page/sw-demoplugin-detail';
import deDE from './snippet/de-DE';
import enGB from './snippet/en-GB';
import './acl';
const { Module } = Shopware;


Module.register('sw-demoplugin', {
    type: 'core',
    name: 'demoplugin',
    title: 'sw-demoplugin.general.mainMenuItemGeneral',
    description: 'This is Just Demoplugin',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#57D9A3',
    icon: 'regular-products',
    favicon: 'icon-module-products.png',
    entity: 'swag_demo',


    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    routes: {
        index: {
            components: {
                default: 'sw-demoplugin-list',
            },
            path: 'index',

        },

        list: {
            component: 'sw-demoplugin-list',
            path: 'list'
        },
        detail: {
            component: 'sw-demoplugin-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.demoplugin.list'
            }
        },
        create: {
            component: 'sw-demoplugin-create',
            path: 'create',
            meta: {
                parentPath: 'sw.demoplugin.index',
                privilege: 'swag_demo.creator'
            }
        }
    },

    navigation: [{
        label: 'Demo',
        color: '#7036d3',
        path: 'sw.demoplugin.index',
        icon: 'default-shopping-paper-bag-product',
        parent: 'sw-catalogue',
        id: 'sw-demoplugin',
        position: 100,
    }]


});
