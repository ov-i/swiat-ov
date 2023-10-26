<?php

namespace App\Models\Auth;

use Database\Factories\Auth\PermissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @return BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return parent::roles()->withTimestamps();
    }

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return PermissionFactory::new();
    }
}
