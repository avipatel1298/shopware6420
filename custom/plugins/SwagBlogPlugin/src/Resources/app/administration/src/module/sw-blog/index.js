import './page/sw-blog-list';
import './page/sw-blog-detail';
import './acl';

const { Module } = Shopware;

Module.register('sw-blog', {
    type: 'core',
    name: 'blog-category',
    title: 'sw-blog.general.mainMenuItemGeneral',
    description: 'This is Blogs',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#57D9A3',
    icon: 'regular-products',
    favicon: 'icon-module-products.png',
    entity: 'blog',


    routes: {
        index: {
            components: {
                default: 'sw-blog-list',
            },
            path: 'index',
            meta: {
                privilege: 'blog.viewer',
            },
        },
        create: {
            component: 'sw-blog-detail',
            path: 'create',
            meta: {
                parentPath: 'sw.blog.index',
                privilege: 'blog.creator',
            },
        },
        detail: {
            component: 'sw-blog-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.blog.index',
                privilege: 'blog.viewer',
            },
            props: {
                default(route) {
                    return {
                        blogId: route.params.id,
                    };
                }
            }
        }
    },

    navigation: [{
        label: 'Blogs',
        color: '#7036d3',
        path: 'sw.blog.index',
        parent: 'sw-catalogue',
        id: 'sw-blog',
        position: 51,
    }]
});
