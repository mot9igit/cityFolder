cityFolder.combo.Search = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        xtype: 'twintrigger',
        ctCls: 'x-field-search',
        allowBlank: true,
        msgTarget: 'under',
        emptyText: _('search'),
        name: 'query',
        triggerAction: 'all',
        clearBtnCls: 'x-field-search-clear',
        searchBtnCls: 'x-field-search-go',
        onTrigger1Click: this._triggerSearch,
        onTrigger2Click: this._triggerClear,
    });
    cityFolder.combo.Search.superclass.constructor.call(this, config);
    this.on('render', function () {
        this.getEl().addKeyListener(Ext.EventObject.ENTER, function () {
            this._triggerSearch();
        }, this);
    });
    this.addEvents('clear', 'search');
};
Ext.extend(cityFolder.combo.Search, Ext.form.TwinTriggerField, {

    initComponent: function () {
        Ext.form.TwinTriggerField.superclass.initComponent.call(this);
        this.triggerConfig = {
            tag: 'span',
            cls: 'x-field-search-btns',
            cn: [
                {tag: 'div', cls: 'x-form-trigger ' + this.searchBtnCls},
                {tag: 'div', cls: 'x-form-trigger ' + this.clearBtnCls}
            ]
        };
    },

    _triggerSearch: function () {
        this.fireEvent('search', this);
    },

    _triggerClear: function () {
        this.fireEvent('clear', this);
    },

});
Ext.reg('cityfolder-combo-search', cityFolder.combo.Search);
Ext.reg('cityfolder-field-search', cityFolder.combo.Search);

cityFolder.combo.City = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: cityFolder.config.connector_url,
        baseParams: {
            action: 'mgr/load/city',
        },
        name: 'city',
        hiddenName: 'city',
        fields: ['id', 'city'],
        mode: 'remote',
        displayField: 'city',
        fieldLabel: _('cityfolder_city_grid_city'),
        valueField: 'id',
        editable: true,
        anchor: '99%',
        allowBlank: false,
        autoLoad: false
    });
    cityFolder.combo.City.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.combo.City, MODx.combo.ComboBox);
Ext.reg('cityfolder-combo-city', cityFolder.combo.City);