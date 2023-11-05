<?php

namespace Coderflex\LaravelTicket\Database\Factories;

use App\Enums\Ticket\TicketPriorityEnum;
use App\Enums\Ticket\TicketStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        $tableName = config('laravel_ticket.table_names.tickets', 'tickets');

        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title');
            $table->string('message')->nullable();
            $table->enum('priority', TicketPriorityEnum::cases())->default(TicketPriorityEnum::low()->value);
            $table->enum('status', TicketStatusEnum::cases())->default(TicketStatusEnum::open()->value);
            $table->boolean('is_resolved')->default(false);
            $table->boolean('is_declined')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
