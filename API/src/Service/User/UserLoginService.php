<?php
declare(strict_types=1);

namespace Src\Service\User;

use Src\Infrastructure\Repository\User\UserRepository;
use Src\Entity\User\Exception\UserNotFoundException;
use Src\Entity\User\Exception\UserInvalidCredentialsException;
use Src\Entity\User\Exception\UserBlockedException;

final readonly class UserLoginService
{
    // Límite de intentos fallidos antes de bloquear la cuenta //
    private const MAX_ATTEMPTS = 5;

    private UserRepository $repository;
    private UserFinderByEmailService $finder;

    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->finder     = new UserFinderByEmailService();
    }
    // Realiza el login de un usuario con email y password. //
    public function login(string $email, string $password): array
    {
        $email = strtolower(trim($email));
        // Buscar el usuario por email //
        try {
            $user = $this->finder->find($email);
        } catch (UserNotFoundException) {
            throw new UserInvalidCredentialsException(); 
        }
        // Verificar estado del usuario //
        if ($user->is_blocked()) {
            throw new UserBlockedException(); //Usuario bloqueado por varios intentos fallidos//
        }
        if (!$user->is_active()) {
            // mantenemos tu mensaje específico //
            throw new UserInvalidCredentialsException('Tu solicitud está pendiente de aprobación por un administrador.');
        }
        // Verificar contraseña //
        if (!password_verify($password, $user->password())) {
            $this->repository->incrementFailedAttempts($user->id());
            $attempts = $this->repository->getFailedAttempts($user->id());
            // Bloquea desde el 5º fallo //
            if ($attempts >= self::MAX_ATTEMPTS) {
                $this->repository->blockUser($user->id());
                throw new UserBlockedException();
            }
            throw new UserInvalidCredentialsException();
        }
        // Login exitoso, resetear intentos fallidos y generar nuevo token //
        $this->repository->resetFailedAttempts($user->id());
        $user->generateToken();
        $this->repository->updateToken($user);

        // Devolver datos del usuario y token //
        return [
            'status' => 200,
            'message'=> 'Login exitoso.',
            'token'=> $user->token(),
            'user'=> [
                'id' => $user->id(),
                'name' => $user->name(),
                'apellido' => $user->apellido(),
                'dni'=> $user->dni(),
                'email'=> $user->email(),
                'role'=> $user->role(),
                'token' => $user->token(),
            ],
        ];
    }
}
