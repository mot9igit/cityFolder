<?php
$cityFolder = $modx->getService('cityFolder', 'cityFolder', MODX_CORE_PATH . 'components/cityfolder/model/', $scriptProperties);
if (!$cityFolder) {
	return 'Could not load cityFolder class!';
}

$tpl = 'cf.sitemap';

/* @var pdoFetch $pdoFetch */
if (!$modx->loadClass('pdofetch', MODX_CORE_PATH . 'components/pdotools/model/pdotools/', false, true)) {return false;}
$pdoFetch = new pdoFetch($modx, $scriptProperties);

$config = $cityFolder->config;

$cities = $modx->getCollection('cityFolderCity');
$urls = array();
$parse = parse_url($url);
$path = explode("/", $parse['path']);
//$modx->log(1, count($cities));
foreach($cities as $city){
	$urls[] = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'].'/'.$city->get('key').$parse['path'];
}
$data = array(
	'urls' => $urls,
	'lastmod' => $lastmod,
	'changefreq' => $changefreq,
	'priority' => $priority,
);
$output = $pdoFetch->getChunk($tpl, $data);
echo $output;