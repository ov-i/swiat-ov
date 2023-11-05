<?php

namespace App\Models\Tickets;

use Coderflex\LaravelTicket\Concerns\HasVisibility;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasVisibility;

    protected $guarded = [];

    /**
     * @return HasMany<Ticket>
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function getTable(): string
    {
        return config('laravel_ticket.table_names.categories');
    }

    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }
}
