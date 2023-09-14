<?php

namespace App\Repositories;

use App\Contracts\PackageContract;
use App\Models\Landlord\Package;

class PackageRepository extends BaseRepository implements PackageContract
{
    protected $model;

    public function __construct(Package $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }
}