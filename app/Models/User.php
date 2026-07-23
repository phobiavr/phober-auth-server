<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $telegram
 * @property string $email
 */
class User extends \Illuminate\Foundation\Auth\User {
    public function toArray(): array {
        return [
            "id"         => $this->id,
            "username"   => $this->username,
            "first_name" => $this->first_name,
            "last_name"  => $this->last_name,
            "email"      => $this->email,
        ];
    }

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function permissions(): BelongsToMany {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    public function permissionNames(): array {
        $direct = $this->permissions()->pluck('name');
        $viaRoles = Permission::query()
            ->whereHas('roles.users', fn ($query) => $query->whereKey($this->id))
            ->pluck('name');

        return $direct->merge($viaRoles)->unique()->values()->all();
    }
}
