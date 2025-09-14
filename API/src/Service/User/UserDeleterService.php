<?php 

namespace Src\Service\User;

use Src\Infrastructure\Repository\User\UserRepository;

final readonly class UserDeleterService {
    private UserRepository $repository;
    private UserFinderService $finder;

    public function __construct() {
        $this->repository = new UserRepository();
        $this->finder = new UserFinderService();
    }

    public function delete(int $id): void
    {
       //verifico si el usuario existe antes de eliminar//
        $user = $this->finder->find($id);
        if ($user === null) {   // Excepción si no existe//
            throw new \Exception("Usuario no encontrado");
        }

        // Eliminamos directamente desde el repository//
        $this->repository->delete($id);  
    } 
}