<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('outlets', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->string('promotion')->nullable();
            $table->longText('promo_description')->nullable();
            $table->float('latitude', 9, 6)->nullable();
            $table->float('longitude', 9, 6)->nullable();
            $table->string('branch');
            $table->date('month');
            $table->date('activation_date');
            $table->longtext('description')->nullable()->default(null);
            $table->string('music_band');
            $table->string('status')->default('ACTIVE');
            $table->auditColumns();
        });

        DB::table('outlets')->update(['month' => DB::raw('MONTH(date)')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};
