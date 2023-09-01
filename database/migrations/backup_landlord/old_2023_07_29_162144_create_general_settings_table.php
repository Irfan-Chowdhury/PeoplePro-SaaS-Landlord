<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title');
            $table->string('meta_title', 100)->nullable();
            $table->string('meta_description', 200)->nullable();
            $table->string('og_title', 100)->nullable();
            $table->string('og_description', 200)->nullable();
            $table->string('og_image')->nullable();
            $table->string('site_logo');
            $table->boolean('is_rtl');
            $table->string('date_format');
            $table->string('currency', 10)->default('USD');
            $table->string('currency_position', 10)->nullable();
            $table->string('frontend_layout')->default('regular');
            $table->string('developed_by');
            $table->string('phone');
            $table->string('email');
            $table->double('free_trial_limit');
            $table->longText('chat_script')->nullable();
            $table->longText('ga_script')->nullable();
            $table->longText('fb_pixel_script')->nullable();
            $table->string('active_payment_gateway');
            $table->string('stripe_public_key')->nullable();
            $table->string('paystack_public_key')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->string('paystack_secret_key')->nullable();
            $table->string('paypal_client_id')->nullable();
            $table->string('paypal_client_secret')->nullable();
            $table->string('razorpay_number')->nullable();
            $table->string('razorpay_key')->nullable();
            $table->string('razorpay_secret')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
