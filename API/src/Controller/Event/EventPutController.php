<?php

use Src\Middleware\AuthMiddleware;
use Src\Utils\ControllerUtils;
use Src\Service\Event\EventUpdaterService;

final readonly class EventPutController {
    private EventUpdaterService $service;
    private AuthMiddleware $auth;

    public function __construct() {
        // Inicializamos los servicios //
        $this->service = new EventUpdaterService();
        $this->auth = new AuthMiddleware();
    }

    public function start(int $id): void
    {
        try {
            //validar token y rol permitido //
            $this->auth->authenticate(true);

            // Obtener datos JSON del body//
            $title = ControllerUtils::getPost("title");
            $description = ControllerUtils::getPost("description");
            $image  = ControllerUtils::getPost("image");
            $end_date_str  = ControllerUtils::getPost("end_date");
            $end_date = !empty($end_date_str) ? new \DateTime($end_date_str) : null;

            //Actualizar el artículo según el id recibido //
            $this->service->update($id, $title, $description, $image, $end_date);

            //Respuesta JSON //
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(["message" => "Evento actualizado correctamente"]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }

        exit;
    }
}
