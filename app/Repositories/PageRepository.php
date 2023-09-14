<?php

namespace App\Repositories;

use App\Contracts\PageContract;
use App\Models\Landlord\Page;

class PageRepository extends BaseRepository implements PageContract
{
    protected $model;

    public function __construct(Page $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }
}