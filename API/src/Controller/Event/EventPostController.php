<?php

use Src\Middleware\AuthMiddleware;
use Src\Utils\ControllerUtils;
use Src\Service\Event\EventCreatorService;

final readonly class EventPostController{
    private EventCreatorService $service;
    private AuthMiddleware $auth;
    public function __construct() {
        $this->service = new EventCreatorService();
        $this->auth = new AuthMiddleware();
    }

public function start(): void{

        try {
            // Validar token y rol permitido solo 'admin' y 'super_adm' //
            $this->auth->authenticate(true, ['admin', 'super_adm']);

            // Obtener datos del POST //
            $title = ControllerUtils::getPost("title");
            $description = ControllerUtils::getPost("description");
            $image  = ControllerUtils::getPost("image");
            $end_date= ControllerUtils::getPost("end_date");

            // Crear el nuevo artículo //
            $this->service->create($title, $description, $image,$end_date);

            // Respuesta JSON //
            header('Content-Type: application/json');
            http_response_code(201);
            echo json_encode([
                "message" => "Evento creado correctamente",
                "title"   => $title
            ]);
        } catch (Exception $e) {
            // Manejar error //
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }

        exit;
    }
}
