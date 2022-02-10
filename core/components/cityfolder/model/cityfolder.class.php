<?php

class cityFolder
{
    /** @var modX $modx */
    public $modx;
	public $user_id;
	public $token;

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
		$corePath = $this->modx->getOption('cityfolder_core_path', $config, $this->modx->getOption('core_path') . 'components/cityfolder/');
		$assetsUrl = $this->modx->getOption('cityfolder_assets_url', $config, $this->modx->getOption('assets_url') . 'components/cityfolder/');
		$assetsPath = $this->modx->getOption('cityfolder_assets_path', $config, $this->modx->getOption('base_path') . 'assets/components/cityfolder/');

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
			'version' => '0.0.1',
            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
			'city_fields' => array_merge(['id'], explode(',', $this->modx->getOption('cityfolder_city_fields')), ['actions'])
        ], $config);

        $this->modx->addPackage('cityfolder', $this->config['modelPath']);
        $this->modx->lexicon->load('cityfolder:default');
    }

	/**
	 * Run processor
	 * @param type $name
	 * @param type $params
	 * @return type
	 */
	public function runProcessor($name = '', $params = array()) {
		return $this->modx->runProcessor($name, $params, array('processors_path' => $this->config['processorsPath']))->response;
	}

	/**
	 * Base fields
	 * @return type
	 */
	public function fields() {
		return array(
			1 => 'key',
			2 => 'city',
			3 => 'city_r',
			4 => 'phone',
			5 => 'email',
			6 => 'address',
			7 => 'address_full',
			8 => 'address_coordinats',
		);
	}

	/**
	 * Get coordinats
	 * @param type $address
	 * @return type
	 */
	public function getCoordinats ($address) {
		$yandex = file_get_contents("https://geocode-maps.yandex.ru/1.x/?format=json&geocode=".$address);
		$json = json_decode($yandex, true);
		$output = str_replace(' ',',', $json["response"]["GeoObjectCollection"]["featureMember"][0]["GeoObject"]["Point"]["pos"]);
		$array = explode(",", $output);

		return  $array[1].','.$array[0];
	}

	/**
	 * Get more fields
	 * @param type $domain_id
	 * @return type
	 */
	public function getFields($domain_id) {
		/* @var pdoFetch $pdoFetch */
		if (!$pdo = $this->modx->getService('pdoFetch')) {
			return 'Could not load pdoFetch class!';
		}

		$response = $pdo->getCollection('cityFolderFields', array('city' => $domain_id));

		$output = [];

		if (count($response)) {
			foreach ($response as $item) {
				$output[$item['key']] = $item['value'];
			}
		}

		return $output;
	}

	/**
	 * Duplicate morefields
	 * @param type $old_item
	 * @param type $new_item
	 */
	public function duplicateFields($old_item, $new_item) {
		$fields = $this->modx->getCollection('cityFolderFields', array('city' => $old_item));

		if (count((array)$fields)) {
			foreach ($fields as $item) {
				$fields = $this->modx->newObject('cityFolderFields');

				$fields->set('city', $new_item);
				$fields->set('name', $item->name);
				$fields->set('key', $item->key);
				$fields->set('value', $item->value);

				$fields->save();
			}
		}
	}

	/**
	 * Load custom js & css
	 */
	public function loadCustomJsCss (){
		$this->modx->controller->addCss($this->config['cssUrl'] . 'mgr/cityfolder.css?v='.$this->config['version']);
		$this->modx->controller->addJavascript($this->config['jsUrl'] . 'mgr/cityfolder.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/utils/utils.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/utils/combo.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/widgets/resource.tab.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/widgets/resource.panel.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/widgets/resource.grid.js?v='.$this->config['version']);
		$this->modx->controller->addLastJavascript($this->config['jsUrl'] . 'mgr/widgets/resource.windows.js?v='.$this->config['version']);

		$this->modx->controller->addHtml('<script>
            Ext.onReady(function() {
                cityFolder.config = ' . json_encode($this->config) . ';
                cityFolder.config.connector_url = "' . $this->config['connectorUrl'] . '";
            });
        </script>');

		$this->modx->controller->addLexiconTopic('cityfolder:default');
	}

	/**
	 * Get city name by domain id
	 * @param type $domain_id
	 * @return type
	 */
	public function getCityNameById($domain_id) {
		$response = $this->modx->getObject('cityFolderCity', ['id' => $domain_id]);

		return $response->city;
	}

	/**
	 * Get domain id by domain
	 * @param type $city
	 * @return type
	 */
	public function getDomainId($city) {
		$response = $this->modx->getObject('cityFolderCity', ['key' => $city]);

		if (!$response) return false;

		return $response->id;
	}

	/**
	 * Get resource content
	 * @param type $city
	 * @param type $resource
	 * @return type
	 */
	public function getContent($city, $resource) {
		$response = $this->modx->getObject('cityFolderResource', ['city' => $this->getDomainId($city), 'resource' => $resource]);

		if (!$response) return false;

		return $response->content;
	}

	/**
	 * @return int, bool
	 */
	public function detectCity()
	{
		$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$parse = parse_url($url);
		$path = explode("/", $parse['path']);
		$key = $path[1];
		// Ведущий слэш и первый каталог убираем, проверяем на наличие в компоненте
		unset($path[0]);
		unset($path[1]);
		$id = $this->getDomainId($key);
		return $id;
	}

	public function cleanUrl(){
		if($this->detectCity()){
			$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$parse = parse_url($url);
			$path = explode("/", $parse['path']);
			$key = $path[1];
			// Ведущий слэш и первый каталог убираем, проверяем на наличие в компоненте
			unset($path[0]);
			unset($path[1]);
			return implode('/', $path);
		}
	}

	/**
	 * @return int, bool
	 */
	public function setCity($city)
	{
		$response = $this->modx->getObject('cityFolderCity', $city);
		if($response){
			$siteUrl = $this->modx->getOption('site_url');
			$this->modx->setOption('site_url', $siteUrl."{$response->key}/");
			$this->modx->setOption('base_url', $siteUrl."{$response->key}/");
			$this->modx->setPlaceholder('+site_url', $siteUrl."{$response->key}/");
		}
	}

	/**
	 * @return bool
	 */
	public function isAjaxRequest()
	{
		if (
			isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
		) {
			return true;
		}
		return false;
	}

	/**
	 * @return false
	 */
	public function isAjaxRequestInAssets()
	{
		if (!$this->isAjaxRequest()) return false;
		$assetsUrl = $this->modx->getOption('assets_url', null, MODX_ASSETS_URL);
		$assetsUrl = preg_quote($assetsUrl, '/');
		return (bool)preg_match("/^{$assetsUrl}/", $_SERVER['REQUEST_URI']);

	}
}