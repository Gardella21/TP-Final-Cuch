<?php
declare(strict_types=1);

namespace Src\Service\User;

use Src\Infrastructure\Repository\User\UserRepository;
use Src\Entity\User\User;
use Src\Entity\User\Exception\UserAlreadyExistsException;
use Src\Entity\User\Exception\InvalidEmailException;

final readonly class UserCreatorService
{
    private UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }
    // Crea un nuevo usuario con los datos proporcionados. //
    public function create(array $data): User
    {
        $name= trim((string)($data['name'] ?? ''));
        $apellido = trim((string)($data['apellido'] ?? ''));
        $dni = trim((string)($data['dni'] ?? ''));
        $email= strtolower(trim((string)($data['email'] ?? '')));
        $password = (string)($data['password'] ?? '');
        // Validaciones basicas //
        if ($name === '')  { throw new \InvalidArgumentException('El nombre es obligatorio'); }
        if ($apellido === '') { throw new \InvalidArgumentException('El apellido es obligatorio'); }
        if ($dni === '') { throw new \InvalidArgumentException('El DNI es obligatorio'); }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }
        if (strlen($password) < 6) {
            throw new \InvalidArgumentException('La contraseña debe tener al menos 6 caracteres');
        }
        // Verificar unicidad de email y dni //
        if ($this->repository->findByEmail($email)) {
            throw new UserAlreadyExistsException();
        }
        if (method_exists($this->repository, 'findByDni') && $dni !== '' && $this->repository->findByDni($dni)) {
            throw new UserAlreadyExistsException();
        }
        // Hash de la contraseña //
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // Crear el usuario //
        try {
            return $this->repository->create([
                'name' => $name,
                'apellido'=> $apellido,
                'dni' => $dni,
                'email'=> $email,
                'password'=> $hash,
                'role'=> 'visitor',
                'is_active'  => 0,
                'is_blocked' => 0,
            ]);
        } catch (\Throwable $e) {
            // Manejo de errores de unicidad a nivel de base de datos //
            if (($e instanceof \PDOException && $e->getCode() === '23000')
                || str_contains($e->getMessage(), 'Duplicate entry')
                || str_contains($e->getMessage(), 'UNIQUE')
                || str_contains($e->getMessage(), 'unique')) {
                throw new UserAlreadyExistsException();
            }
            throw $e;
        }
    }
}
