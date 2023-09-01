<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantSignupDescription\TenantSignupDescriptionRequest;
use App\Services\TenantSignupDescriptionService;
use Illuminate\Support\Facades\Session;

class TenantSignupDescriptionController extends Controller
{

    private $languageId;

    public function __construct(private TenantSignupDescriptionService $tenantSignupDescriptionService)
    {
        $this->middleware(function ($request, $next){
            $this->languageId = Session::has('TempSuperAdminLangId') ? Session::get('TempSuperAdminLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }

    public function index()
    {
        $tenantSignupDescription =  $this->tenantSignupDescriptionService->getLatestData($this->languageId);
        return view('landlord.super-admin.pages.tenant-signup-descriptions.index', compact('tenantSignupDescription'));
    }

    public function updateOrCreate(TenantSignupDescriptionRequest $request)
    {
        $result = $this->tenantSignupDescriptionService->updateOrCreate($request, $this->languageId);
        return response()->json($result['alertMsg'], $result['statusCode']);
    }
}
