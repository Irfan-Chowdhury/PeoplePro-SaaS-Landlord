<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->text('heading');
            $table->text('sub_heading');
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('language_id', 'module_descriptions_language_id_foreign')->references('id')->on('languages')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('module_descriptions', function (Blueprint $table) {
            $table->dropForeign('module_descriptions_language_id_foreign');
            $table->dropIfExists('module_descriptions');
        });
    }
};
