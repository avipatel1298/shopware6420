const {Component, Mixin} = Shopware;
const {Criteria} = Shopware.Data;

import template from './flink-dashboard-overview.html.twig';
import './flink-dashboard.scss';

Component.register('flink-dashboard-overview', {
    template,

    inject: [
        'repositoryFactory'
    ],

    mixins: [
        Mixin.getByName('notification')
    ],

    data() {
        return {
            activeFlinkPlugins: [],
            displayPlugins: [],
            flinkFeed: {}
        }
    },

    computed: {
        pluginRepository() {
            return this.repositoryFactory.create('plugin');
        },

        locale() {
            const locales = this.flinkFeed.locales || ['de-DE','en-GB'];
            const locale = this.$root.$i18n.locale;
            if (locales.indexOf(locale) > -1) {
                return this.$root.$i18n.locale;
            }
            return 'en-GB';
        },

        defaultConfigPlugin() {
            const activePlugins = this.activeFlinkPlugins.map(plugin => plugin.name);
            const namespaceParam = this.$root.$route.params.namespace;

            if (namespaceParam && activePlugins.indexOf(namespaceParam) > -1) {
                return namespaceParam;
            }

            if (this.activeFlinkPlugins[0]) {
                return this.activeFlinkPlugins[0].name;
            }

            return '';
        },

        parentRoute() {
            return this.$root.$route.params.namespace ? "sw.plugin.index" : "sw.settings.index";
        }
    },

    created() {
        if (this.$root.$route.params.namespace) {
            this.$route.meta.parentPath = "sw.plugin.index";
        }
        this.loadActiveFlinkPlugins();
    },

    mounted() {

    },

    methods: {
        loadActiveFlinkPlugins() {
            const criteria = new Criteria();
            criteria.addFilter(
                Criteria.multi('AND', [Criteria.contains('plugin.name', 'flink'),Criteria.equals('active', 1)])
            );
            this.pluginRepository.search(criteria, Shopware.Context.api).then((result) => {
                this.activeFlinkPlugins = result;
                this.loadFlinkFeed();
            })
        },

        loadFlinkFeed() {
            fetch('http://flinkfactory.com/flinkfeed.json')
                .then(response => response.json())
                .then((data) => {
                    this.flinkFeed = data;
                    if (this.flinkFeed.plugins) {
                        const activePlugins = this.activeFlinkPlugins.map(plugin => plugin.name);
                        this.displayPlugins = this.flinkFeed.plugins.filter(plugin => activePlugins.indexOf(plugin.name) === -1);
                    }
                    this.addEventListeners();
                });
        },

        addEventListeners() {
            const flinkDashboard = document.getElementById('flinkDashboard');
            const pluginShowcaseMain = this.$refs.pluginShowcaseMain;
            pluginShowcaseMain.addEventListener('mousemove', (event) => {
                const mouseX = event.clientX - pluginShowcaseMain.offsetLeft - flinkDashboard.offsetLeft;
                const width = pluginShowcaseMain.offsetWidth;
                const scrollWidth = pluginShowcaseMain.scrollWidth;
                const posPercent = mouseX / width;
                const widthDiff = scrollWidth - width;
                pluginShowcaseMain.scrollLeft = posPercent * widthDiff;
            });
        },

        onSave(pluginName) {
            const pluginSystemConfig = this.$refs['systemConfig_' + pluginName][0];
            pluginSystemConfig.saveAll().then(() => {
                this.createNotificationSuccess({
                    message: this.$tc('sw-plugin-config.messageSaveSuccess')
                });
            }).catch((err) => {
                this.createNotificationError({
                    message: err
                });
            });
        }
    }
});
