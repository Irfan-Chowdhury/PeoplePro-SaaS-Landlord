<?php

namespace App\Services;

use App\Contracts\PackageContract;
use App\Contracts\PermissionContract;
use App\Contracts\TenantContract;
use App\Facades\Alert;
use App\Http\traits\PermissionHandleTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PackageService
{
    use PermissionHandleTrait;
    public function __construct(
        private PackageContract $packageContract,
        private PermissionContract $permissionContract,
        private TenantContract $tenantContract,
    ) {}

    public function getAll()
    {
        return $this->packageContract->all();
    }

    public function yajraDataTable()
    {
        $packages = $this->getAll();

        return datatables()->of($packages)
        ->setRowId(function ($row) {
            return $row->id;
        })
        ->addColumn('name', function ($row) {
            return $row->name;
        })
        ->addColumn('is_free_trial', function ($row) {
            return $row->is_free_trial ? 'Yes' : 'No' ;
        })
        ->addColumn('monthly_fee', function ($row) {
            return $row->monthly_fee;
        })
        ->addColumn('yearly_fee', function ($row) {
            return $row->yearly_fee;
        })
        ->addColumn('number_of_user_account', function ($row) {
            return $row->number_of_user_account;
        })
        ->addColumn('number_of_employee', function ($row) {
            return $row->number_of_employee;
        })
        ->addColumn('action', function ($row) {
            $button = '<a href="'.route('package.edit', $row->id) .'" class="edit btn btn-primary btn-sm" title="Edit"><i class="dripicons-pencil"></i></a>&nbsp;&nbsp;';
            $button .= '<button type="button" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';

            return $button;
        })
        ->rawColumns(['image', 'action'])
        ->make(true);
    }

    public function getAllPermissions()
    {
        $dbPermissions = $this->permissionContract->all();

        return $this->reFormatPermissionData($dbPermissions);

        // return $uniqueParentIds = $this->uniqueParentIds($permissionsData);
        // $topLevelItems = $this->displayDataAsNestedTree($permissionsData);
        // return $permissionIds = $this->displayPermissionIdsByParent($topLevelItems);
    }

    protected function reFormatPermissionData($dbPermissions) : array
    {
        $permissionsData = [];
        foreach ($dbPermissions as  $item) {
            $permissionsData[] = [
                'id' => $item->name,
                'name' => $this->formatString($item->name),
                'treeview' => $item->treeview,
                'parent' => $item->parent,
            ];
        }
        return $permissionsData;
    }

    protected function uniqueParentIds($permissionsData)
    {
        $parentIds = [];
        foreach ($permissionsData as $permission) {
            if($permission['parent'] === null)
                $parentIds[] = $permission['id'];
            else
                $parentIds[] = $permission['parent'];
        }
        return array_unique($parentIds);
    }


    protected function formatString($originalString) {
        $data = str_replace('-', ' ', $originalString);

        $formattedString = ucwords($data);
        return $formattedString;
    }

    public function displayDataAsNestedTree($permissionsData)
    {
        $nestedData = [];
        foreach ($permissionsData as $permission) {
            $id = $permission['id'];
            $parent = $permission['parent'];

            $nestedData[$id] = $permission;
            $nestedData[$id]['children'] = [];
        }

        foreach ($nestedData as $id => &$item) {
            $parent = $item['parent'];

            if ($parent !== null && isset($nestedData[$parent])) {
                $nestedData[$parent]['children'][] = &$item;
            }
        }

        $topLevelItems = array_filter($nestedData, function ($item) {
            return $item['parent'] === null;
        });

        return $topLevelItems;
    }

    public function displayPermissionIdsByParent($topLevelItems)
    {
        $data = [];
        foreach ($topLevelItems as $topLevelItem) {
            $data[] = $this->extractIds($topLevelItem);
        }
        return $data;
    }

    private function extractIds($item)
    {
        $ids = [$item['id']];
        if (!empty($item['children'])) {
            foreach ($item['children'] as $child) {
                $ids = array_merge($ids, $this->extractIds($child));
            }
        }
        return $ids;
    }


    public function save($request)
    {
        try {
            $resultOfPermissions = $this->featureAndPermissionManage($request->features[0]);
            $permission_names = array_column($resultOfPermissions,'name');
            $permission_ids = array_column($resultOfPermissions,'id');

            $data = $this->requestHandle($request, $resultOfPermissions, $permission_names, $permission_ids);
            $this->packageContract->create($data);

            return Alert::successMessage('Data Saved Successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    public function updateInfo($request, $id)
    {
        try {
            $resultOfPermissions = $this->featureAndPermissionManage($request->features[0]);
            $permission_names = array_column($resultOfPermissions,'name');
            $permission_ids = array_column($resultOfPermissions,'id');

            $this->existingTenantsUpdate($request, $id, $resultOfPermissions, $permission_ids);
            // =====================  ============================
            // if($request->is_update_existing) {
            //     $tenants = $this->tenantContract->getDataByCondition(['package_id' => $id]);
            //     foreach ($tenants as $tenant) {
            //         $tenant->run(function ($tenant) use ($resultOfPermissions, $permission_ids) {
            //             DB::table('permissions')->delete();
            //             DB::table('permissions')->insert($resultOfPermissions);
            //             $role = Role::find(1);
            //             $role->syncPermissions($permission_ids);
            //         });
            //     }
            // }
            // =================================================

            $data = $this->requestHandle($request, $resultOfPermissions, $permission_names, $permission_ids);
            $this->packageContract->update($id, $data);

            return Alert::successMessage('Data Updated Successfully');

        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    protected function existingTenantsUpdate($request, $id, $resultOfPermissions, $permission_ids) : void
    {
        if($request->is_update_existing) {
            $package = $this->packageContract->getById($id);
            $prevPermissions = json_decode($package->permissions, true);
            $prevPermissionsIds = array_column($prevPermissions, 'id');

            $newAddedPermissions = [];
            foreach ($resultOfPermissions as $element) {
                if (!in_array($element["id"], $prevPermissionsIds)) {
                    $newAddedPermissions[] = $element;
                }
            }

            $tenants = $this->tenantContract->getDataByCondition(['package_id' => $id]);
            foreach ($tenants as $tenant) {
                $tenant->run(function ($tenant) use ($newAddedPermissions, $permission_ids) {
                    DB::table('permissions')->whereNotIn('id', $permission_ids)->delete();
                    DB::table('permissions')->insert($newAddedPermissions);
                    $role = Role::findById(1);
                    $role->syncPermissions($permission_ids);
                });
            }
        }
    }

    public function remove($id)
    {
        try {
            $this->packageContract->delete($id);

            return Alert::successMessage('Data Deleted Successfully');
        } catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    // public function featureAndPermissionManage($features) : array
    // {
    //     $selectedparentSlugs = explode(',',$features);

    //     $skipSlug = $this->skipParentSlug;
    //     $matchedSlugs = [];
    //     foreach ($skipSlug as $element) {
    //         if (in_array($element, $selectedparentSlugs)) {
    //             $matchedSlugs[] = $element;
    //         }
    //     }

    //     $selectedparentSlugs = array_values(array_diff($selectedparentSlugs, $matchedSlugs));

    //     $data1 = $this->permissionContract->getAllByParent($selectedparentSlugs);

    //     $parentSlug = array_merge($selectedparentSlugs, $matchedSlugs);

    //     $data2 = $this->permissionContract->getAllByName($parentSlug);

    //     $resultOfPermissions = array_merge($data1, $data2);
    //     usort($resultOfPermissions, function ($a, $b) {
    //         return $a['id'] - $b['id'];
    //     });

    //     return $resultOfPermissions;
    // }

    // public $skipParentSlug = [
    //     'customize-setting',
    //     'core_hr',
    //     'timesheet',
    //     'recruitment',
    //     'project-management',
    //     'file_module',
    //     'event-meeting',
    //     'finance',
    //     'training_module',
    //     'performance',
    // ];

    private function requestHandle($request, $resultOfPermissions, $permission_names, $permission_ids)
    {
        return [
            'name' => $request->name,
            'is_free_trial' => $request->is_free_trial ? true : false,
            'monthly_fee' => $request->monthly_fee,
            'yearly_fee' => $request->yearly_fee,
            'number_of_user_account' => $request->number_of_user_account,
            'number_of_employee' => $request->number_of_employee,
            'features' => $request->features[0],
            'permissions' => json_encode($resultOfPermissions),
            'permission_names' => implode(',', $permission_names),
            'permission_ids' => implode(',', $permission_ids),
            'is_active' => $request->is_active ? true : false,
        ];
    }

}
