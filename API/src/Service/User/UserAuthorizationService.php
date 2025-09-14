<?php

declare(strict_types=1);

namespace Src\Service\User;

use Src\Infrastructure\Repository\User\UserRepository;

final readonly class UserAuthorizationService
{
    private UserRepository $repository;
    private UserFinderService $finder;

    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->finder = new UserFinderService();
    }
  //  Agrego metodo para autorizar adm por super_adm//
    public function authorizeAdministrative(int $superAdmId, int $admId): void
    {
        $superAdm = $this->finder->find($superAdmId);
        if ($superAdm->role() !== 'super_adm') {
            throw new \Exception("No autorizado: solo super_adm puede autorizar administrativos (adm).");
        }

        $user = $this->finder->find($admId);
        if ($user->role() !== 'adm') {
            throw new \Exception("Solo se pueden autorizar usuarios con rol 'adm'.");
        }

        $this->repository->authorizeAdministrative($admId);
    }
}
