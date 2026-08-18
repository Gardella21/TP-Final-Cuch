<?php

namespace Src\Service\Member;

use Src\Infrastructure\Repository\Member\MemberRepository;

final readonly class MembersSearcherService
{
    private MemberRepository $repository;

    public function __construct()
    {
        $this->repository = new MemberRepository();
    }

    public function search(): array
    {
        return $this->repository->search();
    }
}
