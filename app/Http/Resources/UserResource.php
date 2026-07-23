<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Phobiavr\PhoberLaravelCommon\Contracts\AuthUserInterface;
use Phobiavr\PhoberLaravelCommon\Traits\AuthUserArrayable;

class UserResource extends JsonResource implements AuthUserInterface {
    use AuthUserArrayable;

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

    public function getPermissions(): array {
        return $this->resource->permissionNames();
    }

    public function hasPermission(string $permission): bool {
        return in_array($permission, $this->getPermissions(), true);
    }

    public function toArray(Request $request): array {
        return $this->toAuthUserArray();
    }
}
