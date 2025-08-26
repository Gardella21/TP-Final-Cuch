<?php 

namespace Src\Service\Article;

use Src\Entity\Article\Article;
use Src\Infrastructure\Repository\Article\ArticleRepository;

final readonly class ArticleCreatorService {
    private ArticleRepository $repository;

    public function __construct() {
        $this->repository = new ArticleRepository();
    }

    public function create(string $title, string $image, string $content, string $date): void
    {
        $article = Article::create($title, $image, $content, $date);
        $this->repository->insert($article);
    }
}