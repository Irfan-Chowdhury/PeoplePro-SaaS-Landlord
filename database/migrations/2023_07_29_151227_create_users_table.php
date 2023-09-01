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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('role_id')->nullable();
            $table->string('first_name',191);
            $table->string('last_name',191);
            $table->string('username', 191)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->nullable();
            $table->boolean('is_super_admin')->default(false);
            $table->rememberToken();
            $table->timestamps();

            // $table->foreign('role_id', 'users_role_id_foreign')->references('id')->on('roles')->onDelete('set NULL');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropForeign('users_role_id_foreign');
            $table->dropIfExists('users');
        });
    }
};
