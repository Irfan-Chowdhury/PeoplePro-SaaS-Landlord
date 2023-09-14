<?php

namespace App\Repositories;

use App\Contracts\BlogContract;
use App\Models\Landlord\Blog;

class BlogRepository extends BaseRepository implements BlogContract
{
    protected $model;

    public function __construct(Blog $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }
}