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
            $table->uuid('id')->primary()->unique()->index();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('type');
            $table->string('dob');
            $table->json('fav_music')->nullable()->default(null);
            $table->longText('token')->nullable()->default(null);
            $table->date('token_expired')->nullable()->default(null);
            $table->string('vote_genre')->nullable()->default(null);
            $table->rememberToken();
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
