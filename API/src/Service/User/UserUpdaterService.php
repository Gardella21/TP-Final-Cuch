<?php 

namespace Src\Service\User;

use Src\Entity\User\User;
use Src\Infrastructure\Repository\User\UserRepository;
use Src\Service\Gender;
use Src\Service\Gender\GenderFinderService;

final readonly class UserUpdaterService {
    private UserRepository $repository;
    private UserFinderService $finder;

    private GenderFinderService $genderFinder;

    public function __construct() {
        $this->repository = new UserRepository();
        $this->finder = new UserFinderService();
        $this->genderFinder = new GenderFinderService();

    }

    public function update(string $name, int $genre_id, string $description, string $image, string $date, int $id): void
    {
        $this ->genderFinder->find($genre_id);
        $movie = $this->finder->find($id);

        $movie->modify($name, $genre_id, $description, $image, $date);

        $this->repository->update($movie);
    } 
}