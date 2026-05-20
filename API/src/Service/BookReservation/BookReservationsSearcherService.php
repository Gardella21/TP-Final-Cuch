<?php

namespace Src\Service\BookReservation;

use Src\Infrastructure\Repository\BookReservation\BookReservationRepository;

final readonly class BookReservationsSearcherService
{
    private BookReservationRepository $repository;

    public function __construct()
    {
        $this->repository = new BookReservationRepository();
    }

    public function search(): array
    {
        return $this->repository->search();
    }
}
