<?php

namespace App\Models;

/**
 * @property int $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $telegram
 * @property string $email
 */
class User extends \Illuminate\Foundation\Auth\User {
    protected $connection = 'db_auth';

    public function toArray(): array {
        return [
            "id"         => $this->id,
            "username"   => $this->username,
            "first_name" => $this->first_name,
            "last_name"  => $this->last_name,
            "email"      => $this->email,
        ];
    }
}
