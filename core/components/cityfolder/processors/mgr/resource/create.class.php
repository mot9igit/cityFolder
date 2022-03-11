<?php
class cityFolderResourceCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'cityFolderResource';
    
    /**
     * var modX
     */
    public function beforeSet() {
        $city = trim($this->getProperty('city'));
        $resource = trim($this->getProperty('resource'));

        if ($this->modx->getCount($this->classKey, ['city' => $city, 'resource' => $resource])) {
            $this->modx->error->addField('domain', $this->modx->lexicon('cityfolder_resource_domain_ae'));
        }
        
        return parent::beforeSet();
    }
}

return "cityFolderResourceCreateProcessor";