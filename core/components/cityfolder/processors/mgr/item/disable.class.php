<?php

class cityFolderItemDisableProcessor extends modObjectProcessor
{
    public $objectType = 'cityFolderItem';
    public $classKey = 'cityFolderItem';
    public $languageTopics = ['cityfolder'];
    //public $permission = 'save';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('cityfolder_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var cityFolderItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('cityfolder_item_err_nf'));
            }

            $object->set('active', false);
            $object->save();
        }

        return $this->success();
    }

}

return 'cityFolderItemDisableProcessor';
