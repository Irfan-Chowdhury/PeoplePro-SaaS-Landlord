<?php

namespace App\Http\Middleware\Tenant;

use App\Models\GeneralSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetGeneralSetting
{
    public function handle(Request $request, Closure $next): Response
    {
        $generalSetting = GeneralSetting::latest()->first();;
        if (isset($generalSetting->time_zone)) {
            self::setTimeZone($generalSetting);
            self::setRtlLayout($generalSetting);
            self::setClockInClockOut($generalSetting);
            self::setEarlyClockIn($generalSetting);
            self::setAttendanceDeviceDateFormat($generalSetting);
            self::setDateFormat($generalSetting);
            self::setDateFormatJs($generalSetting);
        }
        return $next($request);
    }

    private static function setTimeZone(object $generalSetting): void
    {
        date_default_timezone_set($generalSetting->time_zone);
    }

    private static function setRtlLayout(object $generalSetting): void
    {
        $isEnableRtlLayout = $generalSetting->rtl_layout ? true : false;

        view()->composer([
            'layout.main',
        ], function ($view) use ($isEnableRtlLayout) {
            $view->with('isEnableRtlLayout', $isEnableRtlLayout);
        });
    }

    private static function setClockInClockOut(object $generalSetting): void
    {
        $isEnableClockInClockOut = $generalSetting->enable_clockin_clockout ?? false;

        view()->composer([
            'dashboard.employee_dashboard',
        ], function ($view) use ($isEnableClockInClockOut) {
            $view->with('isEnableClockInClockOut', $isEnableClockInClockOut);
        });
    }

    private static function setEarlyClockIn(object $generalSetting): void
    {
        $isEnableEarlyClockIn = $generalSetting->enable_early_clockin ? true : null;
        Session::put('isEnableEarlyClockIn', $isEnableEarlyClockIn);
    }

    private static function setAttendanceDeviceDateFormat(object $generalSetting): void
    {
        $attendanceDeviceDateFormat = $generalSetting->attendance_device_date_format ?? null;
        Session::put('attendanceDeviceDateFormat', $attendanceDeviceDateFormat);
    }

    private static function setDateFormat(object $generalSetting): void
    {
        $dateFormat = $generalSetting->date_format ?? null;
        Session::put('dateFormat', $dateFormat);
    }
    private static function setDateFormatJs(object $generalSetting): void
    {
        $dateFormatJs = $generalSetting->date_format_js ?? null;
        Session::put('dateFormatJs', $dateFormatJs);
    }

}

// session()->get('dateFormat')
