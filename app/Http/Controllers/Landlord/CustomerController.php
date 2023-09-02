<?php

namespace App\Http\Controllers\Landlord;

use App\Events\CustomerRegistered;
use App\Http\traits\TenantTrait;
use App\Models\Landlord\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerSignUpRequest;
use App\Mail\ConfirmationEmail;
use App\Models\Landlord\Customer;
use App\Models\Tenant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    use TenantTrait;

    // public function customerSignUp(Request $request)
    public function customerSignUp(CustomerSignUpRequest $request)
    {
        // event(new UserRegistered($user));

        // try
		// {
        //     $test = Package::find(6565);
        //     $set = $test->name;
        // } catch (Exception $e) {
        //     // return $e->getMessage();
        //     // Session::flash('success', $e->getMessage());
        //     // return redirect()->back();
        //     return redirect()->back()->withErrors(['errors' => [$e->getMessage()]]);
        // }
        // Session::flash('success', 'Form submitted successfully!');
        // return redirect()->back()->with(['success' => 'Form submitted successfully!']);

        $customerData = [
            'company_name' => $request->company_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_no' => $request->contact_no,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ];

        DB::beginTransaction();

        try {
            $customer = Customer::create($customerData);
            $package = Package::find($request->package_id);



            if($package->is_free_trial) {
                $this->createTenant($request, $customer, $package);
                // return \Redirect::to('https://'.$request->tenant.'.'.env('CENTRAL_DOMAIN'));
            }

            // Mail::to($request->email)->send(new ConfirmationEmail($request));
            // event(new CustomerRegistered($request));

            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['errors' => [$e->getMessage()]]);
        }

        return redirect()->back()->with(['success' => 'Created successfully!']);
    }
}
