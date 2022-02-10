<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var cityFolder $cityFolder */
$cityFolder = $modx->getService('cityFolder', 'cityFolder', MODX_CORE_PATH . 'components/cityfolder/model/', $scriptProperties);
if (!$cityFolder) {
	return 'Could not load cityFolder class!';
}

/* @var pdoFetch $pdoFetch */
if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {return false;}
$pdoFetch = new pdoFetch($modx, $scriptProperties);

$config = $cityFolder->config;

// Set default parameters
$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.cityFolder.city');
$activeClass = $modx->getOption('activeClass', $scriptProperties, 'active');
$sortby = $modx->getOption('sortby', $scriptProperties, 'city');
$sortdir = $modx->getOption('sortdir', $scriptProperties, 'ASC');
$limit = $modx->getOption('limit', $scriptProperties, '');
$showLog = $modx->getOption('showLog', $scriptProperties, 0);
$js = $modx->getOption('frontend_js', $scriptProperties, $config['jsUrl'] . "web/default.js");

if (!empty($js) && preg_match('/\.js/i', $js)) {
	$modx->regClientScript($js);
}

$default = array(
	'class' => 'cityFolderCity',
	'sortby' => $sortby,
	'sortdir' => $sortdir,
	'limit' => $limit,
	'fastMode' => false,
	'return' => 'data',
);

$pdoFetch->setConfig(array_merge($default, $scriptProperties));
$rows = $pdoFetch->run();

// Processing data
$pdoFetch->addTime('Parsing data');
$output = array();

// TODO: active class and link
foreach ($rows as $row) {
	// check city folder
	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$parse = parse_url($url);
	$path = explode("/", $parse['path']);
	$key = $path[1];
	$id = $cityFolder->getDomainId($key);
	// город найден
	unset($path[0]);
	if($id){
		unset($path[1]);
		$page_uri = implode("/", $path);
	}else{
		$page_uri = implode("/", $path);
	}
	$modx->log(1, $page_uri);
	$output[] = array_merge($row, array(
		'active' => $row['key'] == $_SERVER['HTTP_HOST'] ? $activeClass : '',
		'link' => "//{$_SERVER['HTTP_HOST']}/{$row['key']}/{$page_uri}"
	));
}

$pdoFetch->addTime('Returning parsed data');

// Return output
$log = '';
if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
	$log .= '<pre class="SeodomainsLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';
}

$output = $pdoFetch->getChunk($tpl, array('rows' => $output));

$output .= $log;

return $output;