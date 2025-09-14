<?php

use Src\Utils\ControllerUtils;
use Src\Service\User\UserLoginService;

final readonly class UserLoginController {
    private UserLoginService $service;

    public function __construct() {
        $this->service = new UserLoginService();
    }

    public function start(): void
    {
        $email = ControllerUtils::getPost("email");
        $password = ControllerUtils::getPost("password");

        $user = $this->service->login($email, $password);

        echo json_encode([
            "token" => $user->token(),
            "expiration_date" => $user->token_auth_date()->format("Y-m-d H:i:s"),
            /*Agrego role, is_activie obtencion de bd sol*/
            "role" => $user->role(),
            "is_Active" => $user->is_Active()

        ]);
    }
}