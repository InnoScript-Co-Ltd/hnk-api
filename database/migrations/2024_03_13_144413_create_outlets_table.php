<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $table->string('branch')->nullable()->default(null);
            $table->date('month')->nullable()->default(null);
            $table->date('activation_date')->nullable()->default(null);
            $table->longtext('description')->nullable()->default(null);
            $table->string('music_band')->nullable()->default(null);
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
