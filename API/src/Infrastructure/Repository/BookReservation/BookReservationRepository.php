<?php

declare(strict_types=1);

namespace Src\Infrastructure\Repository\BookReservation;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\BookReservation\BookReservation;
use Src\Entity\BookReservation\Exception\BookReservationNotFoundException;

final readonly class BookReservationRepository extends PDOManager implements BookReservationRepositoryInterface
{
    public function find(int $id): ?BookReservation
    {
        $query = <<<SQL
            SELECT r.*, b.titulo AS book_titulo, b.codigo AS book_codigo
            FROM book_reservations r
            LEFT JOIN books b ON b.id = r.id_book
            WHERE r.id = :id
        SQL;

        $result = $this->execute($query, ['id' => $id]);

        if (empty($result)) {
            throw new BookReservationNotFoundException($id);
        }

        return $this->primitiveToReservation($result[0]);
    }

    public function search(): array
    {
        $query = <<<SQL
            SELECT r.*, b.titulo AS book_titulo, b.codigo AS book_codigo
            FROM book_reservations r
            LEFT JOIN books b ON b.id = r.id_book
            ORDER BY r.id DESC
        SQL;

        $results = $this->execute($query);

        if (!is_array($results) || !$results) return [];

        return array_map([$this, 'primitiveToReservation'], $results);
    }

    public function searchByBook(int $idBook): array
    {
        $query = <<<SQL
            SELECT r.*, b.titulo AS book_titulo, b.codigo AS book_codigo
            FROM book_reservations r
            LEFT JOIN books b ON b.id = r.id_book
            WHERE r.id_book = :id_book
            ORDER BY r.id DESC
        SQL;

        $results = $this->execute($query, ['id_book' => $idBook]);

        if (!is_array($results) || !$results) return [];

        return array_map([$this, 'primitiveToReservation'], $results);
    }

    public function insert(BookReservation $reservation): void
    {
        $query = <<<SQL
            INSERT INTO book_reservations (name, surname, email, phone, id_book)
            VALUES (:name, :surname, :email, :phone, :id_book)
        SQL;

        $this->execute($query, [
            'name'    => $reservation->name(),
            'surname' => $reservation->surname(),
            'email'   => $reservation->email(),
            'phone'   => $reservation->phone(),
            'id_book' => $reservation->idBook(),
        ]);
    }

    public function updateEstado(int $id, string $estado): void
    {
        $query = "UPDATE book_reservations SET estado = :estado WHERE id = :id";
        $this->execute($query, ['estado' => $estado, 'id' => $id]);
    }

    private function primitiveToReservation(?array $p): ?BookReservation
    {
        if ($p === null) return null;

        return new BookReservation(
            (int)$p['id'],
            (string)$p['name'],
            (string)$p['surname'],
            (string)$p['email'],
            (int)$p['phone'],
            (int)$p['id_book'],
            $p['book_titulo'] ?? null,
            $p['book_codigo'] ?? null,
            (string)$p['estado'],
            $p['fecha_reserva'] ?? null
        );
    }
}
