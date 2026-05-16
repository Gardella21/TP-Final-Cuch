<?php

namespace Src\Service\BookReservation;

use Src\Infrastructure\Repository\BookReservation\BookReservationRepository;

final readonly class BookReservationUpdaterService
{
    private BookReservationRepository $repository;

    public function __construct()
    {
        $this->repository = new BookReservationRepository();
    }

    public function updateEstado(int $id, string $estado): void
    {
        $allowed = ['pendiente', 'confirmada', 'cancelada'];
        if (!in_array($estado, $allowed, true)) {
            throw new \InvalidArgumentException("Estado inválido: $estado");
        }
        $this->repository->updateEstado($id, $estado);
    }
}
