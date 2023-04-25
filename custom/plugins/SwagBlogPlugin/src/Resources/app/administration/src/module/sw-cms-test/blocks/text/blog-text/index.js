import './component';
import './preview';

Shopware.Service('cmsService').registerCmsBlock({
    name: 'blog-text',
    label: 'sw-cms-test.blocks.text.blog-text.label',
    category: 'text',
    component: 'sw-cms-block-test',
    previewComponent: 'sw-cms-preview-test',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed',
    },
    slots: {
        content: 'text',
    },
});
