<?php

namespace App\Models\Landlord;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'package_id',
        'amount',
        'payment_method',
        'subscription_type',
        'data'
    ];

    public function domainInfo()
    {
        return $this->hasOne(Domain::class, 'tenant_id','tenant_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
