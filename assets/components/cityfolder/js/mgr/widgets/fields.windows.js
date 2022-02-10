cityFolder.window.Fields = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('add'),
        url: cityFolder.config.connector_url,
        width:600,
        action: 'mgr/fields/create',
        saveBtnText:_('add'),
        fields: [{
            xtype: 'hidden',
            name: 'city',
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'name',
            fieldLabel: _('cityfolder_fields_grid_name'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'key',
            fieldLabel: _('cityfolder_fields_grid_key'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textarea',
            name: 'value',
            fieldLabel: _('cityfolder_fields_grid_value'),
            anchor: '99%',
            allowBlank: false
        }]
    });
    cityFolder.window.Fields.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.window.Fields, MODx.Window);
Ext.reg('cityfolder-window-fields', cityFolder.window.Fields);

cityFolder.window.UpdateFields = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'cityfolder-window-fields-update';
    }
    Ext.applyIf(config, {
        title: _('update'),
        autoHeight: true,
        fields: this.getFields(config),
        url: cityFolder.config.connector_url,
        action: 'mgr/fields/update',
        width: 600
    });
    cityFolder.window.UpdateFields.superclass.constructor.call(this, config);            
};
Ext.extend(cityFolder.window.UpdateFields, MODx.Window, {
    getFields: function (config) {
        
        return [{
            xtype: 'hidden',
            name: 'id',
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'name',
            fieldLabel: _('cityfolder_fields_grid_name'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'key',
            fieldLabel: _('cityfolder_fields_grid_key'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textarea',
            name: 'value',
            fieldLabel: _('cityfolder_fields_grid_value'),
            anchor: '99%',
            allowBlank: false
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('cityfolder-fields-window-update', cityFolder.window.UpdateFields);