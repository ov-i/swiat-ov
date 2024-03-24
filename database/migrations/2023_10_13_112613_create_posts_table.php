<?php

use App\Enums\Post\PostStatusEnum;
use App\Enums\Post\PostTypeEnum;
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
            $table->enum('type', PostTypeEnum::toValues());
            $table->string('thumbnail_path')->nullable();
            $table->longText('content');
            $table->enum('status', PostStatusEnum::toValues())
                ->default(PostStatusEnum::unpublished());
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
