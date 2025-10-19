<?php
declare(strict_types=1);

namespace Src\Infrastructure\Repository\User;

use Src\Entity\User\User;

interface UserRepositoryInterface
{
    // -------- Lectura --------//
    public function find(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function findByDni(string $dni): ?User;
    public function findByToken(string $token): ?User;
    // -------- Escritura -------- //
    public function insert(User $user): void;
    public function create(array $fields): User; 
    public function update(User $user): void;
    public function updateToken(User $user): void;
    public function delete(int $id): void;
    // -------- Listados -------- //
    public function findAllActive(): array;
    public function findAllPending(): array;
    public function findAllBlocked(): array;
    // -------- Aprobación / Activación --------
    public function authorizeAdmin(int $userId): void; 
    public function activateUser(int $userId): void;  
    // -------- Roles -------- //
    public function updateRole(int $userId, string $role): void;
    // -------- Seguridad (login) -------- //
    public function incrementFailedAttempts(int $userId): void;
    public function resetFailedAttempts(int $userId): void;
    public function getFailedAttempts(int $userId): int;
    public function blockUser(int $userId): void;
}
