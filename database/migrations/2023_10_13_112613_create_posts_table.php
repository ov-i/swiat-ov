<?php

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('title', 120)->unique();
            $table->enum('type', array_map(fn ($type) => $type->value, PostType::cases()))
                ->default(PostType::Post);
            $table->enum('status', array_map(fn ($status) => $status->value, PostStatus::cases()))
                ->default(PostStatus::Unpublished);
            $table->string('thumbnail_path')->nullable();
            $table->longText('content');
            $table->boolean('archived')->default(false);
            $table->date('archived_at')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
