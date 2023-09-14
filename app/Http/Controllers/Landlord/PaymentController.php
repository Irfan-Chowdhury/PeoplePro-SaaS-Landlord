<?php

namespace App\Http\Controllers\Landlord;

use App\Contracts\PageContract;
use App\Contracts\SocialContract;
use App\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Http\traits\PermissionHandleTrait;
use App\Models\Landlord\Package;
use App\Models\Landlord\Payment;
use App\Models\Tenant;
use App\Services\PaymentService;
use App\Services\TenantService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public $languageId;
    use PermissionHandleTrait;
    public function __construct(
        public SocialContract $socialContract,
        public PageContract $pageContract,
        public PaymentService $paymentService,
        public TenantService $tenantService
    ){
        $this->middleware(function ($request, $next){
            $this->languageId = Session::has('TempPublicLangId')==true ? Session::get('TempPublicLangId') : Session::get('DefaultSuperAdminLangId');
            return $next($request);
        });
    }

    public function paymentPayPage($paymentMethod, Request $request)
    {
        $tenantRequestData = json_encode($request->all());
        $totalAmount = $request->session()->get('price');

        $socials = $this->socialContract->getOrderByPosition(); //Common
        $pages =  $this->pageContract->getAllByLanguageId($this->languageId); //Common

        switch ($paymentMethod) {
            case 'stripe':
                return view('landlord.public-section.pages.payment.stripe',compact('socials', 'pages','paymentMethod','tenantRequestData','totalAmount'));
            case 'paypal':
                return view('landlord.public-section.pages.payment.paypal',compact('socials', 'pages','paymentMethod','tenantRequestData','totalAmount'));
            case 'razorpay':
                return view('landlord.public-section.pages.payment.razorpay',compact('socials', 'pages','paymentMethod','tenantRequestData','totalAmount'));
            default:
                break;
        }
    }

    public function paymentProcessWithTenantAndLandlord($paymentMethod, Request $request)
    {
        DB::beginTransaction();
        try {
            $paymentRequestData = $request->except('tenantRequestData');
            $tenantRequestData = json_decode(str_replace('&quot;', '"', $request->tenantRequestData));

            $payment = self::paymentPayConfirm($paymentMethod, $tenantRequestData, $paymentRequestData);
            if(isset($tenantRequestData->is_new_tenant) && (int) $tenantRequestData->is_new_tenant ===1) {
                $tenant = $this->tenantService->NewTenantGenerate($tenantRequestData);
            } else {
                $tenant = self::existingTenantHandle($tenantRequestData);
            }
            // $tenantId = isset($tenant) ? $tenant->id : $tenantRequestData->tenant_id;
            $tenantId = $tenant->id;
            self::landlordHandle($payment, $tenantId);


            DB::commit();

            $result =  Alert::successMessage('Data Created Successfully');
            if (request()->ajax()) {
                return response()->json($result['alertMsg'], $result['statusCode']);
            } else {
                return redirect()->route('payment.success', $tenant->domainInfo->domain);
            }
        }
        catch (Exception $e) {
            DB::rollback();

            if(request()->ajax())
                return response()->json(['errorMsg' => $e->getMessage()], 422);
            else
                return redirect()->back()->withErrors(['errors' => [$e->getMessage()]]);
        }
    }

    protected function paymentPayConfirm($paymentMethod, $tenantRequestData, $paymentRequestData)
    {
        $payment = $this->paymentService->initialize($paymentMethod);
        return $payment->pay($tenantRequestData, $paymentRequestData);
    }

    protected function existingTenantHandle($tenantRequestData) : object
    {
        $tenant = Tenant::with('domainInfo')->find($tenantRequestData->tenant_id);
        $package = Package::find($tenantRequestData->package_id);
        $this->tenantService->permissionUpdate($tenant, $tenantRequestData, $package);

        return $tenant;
    }

    protected function landlordHandle($payment, $tenantId) : void
    {
        Payment::where('id', $payment->id)->update(['tenant_id'=> $tenantId]);
    }

    public function paymentPayCancel($paymentMethod, PaymentService $paymentService)
    {
        $payment = $paymentService->initialize($paymentMethod);
        return $payment->cancel();
    }

    public function paymentSuccess($domain)
    {
        $socials = $this->socialContract->getOrderByPosition(); //Common
        $pages =  $this->pageContract->getAllByLanguageId($this->languageId); //Common
        return view('landlord.public-section.pages.payment.payment_success', compact('socials','pages','domain'));

    }


}
