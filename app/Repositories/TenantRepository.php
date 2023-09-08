<?php

namespace App\Repositories;

use App\Contracts\TenantContract;
use App\Models\Tenant;

class TenantRepository extends BaseRepository implements TenantContract
{
    protected $model;

    public function __construct(Tenant $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }

    public function getDataByCondition($condition) 
    {
        return $this->model->where($condition)->get();
    }

}
