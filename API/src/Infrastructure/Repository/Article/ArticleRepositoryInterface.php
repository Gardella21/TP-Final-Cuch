<?php 

declare(strict_types = 1);

namespace Src\Infrastructure\Repository\Article;

use Src\Entity\Article\Article;

interface ArticleRepositoryInterface {
    public function find(int $id): ?Article;

    /** @return Article[] */
    public function search(): array;

    public function insert(Article $article): void;

    public function update(Article $article): void;
}