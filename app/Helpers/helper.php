<?php

use App\Models\MailSetting;
use Illuminate\Support\Facades\Crypt;

function tenantPath(){
    return 'tenants/'.tenant('id');
}

?>
