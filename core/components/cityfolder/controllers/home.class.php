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
		$corePath = $this->modx->getOption('cityfolder_core_path', array(), $this->modx->getOption('core_path') . 'components/cityfolder/');
		$this->cityFolder = $this->modx->getService('cityFolder', 'cityFolder', $corePath . 'model/');

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
        $this->addCss($this->cityFolder->config['cssUrl'] . 'mgr/cityfolder.css?v='.$this->cityFolder->config['version']);
        $this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/cityfolder.js?v='.$this->cityFolder->config['version']);
		$this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/utils/utils.js?v='.$this->cityFolder->config['version']);
		$this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/utils/combo.js?v='.$this->cityFolder->config['version']);
		$this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/sections/home.js?v='.$this->cityFolder->config['version']);
		$this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/widgets/city.grid.js?v='.$this->cityFolder->config['version']);
		$this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/widgets/fields.grid.js?v='.$this->cityFolder->config['version']);
		$this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/widgets/city.windows.js?v='.$this->cityFolder->config['version']);
		$this->addJavascript($this->cityFolder->config['jsUrl'] . 'mgr/widgets/fields.windows.js?v='.$this->cityFolder->config['version']);

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