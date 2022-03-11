<?php
/** @var cityFolder $cityFolder */
$corePath = $modx->getOption('cityfolder_core_path', null, $modx->getOption('core_path') . 'components/cityfolder/');
$cityFolder = $modx->getService('cityFolder', 'cityFolder', $corePath . 'model/');
if (!$cityFolder) {
	return 'Could not load cityFolder class!';
}

switch ($modx->event->name) {
	case 'OnHandleRequest':
		if ($modx->context->get('key') == 'mgr' || $cityFolder->isAjaxRequestInAssets()) {
			return;
		}
		// !!! add include path parameters
		$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$parse = parse_url($url);
		$path = explode("/", $parse['path']);
		$key = $path[1];
		// Ведущий слэш и первый каталог убираем, проверяем на наличие в компоненте
		unset($path[0]);
		unset($path[1]);
		if(count($path) != 1){
			$page_uri = implode("/", $path);
			$criteria = array(
				"uri" => $page_uri
			);
			$res = $modx->getObject("modResource", $criteria);
		}else{
			$res = $modx->getObject("modResource", $modx->getOption('site_start'));
		}
		$needle_id = explode(",", $modx->getOption("cityfolder_catalogs"));
		if(count($needle_id)) {
			// local mode
			$id = $res->id;
			//$modx->log(1, $id);
			$pids = $modx->getParentIds($id, 10, array('context' => 'web'));
			$searcher = false;
			if (in_array($id, $needle_id)) {
				$searcher = true;
			}
			foreach ($pids as $pid) {
				if (in_array($pid, $needle_id)) {
					$searcher = true;
				}
			}
			if ($searcher) {
				if ($city = $cityFolder->detectCity()) {
					$cityFolder->setCity($city);
				}
			}
		}else{
			// global mode
			if ($city = $cityFolder->detectCity()) {
				$cityFolder->setCity($city);
			}
		}
		break;
	case 'OnPageNotFound':
		/* @var pdoFetch $pdoFetch */
		if (!$pdo = $modx->getService('pdoFetch')) {
			return 'Could not load pdoFetch class!';
		}

		// TODO: exclude catalogs with setting "catalogs"
		$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$parse = parse_url($url);
		$path = explode("/", $parse['path']);
		$key = $path[1];
		// Ведущий слэш и первый каталог убираем, проверяем на наличие в компоненте
		unset($path[0]);
		unset($path[1]);
		$id = $cityFolder->getDomainId($key);
		// город найден
		if($id){

			if(count($path) >= 1){
				$page_uri = implode("/", $path);
				$criteria = array(
					"uri" => $page_uri
				);
				//$modx->log(1, print_r($criteria, 1));
				$res = $modx->getObject("modResource", $criteria);
				if(!$res){
					$res = $modx->getObject("modResource", $modx->getOption('site_start'));
				}
			}else{
				$res = $modx->getObject("modResource", $modx->getOption('site_start'));
			}
			$needle_id = explode(",", $modx->getOption("cityfolder_catalogs"));
			$id = $res->get("id");
			$modx->log(1, $id);
			$pids = $modx->getParentIds($id, 10, array('context' => 'web'));
			$searcher = false;
			if(count($needle_id)){
				// local mode
				if(in_array($id, $needle_id)){
					$searcher = true;
				}
				foreach($pids as $pid){
					if(in_array($pid, $needle_id)){
						$searcher = true;
					}
				}
				if($searcher){
					// формируем плейсхолдеры
					$response = $pdo->getArray('cityFolderCity', array('key' => $key));
					if (count($response)) {
						$fields = $cityFolder->getFields($response['id']);
						$modx->setPlaceholders(array_merge($response, $fields), $modx->getOption('cityfolder_phx_prefix'));
					}
					$modx->sendForward($res->id);
				}else{
					$url = $modx->makeUrl($res->id);
					$modx->sendRedirect($url);
				}
			}else{
				// global mode
				if($res){
					// формируем плейсхолдеры
					$response = $pdo->getArray('cityFolderCity', array('key' => $key));

					if (count($response)) {
						$fields = $cityFolder->getFields($response['id']);
						$modx->setPlaceholders(array_merge($response, $fields), $modx->getOption('cityfolder_phx_prefix'));
					}
					$modx->sendForward($res->id);
				}else{
					$url = $modx->makeUrl($res->id);
					$modx->sendRedirect($url);
				}
			}
		}

		break;

	case 'OnDocFormRender':
		$controller->cityFolder = $cityFolder = $modx->getService('cityFolder', 'cityFolder', MODX_CORE_PATH . 'components/cityfolder/model/', $scriptProperties);

		$controller->cityFolder->loadCustomJsCss();

		$modx->regClientStartupHTMLBlock('
            <script type="text/javascript">
                Ext.onReady(function() {
                    // cityFolder.config.richtext = ' . $resource->richtext . ';
                });
            </script>
        ');
		break;

	case 'OnLoadWebDocument':
		$content = $cityFolder->getContent($_SERVER['HTTP_HOST'], $modx->resource->id);

		if (!$content) return ;

		$modx->resource->cacheable = 0;
		$modx->resource->content = $content;
		break;
}