<?php 

use Src\Service\Article\ArticleFinderService;

final readonly class ArticleGetController {
    private ArticleFinderService $service;

    public function __construct() {
        $this->service = new ArticleFinderService();
    }

    public function start(int $id): void 
    {
        $article = $this->service->find($id);
       
        $MINIO_URL = "http://172.24.224.1:9000/imagenes/";

        echo json_encode([
            "id" => $article->id(),
            "title" => $article->title(),
            "image" => $MINIO_URL . $article->image(),
            "body" => $article->body(),
            "date" => $article->date()->format('Y-m-d H:i:s')
        ], true);

        exit;
    }
}
