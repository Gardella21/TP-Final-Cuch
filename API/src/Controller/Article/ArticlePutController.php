<?php

use Src\Middleware\AuthMiddleware;
use Src\Utils\ControllerUtils;
use Src\Service\Article\ArticleUpdaterService;

final readonly class ArticlePutController extends AuthMiddleware {
    private ArticleUpdaterService $service;

    public function __construct() {
        $this->service = new ArticleUpdaterService();
    }

    public function start(int $id): void
    {
        $title = ControllerUtils::getPost("title");
        $image = ControllerUtils::getPost("image");
        $body = ControllerUtils::getPost("body");

        $this->service->update($id, $title, $image, $body);
    }
}