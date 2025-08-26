<?php 

declare(strict_types = 1);

namespace Src\Infrastructure\Repository\Article;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\Article\Article;

final readonly class ArticleRepository extends PDOManager implements ArticleRepositoryInterface {

    public function find(int $id): ?Article 
    {
        $query = "SELECT * FROM articles WHERE id = :id";

        $parameters = [
            "id" => $id
        ];

        $result = $this->execute($query, $parameters);
        
        return $this->primitiveToArticle($result[0] ?? null);
    }

    public function search(): array
    {
        $query = "SELECT * FROM articles";
        $results = $this->execute($query);

        $articleResults = [];
        foreach ($results as $result) {
            $articleResults[] = $this->primitiveToArticle($result);
        }

        return $articleResults;
    }

    public function insert(Article $article): void
    {
        $query = "INSERT INTO articles (title, image, content, date) VALUES (:title, :image, :content, :date) ";

        $parameters = [
            "title" => $article->title(),
            "image" => $article->image(),
            "content" => $article->content(),
            "date" => $article->date()
        ];

        $this->execute($query, $parameters);
    }

    public function update(Article $article): void
    {
        $query = <<<UPDATE_QUERY
                        UPDATE
                            articles
                        SET
                            title = :title,
                            image = :image,
                            content = :content,
                            date = :date
                        WHERE
                            id = :id
                    UPDATE_QUERY;

        $parameters = [
            "title" => $article->title(),
            "image" => $article->image(),
            "content" => $article->content(),
            "date" => $article->date()->format('Y-m-d H:i:s'),
            "id" => $article->id()
        ];

        $this->execute($query, $parameters);
    }

    private function primitiveToArticle(?array $primitive): ?Article
    {
        if ($primitive === null) {
            return null;
        }

        return new Article(
            $primitive["id"],
            $primitive["title"],
            $primitive["image"],
            $primitive["content"],
            $primitive["date"] 
        );
    }
}