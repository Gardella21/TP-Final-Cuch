<?php 

use Src\Utils\ControllerUtils;
use Src\Service\User\UserUpdaterService;

final readonly class UserPutController {
    private UserUpdaterService $service;

    public function __construct() {
        $this->service = new UserUpdaterService();
    }

    public function start(int $id): void
    {
        $name = ControllerUtils::getPost("name");
        $email = ControllerUtils::getPost("email");
        $password = ControllerUtils::getPost("password");
        $role = ControllerUtils::getPost("role");         // adm, super_adm, visitor
        $is_Active = ControllerUtils::getPost("is_Active"); 



       // Convertimos is_active a booleano si viene como string o número//
        $is_Active = filter_var($is_Active, FILTER_VALIDATE_BOOLEAN);

        // Llamamos al servicio para actualizar el usuario//
        $this->service->update($id, $name, $email, $password, $role, $is_Active);
    }
} 