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
        Schema::create('outlets', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();;
            $table->string('name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->string('promotion')->nullable();
            $table->longText('promo_description')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};
