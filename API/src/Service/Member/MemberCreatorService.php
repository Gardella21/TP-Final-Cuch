<?php

namespace Src\Service\Member;

use Src\Entity\Member\Member;
use Src\Entity\Member\Exception\MemberAlreadyExistsException;
use Src\Infrastructure\Repository\Member\MemberRepository;

final readonly class MemberCreatorService
{
    private MemberRepository $repository;

    public function __construct()
    {
        $this->repository = new MemberRepository();
    }

    public function create(
        string $name,
        string $surname,
        string $dni,
        string $email,
        string $phone,
        string $address,
        string $birthDate
    ): void {
        // Evitamos solicitudes duplicadas con el mismo DNI //
        if ($this->repository->findByDni($dni) !== null) {
            throw new MemberAlreadyExistsException($dni);
        }

        $member = Member::create($name, $surname, $dni, $email, $phone, $address, $birthDate);
        $this->repository->insert($member);
    }
}
