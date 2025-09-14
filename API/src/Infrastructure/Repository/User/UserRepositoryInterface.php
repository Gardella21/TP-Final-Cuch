<?php 

declare(strict_types = 1);

namespace Src\Infrastructure\Repository\User;

use Src\Entity\User\User;

interface UserRepositoryInterface {
    public function findByEmailAndPassword(string $email, string $password): ?User;
    public function findByToken(string $token): ?User;

    public function insert(User $user): void;
    public function update(User $user): void;
    /*Nuevo Metodos */
    public function find(int $id): ?User;
    public function delete(int $id): void;
    public function search(): array;
    public function authorizeAdministrative(int $userId): void;
}