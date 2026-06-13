<?php 

namespace Src\Service\Inscription;

use Src\Entity\Inscription\Inscription;
use Src\Infrastructure\Repository\Inscription\InscriptionRepository;
use Src\Service\Event\EventFinderService;        
use Src\Service\Notification\InscriptionMailService;

final readonly class InscriptionCreatorService {
    private InscriptionRepository $repository;
    private EventFinderService $eventFinder;
    private InscriptionMailService $mailService;

    public function __construct() {
        $this->repository = new InscriptionRepository();
        $this->eventFinder = new EventFinderService();
        $this->mailService = new InscriptionMailService();
    }

    public function create(string $name, string $surname, string $email, int $phone, int $idEvent): void
    {
        // 1) Crear y guardar la inscripción en la base de datos (lo que ya hacía)
        $inscription = Inscription::create($name, $surname, $email, $phone, $idEvent);
        $this->repository->insert($inscription);

        // 2) Enviar mail de confirmación
        // Lo envolvemos en try/catch para que un error de mail NO rompa la inscripción.
        // Si el mail falla, la inscripción igual queda guardada y se loguea el error.
        try {
            $event = $this->eventFinder->find($idEvent);
            $this->mailService->sendConfirmation($inscription, $event);
        } catch (\Throwable $e) {
            error_log("[InscriptionMail] Error enviando mail: " . $e->getMessage());
        }
    }

}