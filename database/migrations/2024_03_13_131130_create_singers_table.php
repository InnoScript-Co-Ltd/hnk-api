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
        Schema::create('singers', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('name')->unique();
            $table->string('profile')->nullable();
            $table->string('slider_image')->nullable();
            $table->string('detail_title')->nullable();
            $table->string('slider_description')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('status')->default('ACTIVE');
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('singers');
    }
};
