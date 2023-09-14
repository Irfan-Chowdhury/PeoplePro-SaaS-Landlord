<?php

namespace App\Repositories;

use App\Contracts\AnalyticSettingContract;
use App\Models\Landlord\AnalyticSetting;

class AnalyticSettingRepository extends BaseRepository implements AnalyticSettingContract
{
    protected $model;

    public function __construct(AnalyticSetting $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }
}