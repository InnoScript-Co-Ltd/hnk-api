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
        Schema::create('video_in_singers', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->foreignUuid('singer_id')->constrained();
            $table->string('title');
            $table->string('album_name');
            $table->string('video');
            $table->string('status')->default('ACTIVE');
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_in_singers');
    }
};
