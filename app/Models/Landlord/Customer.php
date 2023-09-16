<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'company_name',
        'first_name',
        'last_name',
        'contact_no',
        'email',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function scopeGetFullNameAttribute() {
		return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
	}
}
