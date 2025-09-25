<?php 

declare(strict_types = 1);

namespace Src\Infrastructure\Repository\Event;

use Src\Entity\Event\Event;

interface EventRepositoryInterface {

    public function search(): array;

    public function insert(Event $event): void;
}
