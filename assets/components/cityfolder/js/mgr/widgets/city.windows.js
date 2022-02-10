cityFolder.window.City = function (config) {
    config = config || {};
    config.record = config.record || {object: {id: 0}};
    Ext.applyIf(config, {
        title: _('add'),
        url: cityFolder.config.connector_url,
        width:800,
        action: 'mgr/city/create',
        saveBtnText:_('add'),
        fields: [{
            xtype: 'textfield',
            name: 'key',
            fieldLabel: _('cityfolder_city_grid_key'),
            emptyText: _('cityfolder_city_grid_key_empty'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'city',
            fieldLabel: _('cityfolder_city_grid_city'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'city_r',
            fieldLabel: _('cityfolder_city_grid_city_r'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'phone',
            fieldLabel: _('cityfolder_city_grid_phone'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textfield',
            name: 'email',
            fieldLabel: _('cityfolder_city_grid_email'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textarea',
            name: 'address',
            fieldLabel: _('cityfolder_city_grid_address'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textarea',
            name: 'address_full',
            fieldLabel: _('cityfolder_city_grid_address_full'),
            anchor: '99%',
            allowBlank: true
        }]
    });
    cityFolder.window.City.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.window.City, MODx.Window);
Ext.reg('cityfolder-window-city', cityFolder.window.City);

cityFolder.window.UpdateCity = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'cityfolder-window-city';
    }
    Ext.applyIf(config, {
        title: _('update'),
        autoHeight: true,
        fields: this.getFields(config),
        url: cityFolder.config.connector_url,
        action: 'mgr/city/update',
        width: 800
    });
    cityFolder.window.UpdateCity.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.window.UpdateCity, MODx.Window, {
    getFields: function (config) {
        var tabs = [{
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items:[{
                title: _('cityfolder_window_main'),
                layout: 'anchor',
                items: [{
                    layout: 'column',
                    border: 'false',
                    anchor: '100%',
                    items:[{
                        columnWidth: 1,
                        layout: 'form',
                        defaults: {msTarget: 'under'},
                        border: 'false',
                        items: [{
                            xtype: 'hidden',
                            name: 'id',
                            id: config.id + '-id',
                        }, {
                            xtype: 'textfield',
                            name: 'key',
                            fieldLabel: _('cityfolder_city_grid_key'),
                            anchor: '99%',
                            allowBlank: false
                        }, {
                            xtype: 'textfield',
                            name: 'city',
                            fieldLabel: _('cityfolder_city_grid_city'),
                            anchor: '99%',
                            allowBlank: false
                        }, {
                            xtype: 'textfield',
                            name: 'city_r',
                            fieldLabel: _('cityfolder_city_grid_city_r'),
                            anchor: '99%',
                            allowBlank: false
                        },{
                            xtype: 'textfield',
                            name: 'phone',
                            fieldLabel: _('cityfolder_city_grid_phone'),
                            anchor: '99%',
                            allowBlank: true
                        },{
                            xtype: 'textfield',
                            name: 'email',
                            fieldLabel: _('cityfolder_city_grid_email'),
                            anchor: '99%',
                            allowBlank: true
                        },{
                            xtype: 'textarea',
                            name: 'address',
                            fieldLabel: _('cityfolder_city_grid_address'),
                            anchor: '99%',
                            allowBlank: true
                        },{
                            xtype: 'textarea',
                            name: 'address_full',
                            fieldLabel: _('cityfolder_city_grid_address_full'),
                            anchor: '99%',
                            allowBlank: true
                        },{
                            xtype: 'textfield',
                            name: 'address_coordinats',
                            fieldLabel: _('cityfolder_city_grid_address_coordinats'),
                            anchor: '99%',
                            allowBlank: true
                        }]
                    }]
                }]
            },{
                title: _('cityfolder_window_fields'),
                layout: 'anchor',
                items:[{
                    layout: 'column',
                    border: 'false',
                    anchor: '100%',
                    items:[{
                        xtype: 'cityfolder-grid-fields',
                        preventRender: true,
                        record: config.record.object
                    }]
                }]
            }]
        }];
    
        return tabs;
    },

    loadDropZones: function () {
    }

});
Ext.reg('cityfolder-city-window-update', cityFolder.window.UpdateCity);

cityFolder.window.DuplicateCity = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'cityfolder-window-city-duplicate';
    }
    Ext.applyIf(config, {
        title: _('duplicate'),
        autoHeight: true,
        fields: this.getFields(config),
        url: cityFolder.config.connector_url,
        action: 'mgr/city/duplicate',
        width: 800
    });
    cityFolder.window.DuplicateCity.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.window.DuplicateCity, MODx.Window, {
    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-duplicate_id',
        },{
            xtype: 'textfield',
            name: 'key',
            fieldLabel: _('cityfolder_city_grid_key'),
            emptyText: _('cityfolder_city_grid_key_empty'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'city',
            fieldLabel: _('cityfolder_city_grid_city'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'city_r',
            fieldLabel: _('cityfolder_city_grid_city_r'),
            anchor: '99%',
            allowBlank: false
        },{
            xtype: 'textfield',
            name: 'phone',
            fieldLabel: _('cityfolder_city_grid_phone'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textfield',
            name: 'email',
            fieldLabel: _('cityfolder_city_grid_email'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textarea',
            name: 'address',
            fieldLabel: _('cityfolder_city_grid_address'),
            anchor: '99%',
            allowBlank: true
        },{
            xtype: 'textarea',
            name: 'address_full',
            fieldLabel: _('cityfolder_city_grid_address_full'),
            anchor: '99%',
            allowBlank: true
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('cityfolder-city-window-duplicate', cityFolder.window.DuplicateCity);