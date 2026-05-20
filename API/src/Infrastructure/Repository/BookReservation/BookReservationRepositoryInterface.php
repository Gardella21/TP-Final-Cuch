<?php

namespace Src\Infrastructure\Repository\BookReservation;

use Src\Entity\BookReservation\BookReservation;

interface BookReservationRepositoryInterface
{
    public function find(int $id): ?BookReservation;
    public function search(): array;
    public function searchByBook(int $idBook): array;
    public function insert(BookReservation $reservation): void;
    public function updateEstado(int $id, string $estado): void;
}
