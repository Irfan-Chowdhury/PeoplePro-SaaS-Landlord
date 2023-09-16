<?php

namespace App\Models;

use App\Models\Landlord\Customer;
use App\Models\Landlord\Domain;
use App\Models\Landlord\Package;
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

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function domainInfo()
    {
        return $this->hasOne(Domain::class, 'tenant_id');
    }

    // DashboardController
    public function scopeTotalActiveTenantCount($query)
    {
        return $query->where('expiry_date', '>=', now()->format('Y-m-d'))->count();
    }
}
