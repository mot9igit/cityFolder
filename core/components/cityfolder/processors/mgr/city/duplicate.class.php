<?php
class cityFolderDuplicateProcessor extends modObjectCreateProcessor {
    public $classKey = 'cityFolderCity';
    
    /**
     * var modX
     */
    public function beforeSet() {
		$key = trim($this->getProperty('key'));
        
        if ($this->modx->getCount($this->classKey, array('key' => $key))) {
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
    
    /**
     * var modX
     */
    public function afterSave() {
        $this->modx->cityFolder->duplicateFields($this->getProperty('id'), $this->object->get('id'));
        
        return parent::afterSave();
    }
}

return "cityFolderDuplicateProcessor";