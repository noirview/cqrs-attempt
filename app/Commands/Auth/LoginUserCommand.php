<?php

namespace App\Commands\Auth;

readonly class LoginUserCommand
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
