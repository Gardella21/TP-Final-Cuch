<?php

namespace Src\Entity\BookReservation\Exception;

final class BookReservationNotFoundException extends \RuntimeException
{
    public function __construct(int $id)
    {
        parent::__construct("Reserva con id $id no encontrada.", 404);
    }
}
