<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'is_free_trial',
        'monthly_fee',
        'yearly_fee',
        'number_of_user_account',
        'number_of_employee',
        'features',
        'permissions',
        'permission_names',
        'permission_ids',
        // 'role_permission_values',
        'is_active',
        'position'
    ];

}
