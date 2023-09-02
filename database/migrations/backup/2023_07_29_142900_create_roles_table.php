<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('guard_name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
