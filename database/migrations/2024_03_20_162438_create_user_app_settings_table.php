<?php

use App\Enums\AppTheme;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_app_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique();
            $table->enum('theme', array_map(fn ($theme) => $theme->value, AppTheme::cases()))
                ->default(AppTheme::Light);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_app_settings');
    }
};
