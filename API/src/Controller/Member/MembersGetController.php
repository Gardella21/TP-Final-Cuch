<?php

use Src\Middleware\AuthMiddleware;
use Src\Service\Member\MembersSearcherService;
use Src\Entity\User\Exception\UserIsNotAuthorizedException;

final readonly class MembersGetController {
    private MembersSearcherService $service;
    private AuthMiddleware $auth;

    public function __construct() {
        $this->service = new MembersSearcherService();
        $this->auth = new AuthMiddleware();
    }

    public function start(): void
    {
        try {
            // Solo personal de la biblioteca puede ver las solicitudes //
            $this->auth->authenticate(true, ['admin', 'super_adm']);

            $members = $this->service->search();

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($members);
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
    }
}
