<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Service\User\UserTokenValidatorService;

final class AuthMiddleware {

    private UserTokenValidatorService $validator;

    public function __construct() {
        $this->validator = new UserTokenValidatorService();
    }

    //Valida el token y devuelve el ID del usuario autenticado//
    public function authenticate(): int {
        $token = $_SERVER["HTTP_X_API_KEY"] 
            ?? ($_SERVER["HTTP_AUTHORIZATION"] ?? "");

        if (str_starts_with($token, "Bearer ")) {
            $token = substr($token, 7);
        }

        if (empty($token)) {
            throw new \Exception("Token no enviado.");
        }

        $user = $this->validator->validate($token);
        return $user->id();
    }
}
