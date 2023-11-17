<?php

use App\Enums\Auth\BanDurationEnum;
use App\Enums\Auth\UserBlockHistoryActionEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_block_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('action', UserBlockHistoryActionEnum::toValues());
            $table->enum('ban_duration', BanDurationEnum::toValues())->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_block_histories');
    }
};
