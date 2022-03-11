<?php
class cityFolderCityCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'cityFolderCity';
    
    /**
     * var modX
     */
    public function beforeSet() {
        $key = trim($this->getProperty('key'));
        
        if ($this->modx->getCount($this->classKey, array('domain' => $key))) {
            $this->modx->error->addField('key', $this->modx->lexicon('cityfolder_err_name_ae'));
        } else {
        
            // Set coordinats
            if ($this->getProperty('address_full')) {
                $this->setProperty('address_coordinats', $this->modx->cityFolder->getCoordinats($this->getProperty('address_full')));
            } elseif ($this->getProperty('address')) {
                $this->setProperty('address_coordinats', $this->modx->cityFolder->getCoordinats($this->getProperty('address')));
            }
        }
        
        return parent::beforeSet();
    }
}

return "cityFolderCityCreateProcessor";