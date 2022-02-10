cityFolder.window.CreateCFResource = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('add'),
        url: cityFolder.config.connector_url,
        width: 700,
        autoHeight: true,
        action: 'mgr/resource/create',
        saveBtnText:_('add'),
        fields: [{
            xtype: 'hidden',
            name: 'resource',
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'cityfolder-combo-city',
            name: 'city',
            fieldLabel: _('cityfolder_resource_grid_city'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textarea',
            name: 'content',
            fieldLabel: _('cityfolder_resource_grid_content'),
            anchor: '100%',
            allowBlank: false,
            height: 400,
            id: config.id + '-content',
            listeners: {
                render: function (config) {
                    if (MODx.loadRTE && cityFolder.config.richtext == 1) {
                        window.setTimeout(function() {
                            MODx.loadRTE(config.id);
                        }, 300);
                    }
                }
            }
        }]
    });
    cityFolder.window.CreateCFResource.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.window.CreateCFResource, MODx.Window);
Ext.reg('cityfolder-window-resource', cityFolder.window.CreateCFResource);

cityFolder.window.UpdateResource = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'cityfolder-window-resource-update';
    }
    Ext.applyIf(config, {
        title: _('update'),
        autoHeight: true,
        fields: this.getFields(config),
        url: cityFolder.config.connector_url,
        action: 'mgr/resource/update',
        width: 700
    });
    cityFolder.window.UpdateResource.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.window.UpdateResource, MODx.Window, {
    getFields: function (config) {
        
        return [{
            xtype: 'hidden',
            name: 'id',
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'cityfolder-combo-city',
            name: 'city',
            fieldLabel: _('cityfolder_resource_grid_city'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textarea',
            name: 'content',
            fieldLabel: _('cityfolder_resource_grid_content'),
            anchor: '100%',
            allowBlank: false,
            height: 400,
            id: config.id + '-content',
            listeners: {
                render: function (config) {
                    if (MODx.loadRTE && cityFolder.config.richtext == 1) {
                        window.setTimeout(function() {
                            MODx.loadRTE(config.id);
                        }, 300);
                    }
                }
            }
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('cityfolder-resource-window-update', cityFolder.window.UpdateResource);