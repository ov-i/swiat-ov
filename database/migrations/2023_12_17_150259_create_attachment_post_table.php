<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attachment_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attachment_id')->constrained('attachments');
            $table->foreignId('post_id')->constrained('posts');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_post');
    }
};
