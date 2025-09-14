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
                //corrijo metodos//
                "name" => $user->name(),
                "email" => $user->email(),
                "password" => $user->password(),
                "token" => $user->token(),
                "token_auth_date" => $user->token_auth_date()->format("Y-m-d H:i:s"),
                "role" => $user->date(),
                "is_Active" => $user->isActive()
            ];
        }

        return $responses;
    }
}