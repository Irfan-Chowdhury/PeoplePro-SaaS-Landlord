<?php

namespace App\Http\Controllers\Landlord;

use App\Contracts\ModuleContract;
use App\Contracts\ModuleDetailContract;
use App\Facades\Alert;
use App\Facades\Utility;
use App\Http\Controllers\Controller;
use App\Http\Requests\Module\StoreModuleRequest;
use App\Http\Requests\Module\UpdateModuleRequest;
use App\Models\Landlord\Module;
use App\Models\Landlord\ModuleDetail;
use App\Services\ModuleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ModuleController extends Controller
{
    private $moduleService;
    private $moduleContract;
    private $moduleDetailContract;
    private $languageId;

    public function __construct(ModuleService $moduleService, ModuleContract $moduleContract, ModuleDetailContract $moduleDetailContract)
    {
        $this->moduleService = $moduleService;
        $this->moduleContract = $moduleContract;
        $this->moduleDetailContract = $moduleDetailContract;

        $this->middleware(function ($request, $next){
            $this->languageId = Session::has('TempSuperAdminLangId') ? Session::get('TempSuperAdminLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }

    public function index()
    {
        $module = $this->moduleContract->fetchLatestDataByLanguageId($this->languageId);

        return view('landlord.super-admin.pages.modules.index',compact('module'));
    }

    public function datatable()
    {
        return $this->moduleService->yajraDataTable($this->languageId);
    }


    public function store(StoreModuleRequest $request)
    {
        $result = $this->moduleService->save($request, $this->languageId);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function edit(ModuleDetail $moduleDetail)
    {
        return response()->json($moduleDetail);
    }

    public function update(UpdateModuleRequest $request, $id)
    {
        $result = $this->moduleService->updateInfo($request, $id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function destroy($id)
    {
        $result = $this->moduleService->remove($id);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function sort(Request $request)
    {
        $result = $this->moduleService->sortingDataTable($request);

        return response()->json($result['alertMsg'], $result['statusCode']);
    }


}




