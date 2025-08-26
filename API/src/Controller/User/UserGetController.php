<?php 

use Src\Service\User\UserFinderService;

final readonly class UserGetController {

    private UserFinderService $service;

    public function __construct() {
        $this->service = new UserFinderService();
    }

    public function start(int $id): void
    {
        $user = $this->service->find($id);
        
        echo json_encode([
            "id" => $user->id(),
            "name" => $user->name(),
            "genre_id" => $user->genre_id(),
            "description" => $user->description(),
            "image" => $user->image(),
            "date" => $user->date()
        ]);
    }
}