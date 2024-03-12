<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->ipAddress('ip');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->enum('status', UserStatusEnum::toValues())->default(UserStatusEnum::active()->value);
            $table->timestamp('last_login_at')->nullable();
            $table->enum('ban_duration', BanDurationEnum::toValues())->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestampsTz();
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
