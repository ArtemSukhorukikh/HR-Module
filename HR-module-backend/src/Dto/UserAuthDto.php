<?php

namespace App\Dto;


class UserAuthDto
{
    /**
     * @OA\Property(type="string", title="token")
     */
    public string $token;

    public array $roles;
}