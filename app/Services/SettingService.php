<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\AnalyticSettingContract;
use App\Contracts\GeneralSettingContract;
use App\Contracts\MailSettingContract;
use App\Contracts\PaymentSettingContract;
use App\Contracts\SeoSettingContract;
use App\Facades\Alert;
use App\Facades\Utility;
use App\Http\traits\ENVFilePutContent;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class SettingService
{

    use ENVFilePutContent;

    private $siteLogoPath = "landlord/images/logo/";
    private $ogImagePath = "landlord/images/seo-setting/";

    public function __construct(
        private GeneralSettingContract $generalSettingContract,
        private PaymentSettingContract $paymentSettingContract,
        private MailSettingContract $mailSettingContract,
        private AnalyticSettingContract $analyticSettingContract,
        private SeoSettingContract $seoSettingContract,
    ){}

    public function getLatestGeneralSettingData() : object | null
    {
        return $this->generalSettingContract->fetchLatestData();
    }

    public function getLatestPaymentSettingData() : object | null
    {
        return $this->paymentSettingContract->fetchLatestData();
    }

    public function getLatestMailSettingData() : object | null
    {
        return $this->mailSettingContract->fetchLatestData();
    }

    public function getLatestAnalyticSettingData() : object | null
    {
        return $this->analyticSettingContract->fetchLatestData();
    }

    public function getLatestSeoSettingData() : object | null
    {
        return $this->seoSettingContract->fetchLatestData();
    }

    public function updateGeneralSetting($request)
    {
        try {
            $data = [
                'site_title' => $request->site_title,
                'time_zone' => $request->time_zone,
                'phone' =>  $request->phone,
                'email' =>  $request->email,
                'free_trial_limit' =>  $request->free_trial_limit,
                'currency_code' =>  $request->currency_code,
                'frontend_layout' =>  $request->frontend_layout,
                'date_format' =>  $request->date_format,
                'footer' =>  $request->footer,
                'footer_link' =>  $request->footer_link,
                'developed_by' =>  $request->developed_by,
            ];

            $this->dataWriteInENVFile('APP_TIMEZONE',$request->time_zone);


            $imageName = $this->imageHandle($request->site_logo, $this->siteLogoPath);
            if($imageName) {
                $data['site_logo'] = $imageName;
            }
            $this->generalSettingContract->updateOrCreate([], $data);

            Utility::setEnv('APP_NAME','"'.$data['site_title'].'"');

            return Alert::successMessage('Data Submitted Successfully');
        }
        catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }


    public function updateMailSetting($request)
    {
        try {
            $data = [
                'driver'  => $request->driver,
                'host' => $request->host,
                'port' => $request->port,
                'from_address' => $request->from_address,
                'from_name' => $request->from_name,
                'username' => $request->username,
                'password' => Crypt::encrypt($request->password),
                'encryption' => $request->encryption,
            ];

            $this->mailSettingContract->updateOrCreate([], $data);

            $this->dataWriteInENVFile('MAIL_PASSWORD', $request->password ?? null);

            return Alert::successMessage('Data Submitted Successfully');
        }
        catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    public function updatePaymentSetting($request)
    {
        try {
            $data = [
                'active_payment_gateway' => implode(",", $request->active_payment_gateway),

                'stripe_public_key'  => Crypt::encrypt($request->stripe_public_key),
                'stripe_secret_key' => Crypt::encrypt($request->stripe_secret_key),
                'stripe_currency' => Crypt::encrypt($request->stripe_currency),

                'paypal_mode' => $request->paypal_mode,
                'paypal_client_id' => Crypt::encrypt($request->paypal_client_id),
                'paypal_client_secret' => Crypt::encrypt($request->paypal_client_secret),

                // 'razorpay_number' => $request->razorpay_number,
                'razorpay_key' => Crypt::encrypt($request->razorpay_key),
                'razorpay_secret' => Crypt::encrypt($request->razorpay_secret),

                'paystack_public_key' => Crypt::encrypt($request->paystack_public_key),
                'paystack_secret_key' => Crypt::encrypt($request->paystack_secret_key),
            ];

            $this->paymentSettingContract->updateOrCreate([], $data);

            // Stripe
            $this->dataWriteInENVFile('STRIPE_KEY', $request->stripe_public_key ?? null);
            $this->dataWriteInENVFile('STRIPE_SECRET', $request->stripe_secret_key ?? null);
            $this->dataWriteInENVFile('STRIPE_CURRENCY', $request->stripe_currency ?? null);

            // Paypal
            $this->dataWriteInENVFile('PAYPAL_MODE', $request->paypal_mode ?? null);
            $this->dataWriteInENVFile('PAYPAL_SANDBOX_CLIENT_ID', $request->paypal_client_id ?? null);
            $this->dataWriteInENVFile('PAYPAL_SANDBOX_CLIENT_SECRET', $request->paypal_client_secret ?? null);

            // Razorpay
            $this->dataWriteInENVFile('RAZORPAY_KEY', $request->razorpay_key ?? null);
            $this->dataWriteInENVFile('RAZORPAY_SECRET', $request->razorpay_secret ?? null);

            // Paystack
            $this->dataWriteInENVFile('PAYSTACK_PUBLIC_KEY', $request->paystack_public_key ?? null);
            $this->dataWriteInENVFile('PAYSTACK_SECRET_KEY', $request->paystack_secret_key ?? null);
            $this->dataWriteInENVFile('PAYSTACK_PAYMENT_URL', $request->paystack_payment_url ?? null);
            $this->dataWriteInENVFile('MERCHANT_EMAIL', $request->paystack_merchant_email ?? null);
            $this->dataWriteInENVFile('PAYSTACK_CURRENCY', $request->paystack_currency ?? null);


            return Alert::successMessage('Data Submitted Successfully');
        }
        catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }


    public function updateAnalyticSetting($request)
    {
        try {
            $data = [
                'google_analytics_script' => $request->google_analytics_script,
                'facebook_pixel_script'  => $request->facebook_pixel_script,
                'chat_script' => $request->chat_script,
            ];

            $this->analyticSettingContract->updateOrCreate([], $data);

            return Alert::successMessage('Data Submitted Successfully');
        }
        catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    public function updateSeoSetting($request)
    {
        try {
            $data = [
                'meta_title' => $request->meta_title,
                'meta_description'  => $request->meta_description,
                'og_title' => $request->og_title,
                'og_description' => $request->og_description,
            ];
            $imageName = $this->imageHandle($request->og_image, $this->ogImagePath);
            if($imageName) {
                $data['og_image'] = $imageName;
            }

            $this->seoSettingContract->updateOrCreate([], $data);

            return Alert::successMessage('Data Submitted Successfully');
        }
        catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }

    protected function imageHandle($image, $path)
    {
        $imageName = null;

        if ($image) {
            $imagesDirectory = public_path($path);

            if (File::isDirectory($imagesDirectory)) {
                File::cleanDirectory($imagesDirectory);
            }

            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = date("Ymdhis") . 1;
            $imageName = $imageName . '.' . $ext;

            $image->move($imagesDirectory, $imageName);
        }
        return $imageName;
    }
}
