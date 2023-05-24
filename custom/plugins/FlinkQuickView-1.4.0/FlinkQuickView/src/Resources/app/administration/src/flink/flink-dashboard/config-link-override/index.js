const { Application, Component } = Shopware;

Component.override('sw-plugin-list', {
    methods: {
        onPluginSettings(plugin) {
            if (plugin.name.indexOf('Flink') === 0) {
                this.$router.push({name: 'flink.dashboard.overview', params: {namespace: plugin.name}});
            } else {
                this.$router.push({ name: 'sw.plugin.settings', params: { namespace: plugin.name } });
            }
        },
    }
});
