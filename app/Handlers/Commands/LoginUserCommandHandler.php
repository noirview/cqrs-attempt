<?php

namespace App\Handlers\Commands;

use App\Commands\Auth\LoginUserCommand;
use App\Events\Auth\UserLoggedInEvent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUserCommandHandler
{
    /**
     * @param LoginUserCommand $command
     * @return array{User, string}
     */
    public function handle(LoginUserCommand $command): array
    {
        $user = User::query()->where([
            'email' => $command->email,
        ])->firstOrFail();

        if (!Hash::check($command->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        event(new UserLoggedInEvent($user));

        return [$user, $token];
    }
}
