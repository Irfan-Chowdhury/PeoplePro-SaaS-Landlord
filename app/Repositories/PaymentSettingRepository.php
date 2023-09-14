<?php

namespace App\Repositories;

use App\Contracts\PaymentSettingContract;
use App\Models\Landlord\PaymentSetting;

class PaymentSettingRepository extends BaseRepository implements PaymentSettingContract
{
    protected $model;

    public function __construct(PaymentSetting $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }
}