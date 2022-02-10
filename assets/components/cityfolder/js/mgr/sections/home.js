cityFolder.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        xtype: 'cityfolder-panel-home',
        renderTo: 'cityfolder-panel-home-div',
        cls: 'container',
        items: [{
            html: '<h2>'+_('cityfolder')+'</h2>'
        }, {
            xtype: 'modx-tabs',
            items: [{
                title: _('cityfolder_panel_main'),
                items: [{
                    html: _('cityfolder_panel_main_desc'),
                    cls: 'panel-desc',
                },{
                    xtype: 'panel',
                    cls: 'container',
                    items: [{
                        xtype: 'cityfolder-grid-city'
                    }]
                }]
            }]
        }]
    });
    cityFolder.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder.panel.Home, MODx.Panel);
Ext.reg('cityfolder-page-home', cityFolder.panel.Home);