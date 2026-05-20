<?php

use Src\Utils\ControllerUtils;
use Src\Service\BookReservation\BookReservationUpdaterService;

final readonly class BookReservationPutController
{
    private BookReservationUpdaterService $service;

    public function __construct()
    {
        $this->service = new BookReservationUpdaterService();
    }

    public function start(): void
    {
        $id     = (int) ControllerUtils::getPost('id');
        $estado = ControllerUtils::getPost('estado');

        $this->service->updateEstado($id, $estado);
    }
}
