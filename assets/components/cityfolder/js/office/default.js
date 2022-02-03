Ext.onReady(function () {
    cityFolder.config.connector_url = OfficeConfig.actionUrl;

    var grid = new cityFolder.panel.Home();
    grid.render('office-cityfolder-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});