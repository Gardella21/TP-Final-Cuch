<?php 

use Src\Service\User\UsersSearcherService;

final readonly class UsersGetController {
    private UsersSearcherService $service;

    public function __construct() {
        $this->service = new UsersSearcherService();
    }

    public function start(): void
    {
        $users = $this->service->search();
        echo json_encode($this->toResponse($users));
    }

    private function toResponse(array $users): array 
    {
        $responses = [];
        
        foreach($users as $user) {
            $responses[] = [
                "id" => $user->id(),
                "name" => $user->name(),
                "genre_id" => $user->genre_id(),
                "description" => $user->description(),
                "image" => $user->image(),
                "date" => $user->date()
            ];
        }

        return $responses;
    }
}