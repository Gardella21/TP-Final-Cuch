<?php 

namespace Src\Service\Article;

use Src\Infrastructure\Repository\Article\ArticleRepository;

final readonly class ArticleUpdaterService {
    private ArticleRepository $repository;
    private ArticleFinderService $finder;

    public function __construct() {
        $this->repository = new ArticleRepository();
        $this->finder = new ArticleFinderService();
    }

    public function update(string $name, string $code, int $id): void
    {
        $article = $this->finder->find($id);

        $article->modify($name, $code);

        $this->repository->update($article);
    }
}