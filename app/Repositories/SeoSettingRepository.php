<?php

namespace App\Repositories;

use App\Contracts\SeoSettingContract;
use App\Models\Landlord\SeoSetting;

class SeoSettingRepository extends BaseRepository implements SeoSettingContract
{
    protected $model;

    public function __construct(SeoSetting $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }
}