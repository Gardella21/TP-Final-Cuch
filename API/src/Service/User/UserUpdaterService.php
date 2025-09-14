<?php 

namespace Src\Service\User;

use Src\Entity\User\User;
use Src\Infrastructure\Repository\User\UserRepository;

final readonly class UserUpdaterService {
    private UserRepository $repository;
    private UserFinderService $finder;

    public function __construct() {
        $this->repository = new UserRepository();
        $this->finder = new UserFinderService();
    }

    public function update(
        int $id, 
        string $name, 
        string $email, 
        ?string $password = null, 
        string $role = 'visitor', 
        bool $is_Active = true
    ): void {
        // Busco el usuario por su ID//
        $user = $this->finder->find($id);

        // Modifico sus datos usando el método modify de la entidad User//
        $user->modify(
            $name,
            $email,
            $password,
            $role,
            $is_Active
        );

        // Guardo los cambios en la base de datos//
        $this->repository->update($user);
    } 
}
