<?php

declare(strict_types=1);

namespace Src\Infrastructure\Repository\Book;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\Book\Book;
use Src\Entity\Book\Exception\BookNotFoundException;

final readonly class BookRepository extends PDOManager implements BookRepositoryInterface
{
    public function find(int $id): ?Book
    {
        $query = "SELECT * FROM books WHERE id = :id";
        $parameters = ["id" => $id];

        $result = $this->execute($query, $parameters);

        if (empty($result)) {
            throw new BookNotFoundException($id);
        }

        return $this->primitiveToBook($result[0]);
    }


    public function search(
        ?string $titulo = null,
        ?string $autor = null,
        ?string $materia = null,
        ?string $editorial = null,
        ?int $anio = null,
        ?bool $disponibilidad = null,
        ?bool $reservada = null
    ): array {
        $query = "SELECT * FROM books WHERE 1=1";
        $params = [];

        if ($titulo !== null && $titulo !== '') {
            $query .= " AND titulo LIKE :titulo";
            $params["titulo"] = "%$titulo%";
        }

        if ($autor !== null && $autor !== '') {
            $query .= " AND autor LIKE :autor";
            $params["autor"] = "%$autor%";
        }

        if ($materia !== null && $materia !== '') {
            $query .= " AND materia LIKE :materia";
            $params["materia"] = "%$materia%";
        }

        if ($editorial !== null && $editorial !== '') {
            $query .= " AND editorial LIKE :editorial";
            $params["editorial"] = "%$editorial%";
        }

        if ($anio !== null) {
            $query .= " AND anio = :anio";
            $params["anio"] = $anio;
        }

        if ($disponibilidad !== null) {
            $query .= " AND disponibilidad = :disponibilidad";
            $params["disponibilidad"] = $disponibilidad ? 1 : 0;
        }

        if ($reservada !== null) {
            $query .= " AND reservada = :reservada";
            $params["reservada"] = $reservada ? 1 : 0;
        }

        $results = $this->execute($query, $params);

        $bookResults = [];
        foreach ($results as $result) {
            $bookResults[] = $this->primitiveToBook($result);
        }

        return $bookResults;
    }

    private function primitiveToBook(?array $primitive): ?Book
    {
        if ($primitive === null) {
            return null;
        }

        return new Book(
            $primitive["id"],
            $primitive["codigo"],
            $primitive["materia"],
            $primitive["titulo"],
            $primitive["autor"],
            $primitive["editorial"],
            $primitive["edicion"],
            (int)$primitive["anio"],
            (bool)$primitive["disponibilidad"],
            (bool)$primitive["reservada"]
        );
    }
}
