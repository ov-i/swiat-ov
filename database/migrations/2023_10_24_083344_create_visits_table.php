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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('client_ip');
            $table->string('lang');
            $table->timestampTz('timezone');
            $table->string('device_orientation');
            $table->string('device_angle');
            $table->string('path');
            $table->string('referrer')->nullable();
            $table->string('width');
            $table->string('height');
            $table->timestampTz('local_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
