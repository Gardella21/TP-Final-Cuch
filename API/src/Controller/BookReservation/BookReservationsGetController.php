<?php

use Src\Service\BookReservation\BookReservationsSearcherService;

final readonly class BookReservationsGetController
{
    private BookReservationsSearcherService $service;

    public function __construct()
    {
        $this->service = new BookReservationsSearcherService();
    }

    public function start(): void
    {
        $reservations = $this->service->search();
        echo json_encode($reservations);
    }
}
