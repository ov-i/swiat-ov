<?php

namespace App\Models\SEO;

use Illuminate\Database\Eloquent\Model;

class SiteMap extends Model
{
    protected $fillable = [
        'location',
        'last_modificated',
        'change_freq',
        'priority',
    ];
}
