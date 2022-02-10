cityFolder.panel.Resource = function (config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cityfolder-panel-resource',
        autoHeight: true,
        layout: 'form',
        anchor: '99%',
        items: [{
            xtype: 'cityfolder-grid-resource',
            cls: 'main-wrapper',
            record: config.record
        }]
    });
    cityFolder.panel.Resource.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.panel.Resource, MODx.Panel);
Ext.reg('cityfolder-panel-resource', cityFolder.panel.Resource);
