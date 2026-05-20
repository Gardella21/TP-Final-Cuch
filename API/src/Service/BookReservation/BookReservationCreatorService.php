<?php

namespace Src\Service\BookReservation;

use Src\Entity\BookReservation\BookReservation;
use Src\Infrastructure\Repository\BookReservation\BookReservationRepository;

final readonly class BookReservationCreatorService
{
    private BookReservationRepository $repository;

    public function __construct()
    {
        $this->repository = new BookReservationRepository();
    }

    public function create(
        string $name,
        string $surname,
        string $email,
        int $phone,
        int $idBook
    ): void {
        $reservation = BookReservation::create($name, $surname, $email, $phone, $idBook);
        $this->repository->insert($reservation);
    }
}
