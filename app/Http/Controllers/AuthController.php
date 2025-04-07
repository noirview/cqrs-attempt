<?php

namespace App\Http\Controllers;

use App\Commands\Auth\LoginUserCommand;
use App\Commands\Auth\RegisterUserCommand;
use App\Handlers\Commands\LoginUserCommandHandler;
use App\Handlers\Commands\RegisterUserCommandHandler;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterUserCommandHandler $handler): JsonResponse
    {
        $registerUserCommand = new RegisterUserCommand(
            $request->string('name'),
            $request->string('email'),
            $request->string('password'),
        );

        [$user, $token] = $handler->handle($registerUserCommand);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request, LoginUserCommandHandler $handler): JsonResponse
    {
        $loginUserCommand = new LoginUserCommand(
            $request->string('email'),
            $request->string('password'),
        );

        [$user, $token] = $handler->handle($loginUserCommand);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_OK);
    }
}
