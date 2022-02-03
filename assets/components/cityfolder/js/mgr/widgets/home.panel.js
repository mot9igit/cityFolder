cityFolder.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'cityfolder-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('cityfolder') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('cityfolder_items'),
                layout: 'anchor',
                items: [{
                    html: _('cityfolder_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'cityfolder-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    cityFolder.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.panel.Home, MODx.Panel);
Ext.reg('cityfolder-panel-home', cityFolder.panel.Home);
