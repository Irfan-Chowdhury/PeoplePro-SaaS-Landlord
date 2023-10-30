<?php

namespace App\Http\Middleware\Tenant;

use App\Models\MailSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class SetMailSetting
{
    public function handle(Request $request, Closure $next): Response
    {
        $mailSetting = MailSetting::latest()->first();
        if ($mailSetting) {
            config()->set('mail.driver', $mailSetting->driver);
            config()->set('mail.host', $mailSetting->host);
            config()->set('mail.port', $mailSetting->port);
            config()->set('mail.from.address', $mailSetting->from_address);
            config()->set('mail.from.name', $mailSetting->from_name);
            config()->set('mail.username', $mailSetting->username);
            config()->set('mail.password', Crypt::decrypt($mailSetting->password));
            config()->set('mail.encryption', $mailSetting->encryption);
        }
        return $next($request);
    }
}
