<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use App\Models\GeneralSetting;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PackageValidity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $generalSetting =  GeneralSetting::latest()->first();
        $packageDetail = json_decode($generalSetting->package_details);
        $currentDate = Carbon::now();
        $expireDate = Carbon::parse($packageDetail->expiry_date);
        if ($currentDate->gte($expireDate)) {//greater than or equal
            abort(403);
        }
        else {
            if ($request->is('/users-list')) {
                $totalUsers = User::get()->count() + 1; //when total=200 then increament 1 so that button do disable
                $isAllowToCreateUser = ($totalUsers <= $packageDetail->number_of_user_account) ? true : false;

                view()->composer([
                    'all_user.index',
                ], function ($view) use ($isAllowToCreateUser) {
                    $view->with('isAllowToCreateUser', $isAllowToCreateUser);
                });
            }

            if ($request->is('staff/employees')) {
                $totalEmployees =  Employee::get()->count() + 1;
                $isAllowToCreateEmployee = ($totalEmployees <= $packageDetail->number_of_employee) ? true : false;

                view()->composer([
                    'employee.index',
                ], function ($view) use ($isAllowToCreateEmployee) {
                    $view->with('isAllowToCreateEmployee', $isAllowToCreateEmployee);
                });
            }

            return $next($request);
        }
    }
}
