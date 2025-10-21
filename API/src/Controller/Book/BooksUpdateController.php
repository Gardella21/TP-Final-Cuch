<?php

use Src\Utils\ControllerUtils;
use Src\Service\Book\BooksUpdaterService;

final readonly class BooksUpdateController
{
    private BooksUpdaterService $service;

    public function __construct()
    {
        $this->service = new BooksUpdaterService();
    }

    public function start(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        try {
            $books = ControllerUtils::getPost("books", true);

            if (empty($books)) {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se recibieron libros o el formato es incorrecto'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }

            $result = $this->service->updateBooks($books);

            echo json_encode($result, JSON_UNESCAPED_UNICODE);

        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
