<?php 

namespace Src\Service\Article;

use Src\Infrastructure\Repository\Article\ArticleRepository;

final readonly class ArticlesSearcherService {

    private ArticleRepository $repository;

    public function __construct() {
        $this->repository = new ArticleRepository();
    }

    public function search(): array
    {
        return $this->repository->search();
    }
}