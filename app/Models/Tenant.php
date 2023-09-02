<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasFactory, HasDomains, HasDatabase, SoftDeletes;

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'customer_id',
            'package_id',
            'expiry_date'
        ];
    }
}
