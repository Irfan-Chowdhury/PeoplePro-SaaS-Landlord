<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\Package\StorePackageRequest;
use App\Http\Requests\Package\UpdatePackageRequest;
use App\Http\traits\PermissionHandleTrait;
use App\Models\Landlord\Package;
use App\Models\Landlord\Permission;
use App\Services\PackageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    use PermissionHandleTrait;

    public function __construct(private PackageService $packageService) {}

    public function index()
    {
        return view('landlord.super-admin.pages.packages.index');
    }

    public function datatable()
    {
        return $this->packageService->yajraDataTable();
    }

    public function create()
    {
        $permissionsData = $this->packageService->getAllPermissions();

        return view('landlord.super-admin.pages.packages.create',compact('permissionsData'));
    }


    public function store(StorePackageRequest $request)
    {
        $result = $this->packageService->save($request);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function edit(Package $package)
    {
        $permissionNames = explode(',',$package->permission_names);

        return view('landlord.super-admin.pages.packages.edit',compact('package', 'permissionNames'));
    }

    public function update(UpdatePackageRequest $request, $packageId)
    {
        // return $this->featureAndPermissionManage($request->features[0]);

        $result = $this->packageService->updateInfo($request, $packageId);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function destroy($packageId)
    {
        $result = $this->packageService->remove($packageId);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }
}
