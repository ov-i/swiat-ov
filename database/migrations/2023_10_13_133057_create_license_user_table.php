<?php

use App\Enums\License\LicenseBillingPeriodEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('license_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->constrained('licenses');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('billing_period', LicenseBillingPeriodEnum::toArray());
            $table->boolean('is_active')->default(false);
            $table->boolean('is_stopped')->nullable();
            $table->timestamp('stopped_at')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_user');
    }
};
