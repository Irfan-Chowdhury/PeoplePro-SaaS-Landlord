<?php

namespace App\Repositories;

use App\Contracts\TenantSignupDescriptionContract;
use App\Models\Landlord\TenantSignupDescription;

class TenantSignupDescriptionRepository extends BaseRepository implements TenantSignupDescriptionContract
{
    protected $model;

    public function __construct(TenantSignupDescription $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }
}