<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller {

	public function set_permission(Request $request)
	{
		if (auth()->user()->can('set-permission'))
		{
			$id = $request['roleId'];
			$role = Role::findById($id);
			$all_permissions = $request['checkedId'];
			$role->syncPermissions($all_permissions);

			return response()->json(['success' => __('Successfully saved the permission')]);
		}
		return response()->json(['success' => __('You are not authorized')]);
	}


    protected  $permissionsData = [
        // // treeview - 1
        [ 'id' => 'test-saas', 'name' => 'Test SAAS', 'treeview' => 1, 'parent' => null ],

        [ 'id' => 'test-1', 'name' => 'Test 1', 'treeview' => 1, 'parent' => 'test-saas' ],
        [ 'id' => 'irfan', 'name' => 'Irfan', 'treeview' => 1, 'parent' => 'test-1' ],
        [ 'id' => 'chy', 'name' => 'Chy', 'treeview' => 1, 'parent' => 'test-1' ],
        [ 'id' => 'fahim', 'name' => 'Fahim', 'treeview' => 1, 'parent' => 'test-1' ],

        [ 'id' => 'test-2', 'name' => 'Test 2', 'treeview' => 1, 'parent' => 'test-saas' ],
        [ 'id' => 'test-3', 'name' => 'Test 3', 'treeview' => 1, 'parent' => 'test-saas' ],

        [ 'id' => 'test-4', 'name' => 'Test 4', 'treeview' => 1, 'parent' => null ],
        [ 'id' => 'test-5', 'name' => 'Test 5', 'treeview' => 1, 'parent' => 'test-4' ],
        [ 'id' => 'test-6', 'name' => 'Test 6', 'treeview' => 1, 'parent' => 'test-4' ],

        [ 'id' => 'test-7', 'name' => 'Test 7', 'treeview' => 1, 'parent' => null ],

        // // treeview - 2
        [ 'id' => 'test-8', 'name' => 'Test 8', 'treeview' => 2, 'parent' => null ],
        [ 'id' => 'test-9', 'name' => 'Test 9', 'treeview' => 2, 'parent' => 'test-8' ],
        [ 'id' => 'test-10', 'name' => 'Test 10', 'treeview' => 2, 'parent' => 'test-8' ],

        // treeview - 3
        [ 'id' => 'test-11', 'name' => 'Test 11', 'treeview' => 3, 'parent' => null ],
        [ 'id' => 'test-12', 'name' => 'Test 12', 'treeview' => 3, 'parent' => 'test-11' ],
        [ 'id' => 'test-13', 'name' => 'Test 13', 'treeview' => 3, 'parent' => 'test-11' ],

        [ 'id' => 'test-14', 'name' => 'Test 14', 'treeview' => 3, 'parent' => null ],
        [ 'id' => 'test-15', 'name' => 'Test 15', 'treeview' => 3, 'parent' => 'test-14' ],
        [ 'id' => 'test-16', 'name' => 'Test 16', 'treeview' => 3, 'parent' => 'test-14' ],

        [ 'id' => 'test-17', 'name' => 'Test 17', 'treeview' => 3, 'parent' => 'test-15' ],
        [ 'id' => 'test-18', 'name' => 'Test 18', 'treeview' => 3, 'parent' => 'test-15' ],
        [ 'id' => 'test-19', 'name' => 'Test 19', 'treeview' => 3, 'parent' => 'test-15' ]
    ];


	public function rolePermission($id)
    {
		if (auth()->user()->can('set-permission')) {


            // $topLevelItems = $this->displayDataAsNestedTree($this->permissionsData);
            // $permissionIds = $this->displayPermissionIdsByParent($topLevelItems);

            $data = DB::table('permissions')->get();
            $permissionsData = [];

            foreach ($data as  $value) {
                $permissionsData[] = [
                    'id' => $value->name,
                    'name' => $this->formatString($value->name),
                    'treeview' => $value->treeview,
                    'parent' => $value->parent,
                ];
            }

			$role = Role::findById($id);
            // $permissionsData = DB::table('permissions')->get();

            // return $permissionsData;

			return view('settings.roles.permission',compact('role', 'permissionsData'));
		}
		return response()->json(['success' => __('You are not authorized')]);
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


      // Display the nested data
      public function displayNestedData($data, $level = 1) {
        foreach ($data as $item) {
            $data[] = str_repeat('&nbsp;&nbsp;', $level) . $item['name'] . '<br>';
            if (isset($item['children'])) {
                $this->displayNestedData($item['children'], $level + 1);
            }
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


    public function formatString($originalString) {
        $data = str_replace('-', ' ', $originalString);

        $formattedString = ucwords($data);
        return $formattedString;
    }



	public function permissionDetails($id)
	{
		$role = Role::findById($id);
		$role_permissions = $role->permissions()->select('name')->get();
        //return response($role_permissions);

		$permissions = array();
		foreach ($role_permissions as $permission)
		{
			$permissions[] = $permission->name;
		}
		return json_encode($permissions);
	}
}
