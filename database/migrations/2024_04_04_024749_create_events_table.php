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
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('name');
            $table->string('cover_photo');
            $table->string('location')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('date')->nullable()->default(null);
            $table->string('time')->nullable()->default(null);
            $table->string('promotion')->nullable()->default(null);
            $table->string('status')->default('ACTIVE');
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
