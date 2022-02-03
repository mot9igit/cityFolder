<?php

class cityFolderOfficeItemUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'cityFolderItem';
    public $classKey = 'cityFolderItem';
    public $languageTopics = ['cityfolder'];
    //public $permission = 'save';


    /**
     * We do a special check of permission
     * because our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int)$this->getProperty('id');
        $name = trim($this->getProperty('name'));
        if (empty($id)) {
            return $this->modx->lexicon('cityfolder_item_err_ns');
        }

        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('cityfolder_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name, 'id:!=' => $id])) {
            $this->modx->error->addField('name', $this->modx->lexicon('cityfolder_item_err_ae'));
        }

        return parent::beforeSet();
    }
}

return 'cityFolderOfficeItemUpdateProcessor';
