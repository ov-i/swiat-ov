<?php

use App\Enums\Post\AllowPostLangsEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lang_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts');

            if (config('database.default') === 'mysql') {
                $table->set('langs', AllowPostLangsEnum::toValues());
            } else {
                $table->enum('langs', AllowPostLangsEnum::cases());
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lang_post');
    }
};
