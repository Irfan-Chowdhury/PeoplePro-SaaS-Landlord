<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_analytics_script',
        'facebook_pixel_script',
        'chat_script',
    ];
}
