<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Phobiavr\PhoberLaravelCommon\Contracts\AuthUserInterface;

class UserResource extends JsonResource implements AuthUserInterface {
    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getFirstName(): string {
        return $this->first_name;
    }

    public function getLastName(): string {
        return $this->last_name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function toArray(Request $request): array {
        return [
            self::FIELD_ID         => $this->getId(),
            self::FIELD_USERNAME   => $this->getUsername(),
            self::FIELD_FIRST_NAME => $this->getFirstName(),
            self::FIELD_LAST_NAME  => $this->getLastName(),
            self::FIELD_EMAIL      => $this->getEmail(),
        ];
    }
}
