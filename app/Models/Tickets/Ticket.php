<?php

namespace App\Models\Tickets;

use App\Enums\Ticket\TicketPriorityEnum;
use App\Enums\Ticket\TicketStatusEnum;
use App\Models\User;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Message;
use Coderflex\LaravelTicket\Scopes\TicketScope;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Coderflex\LaravelTicket\Concerns;
use Database\Factories\Tickets\TicketFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @property string $uuid
 * @property int $user_id
 * @property int $title
 * @property ?string $message
 * @property string $priority
 * @property string $status
 * @property bool $is_resolved
 * @property bool $is_locked
 * @property ?int $assigned_to
 * @property ?DateTime $deleted_at
 */
class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Concerns\InteractsWithTicketRelations;
    use Concerns\InteractsWithTickets;
    use HasFactory;
    use TicketScope;

    protected $guarded = [];

    protected $casts = [
        'priority' => TicketPriorityEnum::class,
        'status' => TicketStatusEnum::class
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'assigned_to');
    }

    /**
     * Get Messages RelationShip
     *
     * @return HasMany<Message>
     */
    public function messages(): HasMany
    {
        $tableName = config('laravel_ticket.table_names.messages', 'messages');

        return $this->hasMany(
            Message::class,
            (string) $tableName['columns']['ticket_foreing_id'],
        );
    }

    /**
     * @return BelongsToMany<Label>
     */
    public function labels(): BelongsToMany
    {
        $table = config('laravel_ticket.table_names.label_ticket', 'label_ticket');

        return $this->belongsToMany(
            Label::class,
            $table['table'],
            $table['columns']['ticket_foreign_id'],
            $table['columns']['label_foreign_id'],
        );
    }

    /**
     * @return BelongsTo<Category, self>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getTable(): string
    {
        return config(
            'laravel_ticket.table_names.tickets',
            parent::getTable()
        );
    }

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return TicketFactory::new();
    }
}
