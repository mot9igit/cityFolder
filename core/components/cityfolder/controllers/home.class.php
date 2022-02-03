<?php

/**
 * The home manager controller for cityFolder.
 *
 */
class cityFolderHomeManagerController extends modExtraManagerController
{
    /** @var cityFolder $cityFolder */
    public $cityFolder;


    /**
     *
     */
    public function initialize()
    {
        $this->cityFolder = $this->modx->getService('cityFolder', 'cityFolder', MODX_CORE_PATH . 'components/cityfolder/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['cityfolder:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('cityfolder');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->cityFolder->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/cityfolder.js');
        $this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        cityFolder.config = ' . json_encode($this->cityFolder->config) . ';
        cityFolder.config.connector_url = "' . $this->cityFolder->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "cityfolder-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="cityfolder-panel-home-div"></div>';

        return '';
    }
}