<?php

namespace Src\Service\Member;

use Src\Infrastructure\Repository\Member\MemberRepository;

final readonly class MemberUpdaterService
{
    private MemberRepository $repository;

    public function __construct()
    {
        $this->repository = new MemberRepository();
    }

    public function updateEstado(int $id, string $estado): void
    {
        $allowed = ['pendiente', 'activo', 'rechazado'];

        if (!in_array($estado, $allowed, true)) {
            throw new \InvalidArgumentException("Estado inválido: $estado");
        }

        // Verificamos que exista antes de actualizar //
        $this->repository->find($id);
        $this->repository->updateEstado($id, $estado);
    }
}
