<?php

namespace App\Repositories;

use App\Contracts\TestimonialContract;
use App\Models\Landlord\Testimonial;

class TestimonialRepository extends BaseRepository implements TestimonialContract
{
    protected $model;

    public function __construct(Testimonial $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }
}