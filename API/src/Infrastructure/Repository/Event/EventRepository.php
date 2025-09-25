<?php 

declare(strict_types = 1);

namespace Src\Infrastructure\Repository\Event;

use DateTime;   // 👈 importamos la clase global de PHP
use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\Event\Event;

final readonly class EventRepository extends PDOManager implements EventRepositoryInterface
{
    public function search(): array
    {
        $query = <<<SQL
            SELECT 
                A.id,
                A.title,
                A.description,
                A.image,
                A.end_date,
                A.is_Active AS is_active
            FROM events A
            WHERE A.is_Active = 1
            ORDER BY A.id DESC
        SQL;

        $results = $this->execute($query);

        if (!is_array($results) || !$results) {
            return [];
        }

        $eventsResults = [];
        foreach ($results as $result) {
            $eventsResults[] = $this->primitiveToEvent($result);
        }

        return $eventsResults;
    }

     public function insert(Event $event): void
    {
        $query = "INSERT INTO events (title, description, image, end_date, is_active) 
                    VALUES (:title, :description, :image, :end_date, :is_active) ";

        $parameters = [
            "title" => $event->title(),
            "description" => $event->description(),
            "image" => $event->image(),
            "end_date" => $event->endDate()->format('Y-m-d'),
            "is_active"=>$event->is_active()
        ];

        $this->execute($query, $parameters);
    }




    private function primitiveToEvent(?array $primitive): ?Event
    {
        if ($primitive === null) {
            return null;
        }

        return new Event(
            (int) $primitive["id"],
            (string) $primitive["title"],
            (string) $primitive["description"],
            (string) $primitive["image"],
            !empty($primitive["end_date"]) ? new DateTime($primitive["end_date"]) : null,
            (bool) ($primitive["is_active"] ?? 0)
        );
    }
}
