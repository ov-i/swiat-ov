<?php

use App\Enums\SEO\SiteMapChangeFreqEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_maps', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->date('last_modificated');
            $table->enum('change_freq', SiteMapChangeFreqEnum::toValues())->default(SiteMapChangeFreqEnum::monthly()->value);
            $table->decimal('priority')->default(0.5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_maps');
    }
};
