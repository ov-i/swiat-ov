<?php

namespace App\Models\Auth;

use Database\Factories\Auth\RoleFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Role extends \Spatie\Permission\Models\Role
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @return Factory<self>
     */
    protected static function newFactory(): Factory
    {
        return RoleFactory::new();
    }

    /**
     * @return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
        return parent::users()->withTimestamps();
    }

    /**
     * @return BelongsToMany<Permission>
     */
    public function permissions(): BelongsToMany
    {
        return parent::permissions()->withTimestamps();
    }


}
