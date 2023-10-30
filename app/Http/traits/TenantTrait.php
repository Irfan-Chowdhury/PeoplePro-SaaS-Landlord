<?php

namespace App\Http\traits;

use App\Models\GeneralSetting as TenantGeneralSetting;
use App\Models\Landlord\GeneralSetting;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;

trait TenantTrait {
    // use \App\Traits\MailInfo;

    public function getTenantId()
    {
        $url = \URL::to('/');
        if(strpos($url, "https://") !== false)
            $url = str_replace("https://", "", $url);
        elseif(strpos($url, "http://") !== false)
            $url = str_replace("http://", "", $url);
        $urlInfo = explode(".", $url);
        return $urlInfo[0];
    }

    public function setPermission($packageData)
    {
        //updating the sql file which tenant will import
        $sqlFile = fopen("public/tenant_necessary.sql", "r");
        $baseSqlData = fread($sqlFile,filesize("public/tenant_necessary.sql"));
        fclose($sqlFile);
        $basicPermission = "(4, 1),(5, 1),(6, 1),(7, 1),(8, 1),(9, 1),(10, 1),(11, 1),(12, 1),(13, 1),(14, 1),(15, 1),(28, 1),(29, 1),(30, 1),(31, 1),(32, 1),(33, 1),(34, 1),(35, 1),(41, 1),(42, 1),(43, 1),(44, 1),(59, 1),(60, 1),(61, 1),(80, 1),(81, 1),(82, 1),(83, 1),(84, 1),(85, 1),(86, 1),(87, 1),(88, 1),(91, 1),(92, 1),(93, 1),(94, 1),(95, 1),(96, 1),(98, 1),(100, 1),(101, 1),(102, 1),(103, 1),(104, 1),(105, 1),(106, 1),(107, 1),(108, 1),(109, 1),(110, 1),(111, 1),(113, 1),(114, 1),(115, 1),(116, 1),(117, 1),(118, 1),(119, 1),(120, 1),(121, 1),(124, 1)";
        //return $basicPermission.','.$packageData->role_permission_values;
        $newSqlData = str_replace($basicPermission, $basicPermission.','.$packageData->role_permission_values, $baseSqlData);
        $sqlFile = fopen("public/tenant_necessary.sql", "w");
        fwrite($sqlFile, $newSqlData);
        fclose($sqlFile);
    }



    public function createTenantOld($request, $package)
    {
        if(cache()->has('general_setting')){
            $general_setting = cache()->get('general_setting');
        }
        else{
            $general_setting = DB::table('general_settings')->latest()->first();
        }
        $generalSetting = GeneralSetting::latest()->first();

        if($package->is_free_trial)
            $numberOfDaysToExpired = $generalSetting->free_trial_limit;
        elseif($request->subscription_type == 'monthly')
            $numberOfDaysToExpired = 30;
        elseif($request->subscription_type == 'yearly')
            $numberOfDaysToExpired = 365;


        //creating tenant
        $tenant = Tenant::create(['id' => $request->tenant]);
        $tenant->domains()->create(['domain' => $request->tenant.'.'.env('CENTRAL_DOMAIN')]); // This Line


        if(isset($request->payment_method))
            $paid_by = $request->payment_method;
        else
            $paid_by = '';


        if($paid_by) {
            TenantPayment::create(['tenant_id' => $tenant->id, 'amount' => $request->price, 'paid_by' => $paid_by]);
        }
        //updating general setting info in the sql file which tenant will import
        $sqlFile = fopen("public/tenant_necessary_base.sql", "r");
        $baseSqlData = fread($sqlFile,filesize("public/tenant_necessary_base.sql"));
        fclose($sqlFile);
        $newSqlDataForSetting = str_replace("(1, 'SalePro', '20220905125905.png', 0, '1', 0, 'monthly', 'own', 'd/m/Y', 'Lioncoders', 'standard', 1, 'default.css', '2018-07-06 06:13:11', '2022-09-05 06:59:05', 'prefix', '1970-01-01');", "(1, '".$general_setting->site_title."', '".$general_setting->site_logo."', 0, '1', ".$request->package_id.", "."'".$request->subscription_type."', 'own', 'd/m/Y', '".$general_setting->developed_by."', 'standard', 1, 'default.css', '2018-07-06 06:13:11', '2022-09-05 06:59:05', 'prefix', '".date("Y-m-d", strtotime("+".$numberOfDaysToExpired." days"))."');", $baseSqlData);
        $sqlFile = fopen("public/tenant_necessary.sql", "w");
        fwrite($sqlFile, $newSqlDataForSetting);
        fclose($sqlFile);
        //updating user information
        $encryptedPass = '$2y$10$DWAHTfjcvwCpOCXaJg11MOhsqns03uvlwiSUOQwkHL2YYrtrXPcL6';
        $newEncryptedPass = bcrypt($request->password);
        $newSqlDataForUser = str_replace("(1, 'admin', 'admin@gmail.com', '".$encryptedPass."', '6mN44MyRiQZfCi0QvFFIYAU9LXIUz9CdNIlrRS5Lg8wBoJmxVu8auzTP42ZW', '12112', 'lioncoders', 1, NULL, NULL, 1, 0, '2018-06-02 03:24:15', '2018-09-05 00:14:15')", "(1, '".$request->name."', '".$request->email."', '".$newEncryptedPass."', '6mN44MyRiQZfCi0QvFFIYAU9LXIUz9CdNIlrRS5Lg8wBoJmxVu8auzTP42ZW', ".$request->phone_number.",  '".$request->company_name."', 1, NULL, NULL, 1, 0, '2018-06-02 03:24:15', '2018-09-05 00:14:15')", $newSqlDataForSetting);
        $sqlFile = fopen("public/tenant_necessary.sql", "w");
        fwrite($sqlFile, $newSqlDataForUser);
        fclose($sqlFile);
        //updating permission info in the sql file which tenant will import
        $packageData = DB::table('packages')->find($request->package_id);
        $this->setPermission($packageData);

        //updating tenant others information on landlord DB
        $tenant->update(['package_id' => $request->package_id, 'subscription_type' => $request->subscription_type, 'company_name' => $request->company_name, 'phone_number' => $request->phone_number, 'email' => $request->email, 'expiry_date' => date("Y-m-d", strtotime("+".$numberOfDaysToExpired." days"))]);
        //sending welcome message to tenant
        $mail_setting = MailSetting::latest()->first();
        $message = 'Client created successfully';
        if($mail_setting) {
            $this->setMailInfo($mail_setting);
            $mail_data['email'] = $request->email;
            $mail_data['company_name'] = $request->company_name;
            $mail_data['superadmin_company_name'] = $general_setting->site_title;
            $mail_data['subdomain'] = $request->tenant;
            $mail_data['name'] = $request->name;
            $mail_data['password'] = $request->password;
            $mail_data['superadmin_email'] = $general_setting->email;
            try {
                Mail::to($mail_data['email'])->send(new TenantCreate($mail_data));
            }
            catch(\Exception $e){
                $message = 'Client created successfully. Please setup your <a href="../mail_setting">mail setting</a> to send mail.';
            }
        }
    }

    public function createTenant($request, $customer, $package) : void
    {
        $generalSetting = GeneralSetting::latest()->first();

        if($package->is_free_trial)
            $numberOfDaysToExpired = $generalSetting->free_trial_limit;
        elseif($request->subscription_type == 'monthly')
            $numberOfDaysToExpired = 30;
        elseif($request->subscription_type == 'yearly')
            $numberOfDaysToExpired = 365;

        $tenantData = [
            'id' => $request->tenant,
            'tenancy_db_name' => env('DB_PREFIX').$request->tenant,
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'subscription_type'=> $request->subscription_type,
            'expiry_date' => date("Y-m-d", strtotime("+".$numberOfDaysToExpired." days"))
        ];

        $tenant = Tenant::create($tenantData);
        $tenant->domains()->create(['domain' => $request->tenant.'.'.env('CENTRAL_DOMAIN')]); // This Line

        $permissions = json_decode($package->permissions, true);
        $allPermissionIds = explode(',',$package->permission_ids);
        // package_details

        $packageDetailsForTenant =  $this->packageDetailsForTenant($package, $generalSetting, $request);
        $packageDetailsForTenant['expiry_date'] = date("Y-m-d", strtotime("+".$numberOfDaysToExpired." days"));

        $tenant->run(function ($tenant) use ($request, $permissions, $allPermissionIds, $packageDetailsForTenant) {
            DB::table('permissions')->insert($permissions);
            $user = $this->tenantAdminCreate($request);
            $role = Role::findById(1);
			$role->syncPermissions($allPermissionIds);
			$user->syncRoles(1);

            $this->setDataInTenantGeneralSetting($packageDetailsForTenant);
        });

        
    }



    // public function createTenant($request, $customer, $package)
    // {

    //     $generalSetting = GeneralSetting::latest()->first();

    //     if($package->is_free_trial)
    //         $numberOfDaysToExpired = $generalSetting->free_trial_limit;
    //     elseif($request->subscription_type == 'monthly')
    //         $numberOfDaysToExpired = 30;
    //     elseif($request->subscription_type == 'yearly')
    //         $numberOfDaysToExpired = 365;

    //     $tenant = [
    //         'id' => $request->tenant,
    //         'tenancy_db_name' => env('DB_PREFIX').$request->tenant,
    //         'customer_id' => $customer->id,
    //         'package_id' => $package->id,
    //         'subscription_type'=> $request->subscription_type,
    //         'expiry_date' => date("Y-m-d", strtotime("+".$numberOfDaysToExpired." days"))
    //     ];

    //     $packageDetailsForTenant =  $this->packageDetailsForTenant($package, $generalSetting, $request);
    //     $packageDetailsForTenant['expiry_date'] = date("Y-m-d", strtotime("+".$numberOfDaysToExpired." days"));


    //     $tenant = Tenant::create($tenant);
    //     $tenant->domains()->create(['domain' => $request->tenant.'.'.env('CENTRAL_DOMAIN')]); // This Line


    //     $permissions = json_decode($package->permissions, true);
    //     $allPermissionIds = explode(',',$package->permission_ids);
    //     $tenant->run(function ($tenant) use ($request, $permissions, $customer, $allPermissionIds) {
    //         DB::table('permissions')->insert($permissions);

    //         $user = User::create([
    //             'first_name'=> $customer->first_name,
    //             'last_name'=> $customer->last_name,
    //             'username'=> $customer->username,
    //             'email'=> $customer->email,
    //             'contact_no'=> $customer->contact_no,
    //             'role_users_id'=> 1,
    //             'is_active'=> true,
    //             'password'=> bcrypt($request->password)
    //         ]);

    //         $role = Role::findById(1);
	// 		$role->syncPermissions($allPermissionIds);
	// 		$user->syncRoles(1);

    //         $this->setDataInTenantGeneralSetting($packageDetailsForTenant);

    //     });
    // }





    protected function setDataInTenantGeneralSetting($packageDetailsForTenant) : void
    {
        $tenantGeneralSetting = TenantGeneralSetting::latest()->first();
        $tenantGeneralSetting->update([
            'package_details' => json_encode($packageDetailsForTenant)
        ]);
    }


    public function packageDetailsForTenant($package, $generalSetting, $request)
    {
        return [
            'package_id' => $package->id,
            'name' => $package->name,
            'is_free_trial' => $package->is_free_trial,
            'free_trial_limit' => $generalSetting->free_trial_limit,
            'monthly_fee' => $package->monthly_fee,
            'yearly_fee' => $package->yearly_fee,
            'number_of_user_account' => $package->number_of_user_account,
            'number_of_employee' => $package->number_of_employee,
            'subscription_type'=> $request->subscription_type,
        ];
    }


    protected function tenantAdminCreate($request) : object
    {
        return User::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'username'=> $request->username,
            'email'=> $request->email,
            'contact_no'=> $request->contact_no,
            'role_users_id'=> 1,
            'is_active'=> true,
            'password'=> bcrypt($request->password)
        ]);
    }
}



