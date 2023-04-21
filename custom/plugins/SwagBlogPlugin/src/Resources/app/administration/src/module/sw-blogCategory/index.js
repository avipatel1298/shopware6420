import './page/sw-blogCategory-list';
import './page/sw-blogCategory-detail';
import './acl';

const { Module } = Shopware;

Module.register('sw-blogCategory', {
    type: 'core',
    name: 'blog-category',
    title: 'sw-blogCategory.general.mainMenuItemGeneral',
    description: 'This is blogCategory',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#57D9A3',
    icon: 'regular-products',
    favicon: 'icon-module-products.png',
    entity: 'blog_category',


    routes: {
        index: {
            components: {
                default: 'sw-blogCategory-list',
            },
            path: 'index',
            meta: {
                privilege: 'blog_category.viewer',
            },
        },
        create: {
            component: 'sw-blogCategory-detail',
            path: 'create',
            meta: {
                parentPath: 'sw.blogCategory.index',
                privilege: 'blog_category.creator',
            },
        },
        detail: {
            component: 'sw-blogCategory-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.blogCategory.index',
                privilege: 'blog_category.viewer',
            },
            props: {
                default(route) {
                    return {
                        blogCategoryId: route.params.id,
                    };
                }
            }
        }
    },

    navigation: [{
        label: 'Blog Categories',
        color: '#7036d3',
        path: 'sw.blogCategory.index',
        parent: 'sw-catalogue',
        id: 'sw-blogCategory',
        position: 51,
    }]
});
