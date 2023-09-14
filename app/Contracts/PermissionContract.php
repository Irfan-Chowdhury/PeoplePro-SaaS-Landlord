<?php

namespace App\Contracts;

interface PermissionContract extends BaseContract
{
    // Add your signature here

    public function getAllByParent($selectedparentSlugs);

    public function getAllByName($parentSlug);
}
