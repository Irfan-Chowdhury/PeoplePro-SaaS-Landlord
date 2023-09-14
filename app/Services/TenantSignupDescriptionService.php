<?php

namespace App\Services;

use App\Contracts\TenantSignupDescriptionContract;
use App\Facades\Alert;
use Exception;

class TenantSignupDescriptionService
{

    public function __construct(public TenantSignupDescriptionContract $tenantSignupDescriptionContract){}

    public function getLatestData($languageId)
    {
        return $this->tenantSignupDescriptionContract->fetchLatestDataByLanguageId($languageId);
    }

    public function updateOrCreate($request, $languageId)
    {
        try {
            $data = [
                'heading' => $request->heading,
                'sub_heading' => $request->sub_heading
            ];
            $this->tenantSignupDescriptionContract->updateOrCreate(['language_id' => $languageId], $data);

            return Alert::successMessage('Data Submitted Successfully');
        }
        catch (Exception $exception) {
            return Alert::errorMessage($exception->getMessage());
        }
    }
}
