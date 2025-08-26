<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Article\ArticleUpdaterService;

final readonly class ArticlePutController {
    private ArticleUpdaterService $service;

    public function __construct() {
        $this->service = new ArticleUpdaterService();
    }

    public function start(int $id): void
    {
        $name = ControllerUtils::getPost("name");
        $code = ControllerUtils::getPost("code");

        $this->service->update($name, $code, $id);
    }
}