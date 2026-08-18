<?php

use Src\Utils\ControllerUtils;
use Src\Service\Member\MemberCreatorService;
use Src\Entity\Member\Exception\MemberAlreadyExistsException;

final readonly class MemberPostController {
    private MemberCreatorService $service;

    public function __construct() {
        $this->service = new MemberCreatorService();
    }

    public function start(): void
    {
        try {
            // Ruta publica: cualquier visitante puede enviar la solicitud //
            $name      = ControllerUtils::getPost("name");
            $surname   = ControllerUtils::getPost("surname");
            $dni       = ControllerUtils::getPost("dni");
            $email     = ControllerUtils::getPost("email");
            $phone     = ControllerUtils::getPost("phone");
            $address   = ControllerUtils::getPost("address");
            $birthDate = ControllerUtils::getPost("birth_date");

            $this->service->create(
                (string) $name,
                (string) $surname,
                (string) $dni,
                (string) $email,
                (string) $phone,
                (string) $address,
                (string) $birthDate
            );

            header('Content-Type: application/json');
            http_response_code(201);
            echo json_encode([
                "message" => "Solicitud de asociación registrada correctamente"
            ]);
        }
        // DNI ya registrado //
        catch (MemberAlreadyExistsException $e) {
            header('Content-Type: application/json');
            http_response_code(409);
            echo json_encode(["error" => $e->getMessage()]);
        }
        catch (Throwable $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
