<?php
declare(strict_types=1);

use Src\Service\User\UserLoginService;
use Src\Entity\User\Exception\UserBlockedException;
use Src\Entity\User\Exception\UserInvalidCredentialsException;
use Src\Entity\User\Exception\UserNotFoundException;

final class UserLoginController
{
   public function start(...$args)
    {
        return $this->login();
    }
    public function login()
    {
        header('Content-Type: application/json; charset=utf-8');
        $email = '';
        $password = '';

        $raw = file_get_contents('php://input');
        $data = $raw ? json_decode($raw, true) : null;

        if (is_array($data)) {
            $email    = strtolower(trim($data['email'] ?? ''));
            $password = $data['password'] ?? '';
        } else {
            $email    = strtolower(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';
        }
        $service = new UserLoginService();

        try {
            $payload = $service->login($email, $password);
            http_response_code(200);
            echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        } catch (UserBlockedException $e) {
            http_response_code(403);
            echo json_encode([
                'status'  => 403,
                'code'    => 'USER_BLOCKED',
                'error'   => 'Usuario bloqueado por varios intentos fallidos.',
                'message' => $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
        } catch (UserInvalidCredentialsException|UserNotFoundException $e) {
            http_response_code(401);
            echo json_encode([
                'status'  => 401,
                'code'    => 'INVALID_CREDENTIALS',
                'message' => $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'status'  => 500,
                'message' => 'Ocurrió un error inesperado.',
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
