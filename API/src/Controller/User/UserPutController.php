<?php 

use Src\Utils\ControllerUtils;
use Src\Service\User\UserUpdaterService;

final readonly class UserPutController {
    private UserUpdaterService $service;

    public function __construct() {
        $this->service = new UserUpdaterService();
    }

    public function start(int $id): void
    {
        $name = ControllerUtils::getPost("name");
        $genre_id = ControllerUtils::getPost("genre_id");
        $description = ControllerUtils::getPost("description");
        $image = ControllerUtils::getPost("image");
        $date = ControllerUtils::getPost("date");

        $this->service->update($name, $genre_id, $description, $image, $date, $id);
    }
}