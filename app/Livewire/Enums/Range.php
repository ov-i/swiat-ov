<?php

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;

enum Range: string
{
    case All_Time = 'all';
    case Year = 'year';
    case Last_30 = 'last30';
    case Last_7 = 'last7';
    case Today = 'today';

    public function label(): string
    {
        return match($this) {
            static::All_Time => 'All Time',
            static::Year => 'This Year',
            static::Last_30 => 'Last 30 days',
            static::Last_7 => 'Last 7 days',
            static::Today => 'Today',
        };
    }

    /**
     * @return array<Carbon, Carbon>
     * @throws InvalidFormatException 
     */
    public function dates(): array
    {
        return match($this) {
            static::Today => [Carbon::today(), now()],
            static::Last_7 => [Carbon::today()->subDays(6), now()],
            static::Last_30 => [Carbon::today()->subDays(30), now()],
            static::Year => [now()->startOfYear(), now()],
            default => throw new InvalidFormatException()
        };
    } 
}