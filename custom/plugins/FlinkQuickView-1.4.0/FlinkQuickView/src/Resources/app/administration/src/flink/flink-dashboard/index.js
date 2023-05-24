import deDE from './snippet/de-DE.json';
import enGB from './snippet/en-GB.json';
import './overview';
import './config-link-override';

Shopware.Locale.extend('de-DE', deDE);
Shopware.Locale.extend('en-GB', enGB);
const { Module } = Shopware;

Module.register('flink-dashboard', {
    type: 'plugin',
    name: 'flink-dashboard',
    title: 'flink-dashboard.title',
    color: '#71d3ad',
    icon: 'default-web-dashboard',
    routes: {
        overview: {
            component: 'flink-dashboard-overview',
            path: 'overview'
        }
    },
    settingsItem: [
        {
            group: 'plugins',
            to: 'flink.dashboard.overview',
            icon: 'default-web-dashboard',
            label: 'flink-dashboard.menuItem'
        }
    ]
});


// Check if modules is already registered (maybe necessary when using same module in multiple plugins)
// if (! Shopware.Module.getModuleRegistry().get("flink-dashboard")) {
//
// }