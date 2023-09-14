<?php

namespace App\Contracts;

interface TenantContract extends BaseContract
{
    public function getDataByCondition($condition);

}
