<?php 
// src/Service/User/UserUpdaterService.php
declare(strict_types=1);

namespace Src\Service\User;

use Src\Entity\User\Exception\UserAlreadyExistsException;
use Src\Entity\User\Exception\UserNotFoundException;
use Src\Entity\User\Exception\InvalidEmailException;
use Src\Entity\User\Exception\InvalidRoleException;
use Src\Infrastructure\Repository\User\UserRepository;

final class UserUpdaterService
{   // Roles permitidos para un usuario //
    private const ALLOWED_ROLES = ['visitor','admin','super_adm'];

    public function __construct(
        private readonly UserRepository $repository = new UserRepository(),
        private readonly UserFinderService $finder = new UserFinderService(),
        private readonly UserFinderByEmailService $finderByEmail = new UserFinderByEmailService(),
    ) {}
    // Actualiza un usuario a partir de un array de datos (solo los campos presentes). //
    public function updateFromArray(int $id, array $in): void
    {
        $current = $this->finder->find($id);
        $name  = array_key_exists('name', $in)&& $in['name']!== null ? (string)$in['name']: $current->name();
        $email = array_key_exists('email', $in)&& $in['email']!== null ? (string)$in['email']: $current->email();
        $password = array_key_exists('password', $in) ? ($in['password'] !== null ? (string)$in['password'] : null) : null;
        $role = array_key_exists('role', $in)&& $in['role']!== null ? (string)$in['role']: $current->role();
        // is_active puede ser true, false o null (no presente) //
        if (!array_key_exists('is_active', $in) || $in['is_active'] === null) {
            $is_active = $current->is_active();
        } else {
            $parsed = filter_var($in['is_active'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $is_active = ($parsed === null) ? $current->is_active() : $parsed;
        }
        // Campos opcionales //
        $apellido = array_key_exists('apellido', $in) ? ($in['apellido'] !== null ? (string)$in['apellido'] : null) : null;
        $dni = array_key_exists('dni', $in)? ($in['dni']!== null ? (string)$in['dni']: null) : null;
        // Llama al update con los valores calculados //
        $this->update($id, $name, $email, $password, $role, $is_active, $apellido, $dni);
    }
    // Actualizamos un usuario con los datos indicados. //
    public function update(
        int $id,
        string $name,
        string $email,
        ?string $password = null,
        string $role = 'visitor',
        bool $is_active = true,
        ?string $apellido = null,
        ?string $dni = null
    ): void {
        $user  = $this->finder->find($id);
        // Validaciones //
        $email = strtolower(trim($email));
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($email);
        }
        // Rol válido //
        if (!in_array($role, self::ALLOWED_ROLES, true)) {
            throw new InvalidRoleException($role === '' ? '(vacío)' : $role);
        }
        // El email no lo use otro usuario //
        try {
            $other = $this->finderByEmail->find($email);
            if ($other->id()!== $id) {
                throw new UserAlreadyExistsException();
            }
        } catch (UserNotFoundException) {
            // OK, no existe otro usuario con ese email //
        }
        // Actualizamos //
        $user->modify($name, $email, $role, $is_active, $password, $apellido, $dni);
        $this->repository->update($user);
    }
}
