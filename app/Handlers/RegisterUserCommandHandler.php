<?php

namespace App\Handlers;

use App\Commands\Auth\RegisterUserCommand;
use App\Events\Auth\UserRegisteredEvent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserCommandHandler
{
    public function handle(RegisterUserCommand $command): array
    {
        $user = User::query()->create([
            'name' => $command->name,
            'email' => $command->email,
            'password' => Hash::make($command->password),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        event(new UserRegisteredEvent($user));

        return [$user, $token];
    }
}
