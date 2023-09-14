<?php

namespace App\Repositories;

use App\Contracts\PermissionContract;
use App\Models\Landlord\Permission;

class PermissionRepository extends BaseRepository implements PermissionContract
{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->$model = $model;
        parent::__construct($this->$model);
    }

    public function getAllByParent($selectedparentSlugs)
    {
        return $this->model::select('id','name','parent','treeview','guard_name')
                ->whereIn('parent', $selectedparentSlugs)
                ->orderBy('id','ASC')
                ->get()->toArray();
    }

    public function getAllByName($parentSlug)
    {
        return $this->model::select('id','name','parent','treeview','guard_name')
                ->whereIn('name', $parentSlug)
                ->orderBy('id','ASC')
                ->get()->toArray();
    }

}
