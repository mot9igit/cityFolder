<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var cityFolder $cityFolder */
$cityFolder = $modx->getService('cityFolder', 'cityFolder', MODX_CORE_PATH . 'components/cityfolder/model/');
$modx->lexicon->load('cityfolder:default');

// handle request
$corePath = $modx->getOption('cityfolder_core_path', null, $modx->getOption('core_path') . 'components/cityfolder/');
$path = $modx->getOption('processorsPath', $cityFolder->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);