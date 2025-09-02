<?php

use Src\Middleware\AuthMiddleware;
use Src\Utils\ControllerUtils;
use Src\Service\Article\ArticleCreatorService;

final readonly class ArticlePostController  {
    private ArticleCreatorService $service;

    public function __construct() {
        $this->service = new ArticleCreatorService();
    }

    public function start(): void
    {
        $title = ControllerUtils::getPost("title");
        $image = ControllerUtils::getPost("image");
        $body = ControllerUtils::getPost("body");

        $this->service->create($title, $image, $body);
    }
}