<?php

use Src\Middleware\AuthMiddleware;
use Src\Service\Article\ArticleDeleterService;

final readonly class ArticleDeleteController extends AuthMiddleware {
    private ArticleDeleterService $service;

    public function __construct() {
        $this->service = new ArticleDeleterService();
    }

    public function start(int $id): void
    {
        $this->service->delete($id);
    }
}