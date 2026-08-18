<?php

use Src\Middleware\AuthMiddleware;
use Src\Utils\ControllerUtils;
use Src\Service\Member\MemberUpdaterService;
use Src\Entity\User\Exception\UserIsNotAuthorizedException;

final readonly class MemberPutController {
    private MemberUpdaterService $service;
    private AuthMiddleware $auth;

    public function __construct() {
        $this->service = new MemberUpdaterService();
        $this->auth = new AuthMiddleware();
    }

    public function start(int $id): void
    {
        try {
            // Solo personal de la biblioteca puede cambiar el estado //
            $this->auth->authenticate(true, ['admin', 'super_adm']);

            $estado = ControllerUtils::getPost("estado");

            $this->service->updateEstado($id, (string) $estado);

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(["message" => "Estado del socio actualizado correctamente"]);
        }
        catch (UserIsNotAuthorizedException $e) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(["error" => $e->getMessage()]);
        }
        catch (Throwable $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }

        exit;
    }
}
