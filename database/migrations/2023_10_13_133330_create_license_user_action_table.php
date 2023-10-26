<?php

use App\Enums\License\LicenseUserActionEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('license_user_action', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->constrained('licenses');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('action', LicenseUserActionEnum::toValues());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_user_action');
    }
};
