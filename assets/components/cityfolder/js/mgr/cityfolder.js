var cityFolder = function (config) {
    config = config || {};
    cityFolder.superclass.constructor.call(this, config);
};
Ext.extend(cityFolder, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('cityfolder', cityFolder);

cityFolder = new cityFolder();