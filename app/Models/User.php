<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract {
  use Authenticatable, Authorizable;

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'name', 'email',
  ];
  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var string[]
   */
  protected $hidden = [
    'password',
  ];

  public function toArray(): array {
    return [
      "id" => $this->id,
      "username" => $this->username,
      "first_name" => $this->first_name,
      "last_name" => $this->last_name,
      "email" => $this->email,
    ];
  }
}
