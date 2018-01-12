<?php

namespace App\Repositories;

use Schema;

class BasicRepository
{
    protected $mainModel;
    /**
     * [getTableColumnList get table all columns]
     * @param  Eloquent $obj 表頭或表身的Eloquent
     * @return array      all columns
     */
    protected function getTableColumnList($model)
    {
        return Schema::getColumnListing($model->getTable());
    }

    public function getNew() {
         return $this->mainModel->newInstance();
    }
}