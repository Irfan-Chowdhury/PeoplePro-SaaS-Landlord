<?php

namespace App\Http\Controllers\Landlord;

use App\Contracts\PackageContract;
use App\Contracts\PageContract;
use App\Contracts\SocialContract;
use App\Events\CustomerRegistered;
use App\Facades\Alert;
use App\Http\traits\TenantTrait;
use App\Models\Landlord\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\CustomerSignUpRequest;
use App\Http\Requests\Tenant\RenewExpiryDataRequest;
use App\Http\Requests\Tenant\RenewSubscriptionRequest;
use App\Http\traits\PaymentTrait;
use App\Http\traits\PermissionHandleTrait;
use App\Mail\ConfirmationEmail;
use App\Models\Landlord\Customer;
use App\Models\Landlord\GeneralSetting;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class TenantController extends Controller
{
    use TenantTrait;

    public $languageId;
    use PermissionHandleTrait;
    use PaymentTrait;

    public function __construct(
        public SocialContract $socialContract,
        public PageContract $pageContract,
        public PackageContract $packageContract,
        public TenantService $tenantService
    )
    {
        $this->middleware(function ($request, $next){
            $this->languageId = Session::has('TempPublicLangId')==true ? Session::get('TempPublicLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }

    public function index()
    {
        $packages = $this->packageContract->getSelectData(['id','name']);

        return view('landlord.super-admin.pages.customers.index', compact('packages'));
    }

    public function datatable()
    {
        $tenants = Tenant::with(['customer','package','domainInfo'])->get();

        if (request()->ajax()) {
            return datatables()->of($tenants)
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->addColumn('tenantId', function ($row) {
                    return $row->id;
                })
                ->addColumn('database', function ($row) {
                    return $row->tenancy_db_name;
                })
                ->addColumn('domain', function ($row) {
                    return '<a href="https://'.$row->domainInfo->domain.'" target="_blank">'.$row->domainInfo->domain.'</a>';
                })
                ->addColumn('customer', function ($row) {
                    return $row->customer->getFullNameAttribute();
                })
                ->addColumn('email', function ($row) {
                    return $row->customer->email;
                })
                ->addColumn('package', function ($row) {
                    return $row->package->name;
                })
                ->addColumn('subscription_type', function ($row) {
                    return $row->subscription_type;
                })
                ->addColumn('action', function ($row) {
                    $button  = '<button type="button" data-id="'.$row->id.'" class="renewSubscription btn btn-warning btn-sm mr-2" title="Renew Subscription"><i class="dripicons-clockwise"></i></button>';
                    $button .= '<button type="button" data-id="'.$row->id.'" class="changePackage btn btn-success btn-sm mr-2" title="Change Package"><i class="dripicons-swap"></i></button>';
                    $button .= '<button type="button" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm" title="Delete"><i class="dripicons-trash"></i></button>';

                    return $button;
                })
                ->rawColumns(['domain','action'])
                ->make(true);
        }
    }


    public function customerSignUp(CustomerSignUpRequest $request)
    {
        DB::beginTransaction();
        try {
            $paymentMethodList = array_column($this->paymentMethods(), 'payment_method');
            if(!$request->is_free_trail && in_array($request->payment_method ,$paymentMethodList)) {
                return redirect(route("payment.pay.page",$request->payment_method), 307);
            }

            // $this->tenantGenerate($request);
            $this->tenantService->NewTenantGenerate($request);

            DB::commit();

            $result =  Alert::successMessage('Data Created Successfully');
            if (request()->ajax()) {
                return response()->json($result['alertMsg'], $result['statusCode']);
            } else {
                return redirect()->back()->with(['success' => 'Data Created Successfully']);
            }

        }
        catch (Exception $e) {
            DB::rollback();
            $result =  Alert::errorMessage($e->getMessage());

            if (request()->ajax()) {
                return response()->json($result['alertMsg'], $result['statusCode']);
            } else {
                return redirect()->back()->withErrors(['errors' => [$result['alertMsg']]]);
            }
        }
    }


    public function tenantInfo(Tenant $tenant)
    {
        return response()->json($tenant);
    }

    public function renewExpiryUpdate(RenewExpiryDataRequest $request, Tenant $tenant)
    {
        DB::beginTransaction();
        try {
            $expiryDate = date('Y-m-d', strtotime($request->expiry_date));

            $generalSetting = GeneralSetting::latest()->first();

            $packageDetailsForTenant = $this->packageDetailsForTenant($tenant->package, $generalSetting, $request);
            $packageDetailsForTenant['expiry_date'] = $expiryDate;

            $tenant->run(function ($tenant) use ($packageDetailsForTenant) {
                $this->setDataInTenantGeneralSetting($packageDetailsForTenant);
            });

            $tenant->expiry_date = $expiryDate;
            $tenant->subscription_type = $request->subscription_type;
            $tenant->update();
            $result =  Alert::successMessage('Data Update Successfully');

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            $result =  Alert::errorMessage($e->getMessage());
        }

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function changePackageProcess(Request $request, Tenant $tenant)
    {
        DB::beginTransaction();
        try {

            $package = Package::find($request->package_id);
            $this->permissionUpdate($tenant, $request, $package);

            $result =  Alert::successMessage('Package Switched Successfully');
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            $result =  Alert::errorMessage($e->getMessage());
        }

        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    protected function tenantGenerate($request) : void
    {
        $customer = Customer::create($this->customerData($request));
        $package = Package::find($request->package_id);

        if($package->is_free_trial) {
            $this->createTenant($request, $customer, $package);
            // return \Redirect::to('https://'.$request->tenant.'.'.env('CENTRAL_DOMAIN'));
        }

        // Mail::to($request->email)->send(new ConfirmationEmail($request));
        // event(new CustomerRegistered($request)); // Testing Purpose
    }


    protected function customerData($request)
    {
        return  [
            'company_name' => $request->company_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_no' => $request->contact_no,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ];
    }

    public function destroy(Tenant $tenant)
    {
        try {
            $tenant->domainInfo->delete();
            $tenant->delete();
            $result =  Alert::successMessage('Data Created Successfully');
        }
        catch (Exception $e) {
            $result =  Alert::errorMessage($e->getMessage());
        }
        return response()->json($result['alertMsg'], $result['statusCode']);
    }

    public function contactForRenewal(PackageContract $packageContract)
    {
        $socials = $this->socialContract->getOrderByPosition(); //Common
        $pages =  $this->pageContract->getAllByLanguageId($this->languageId); //Common
        $packages = $packageContract->getSelectData(['id','name']);
        $paymentMethods = $this->paymentMethods();

        return view('landlord.public-section.pages.renew.contact_for_renewal', compact('socials','pages','packages','paymentMethods'));
    }


    public function renewSubscription(RenewSubscriptionRequest $request)
    {
        DB::beginTransaction();
        try {
            $package = Package::find($request->package_id);

            if($request->subscription_type == 'monthly')
                $request->session()->put('price', $package->monthly_fee);
            else
                $request->session()->put('price', $package->yearly_fee);


            $paymentMethodList = array_column($this->paymentMethods(), 'payment_method');
            if(!$request->is_free_trail && in_array($request->payment_method ,$paymentMethodList)) {
                return redirect(route("payment.pay.page",$request->payment_method), 307);
            }

            // if ($request->payment_method === 'stripe' || $request->payment_method === 'paypal')
            //     return redirect(route("payment.pay.page",$request->payment_method), 307);

            $tenant = Tenant::find($request->tenant_id);
            $this->tenantService->permissionUpdate($tenant, $request, $package);

            DB::commit();
            return redirect()->back()->with(['success' => 'Data Created Successfully']);
        }
        catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->withErrors(['errors' => [$e->getMessage()]]);
        }
    }

    protected function permissionUpdate($tenant, $request, $package)
    {
        $prevPermissions = json_decode($tenant->package->permissions, true);
        $prevPermissionIds = array_column($prevPermissions, 'id');

        $latestPermissions = json_decode($package->permissions, true);
        $latestPermissionsIds = array_column($latestPermissions, 'id');

        $newAddedPermissions = [];
        foreach ($latestPermissions as $element) {
            if (!in_array($element["id"], $prevPermissionIds)) {
                $newAddedPermissions[] = $element;
            }
        }

        $tenant->package_id = $request->package_id;
        $tenant->update();
        $tenant->run(function () use ($newAddedPermissions, $latestPermissionsIds) {
            DB::table('permissions')->whereNotIn('id', $latestPermissionsIds)->delete();
            DB::table('permissions')->insert($newAddedPermissions);
            $role = Role::findById(1);
            $role->syncPermissions($latestPermissionsIds);
        });
    }



    public function test($tenant, $package)
    {
        // Update --
        // $tenant = Tenant::find('saastest24');
        // $tenant->run(function ($tenant) {
        //     $user = User::find(3);
        //     $user->first_name = 'irfan';
        //     $user->update();
        // });

        // Delete --
        // $tenant = Tenant::find('saastest1');
        // $tenant->domainInfo->delete();
        // $tenant->delete();
        // return 'ok';

        // ========== Test ============
        // $prevPermissionIds = [1,2,3,4,5];
        // $latestPermissionsIds = [1,2,3,6,7,8];

        // $skipIds = [];
        // foreach ($prevPermissionIds as $element) {
        //     if (!in_array($element, $latestPermissionsIds)) {
        //         $skipIds[] = $element;
        //     }
        // }
        // return $skipIds;

        // $newIds = [];
        // foreach ($array2 as $element) {
        //     if (!in_array($element, $array1)) {
        //         $newIds[] = $element;
        //     }
        // }
        // return $newIds;
        // return $expectedResult = array_merge($expectedResult, $array2);
        // $expectedResult = [1,2,3,6,7,8];

        $prevPermissions = json_decode($tenant->package->permissions, true);
        $prevPermissionIds = array_column($prevPermissions, 'id');

        $latestPermissions = json_decode($package->permissions, true);
        $latestPermissionsIds = array_column($latestPermissions, 'id');

        $skipIds = [];
        foreach ($prevPermissionIds as $element) {
            if (!in_array($element, $latestPermissionsIds)) {
                $skipIds[] = $element;
            }
        }

        $newPermissions = [];
        foreach ($latestPermissions as $element) {
            if (!in_array($element["id"], $prevPermissionIds)) {
                $newPermissions[] = $element;
            }
        }

        // $permissions = DB::table('permissions')->get()->toArray();
        // $permissionsIds = array_column($permissions, 'id');
        // return count($latestPermissionsIds);


        // return count($latestPermissions).' | '.count($latestPermissionsIds);

        $test = null;
        $tenant->run(function () use ($skipIds, $newPermissions, $latestPermissions, $latestPermissionsIds, &$test) {
            if(!empty($newPermissions)) {
                DB::table('permissions')->whereIn('id', $skipIds)->delete();
                $test = DB::table('permissions')->insert($newPermissions);
                $role = Role::findById(1);
                $role->syncPermissions($latestPermissionsIds);
            }
            // DB::table('permissions')->insert($latestPermissions);
            // $test =  $role = Role::findById(1);
            // $role->syncPermissions($latestPermissionsIds);
            // $role->syncPermissions($latestPermissionsIds);
            // $test = DB::table('permissions')->whereIn('id', $skipIds)->pluck('id','name');
            // $test = DB::table('permissions')->whereNotIn('id', $latestPermissionsIds)->pluck('id','name');
        });
        return $test;

        return DB::table('permissions')->whereNotIn('id', $latestPermissionsIds)->pluck('id','name');



        if (empty(array_diff($prevPermissionIds, $latestPermissionsIds)) && empty(array_diff($latestPermissionsIds, $prevPermissionIds))) {
            return "Arrays are equal.";
        } else {
            return "Arrays are not equal.";
        }
        // ========== Test ============
    }

    // sudo php artisan cache:clear
    // php artisan cache:forget spatie.permission.cache
}
