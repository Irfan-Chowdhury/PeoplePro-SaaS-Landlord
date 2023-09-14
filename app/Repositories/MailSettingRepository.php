<?php

namespace App\Repositories;

use App\Contracts\MailSettingContract;
use App\Models\Landlord\MailSetting;

class MailSettingRepository extends BaseRepository implements MailSettingContract
{
    protected $model;

    public function __construct(MailSetting $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }
}