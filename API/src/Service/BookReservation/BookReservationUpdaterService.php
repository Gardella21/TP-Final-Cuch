<?php

namespace Src\Service\BookReservation;

use Src\Infrastructure\Repository\BookReservation\BookReservationRepository;
use Src\Service\Book\BookFinderService;
use Src\Service\Notification\BookReservationMailService;

final readonly class BookReservationUpdaterService
{
    private BookReservationRepository $repository;
    private BookFinderService $bookFinder;
    private BookReservationMailService $mailService;

    public function __construct()
    {
        $this->repository  = new BookReservationRepository();
        $this->bookFinder  = new BookFinderService();
        $this->mailService = new BookReservationMailService();
    }

    public function updateEstado(int $id, string $estado): void
    {
        $allowed = ['pendiente', 'confirmada', 'cancelada'];
        if (!in_array($estado, $allowed, true)) {
            throw new \InvalidArgumentException("Estado inválido: $estado");
        }

        // 1) Actualizar el estado en la base (lo que ya hacía)
        $this->repository->updateEstado($id, $estado);

        // 2) Avisar por mail según la decisión del admin.
        //    Solo mandamos mail si pasó a 'confirmada' o 'cancelada'
        //    (si vuelve a 'pendiente' no notificamos nada).
        //    try/catch para que un fallo de mail NO rompa la actualización.
        if ($estado === 'pendiente') {
            return;
        }

        try {
            $reservation = $this->repository->find($id);
            if ($reservation === null) {
                return; // no debería pasar, pero por las dudas
            }

            $book = $this->bookFinder->find($reservation->idBook());

            if ($estado === 'confirmada') {
                $this->mailService->sendAccepted($reservation, $book);
            } elseif ($estado === 'cancelada') {
                $this->mailService->sendRejected($reservation, $book);
            }
        } catch (\Throwable $e) {
            error_log("[BookReservationMail] Error enviando mail de decisión: " . $e->getMessage());
        }
    }
}