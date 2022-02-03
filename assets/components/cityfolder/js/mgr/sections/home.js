cityFolder.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'cityfolder-panel-home',
            renderTo: 'cityfolder-panel-home-div'
        }]
    });
    cityFolder.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.page.Home, MODx.Component);
Ext.reg('cityfolder-page-home', cityFolder.page.Home);