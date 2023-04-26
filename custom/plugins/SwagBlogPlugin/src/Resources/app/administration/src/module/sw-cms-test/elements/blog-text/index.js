import './preview';
import './config';
import './component'

/**
 * @private since v6.5.0
 * @package content
 */
Shopware.Service('cmsService').registerCmsElement({
    name: 'blog-text',
    label: 'sw-cms.elements.blog.text.label',
    component: 'sw-cms-el-blog-text',
    configComponent: 'sw-cms-el-config-blog-text',
    previewComponent: 'sw-cms-el-preview-blog-text',
    defaultConfig: {
        content: {
            source: 'static',
            value: `
                <h2>My First Blog Text</h2>
                <p>India is considered a developing country and is expected to make it to the list of Superpowers in the year 2033.
                 India is the second most populated country in Asia after China.
                  The estimated population of India is 1,296,834,042, as in July 2019.
                  India has astounding features with the Himalayas on the Northern Border and Ganges flowing in the country.
                  New Delhi is the national capital of India.</p>
            `.trim(),
        },
        verticalAlign: {
            source: 'static',
            value: null,
        },
    },
});
