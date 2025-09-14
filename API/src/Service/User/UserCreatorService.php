<?php 

namespace Src\Service\User;

use Src\Entity\User\Exception\UserAlreadyExistsException;
use Src\Entity\User\User;
use Src\Infrastructure\Repository\User\UserRepository;
use DateTime;

final readonly class UserCreatorService {
    private UserRepository $repository;
    private UserFinderByEmailService $userFinderByEmailService;

    public function __construct() {
        $this->repository = new UserRepository();
        $this->userFinderByEmailService = new UserFinderByEmailService();
    }
//Agrego campos nuevos role e isActive con valores por defecto//
    public function create(string $name, string $email, string $password,string $role = 'visitor', bool $is_Active = true  ): void
    {
        $user = $this->userFinderByEmailService->find($email);

        if (!empty($user)) {
            throw new UserAlreadyExistsException();
        }

       //Ahora creamos el usuario solo con los parámetros obligatorios//
        $user = User::create($name, $email, $password, $role, $is_Active);

        // Si el rol es admin o super_admin, generamos el token automáticamente//
        if (in_array($role, ['admin', 'super_admin'])) {
            $user->generateToken();
        }

        $this->repository->insert($user);
    }
}
    
