<?php

namespace Src\Infrastructure\Repository\Member;

use Src\Entity\Member\Member;

interface MemberRepositoryInterface
{
    public function find(int $id): ?Member;
    public function findByDni(string $dni): ?Member;
    public function search(): array;
    public function insert(Member $member): void;
    public function updateEstado(int $id, string $estado): void;
    public function delete(int $id): void;
}
