<?php

use Src\Utils\ControllerUtils;
use Src\Service\BookReservation\BookReservationCreatorService;

final readonly class BookReservationPostController
{
    private BookReservationCreatorService $service;

    public function __construct()
    {
        $this->service = new BookReservationCreatorService();
    }

    public function start(): void
    {
        $name    = ControllerUtils::getPost('name');
        $surname = ControllerUtils::getPost('surname');
        $email   = ControllerUtils::getPost('email');
        $phone   = (int) ControllerUtils::getPost('phone');
        $idBook  = (int) ControllerUtils::getPost('id_book');

        $this->service->create($name, $surname, $email, $phone, $idBook);
    }
}
