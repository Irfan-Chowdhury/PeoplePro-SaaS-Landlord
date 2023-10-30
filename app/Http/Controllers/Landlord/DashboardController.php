<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Http\traits\AutoUpdateTrait;
use App\Models\Landlord\Package;
use App\Models\Landlord\Payment;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
class DashboardController extends Controller
{
    use AutoUpdateTrait;

    public function index()
    {
        $autoUpdateData = $this->general();
        $alertVersionUpgradeEnable = $autoUpdateData['alertVersionUpgradeEnable'];
        $alertBugEnable =  $autoUpdateData['alertBugEnable'];


        $tenants = Tenant::with('package')->get();
        $totalTenantCount = $tenants->count();
        $totalActiveTenantCount = Tenant::totalActiveTenantCount();
        $receivedAmount = Payment::sum('amount');
        $totalPackageCount = Package::count();

        $subscriptionValue = 0;
        foreach ($tenants as $tenant) {
            if($tenant->subscription_type === 'monthly')
                $subscriptionValue += $tenant->package->monthly_fee;
            else if($tenant->subscription_type === 'yearly')
                $subscriptionValue += $tenant->package->yearly_fee;
        }

        return view('landlord.super-admin.pages.dashboard.index',compact('subscriptionValue','receivedAmount',
            'totalTenantCount','totalActiveTenantCount','totalPackageCount','alertBugEnable','alertVersionUpgradeEnable'
        ));
    }
}
