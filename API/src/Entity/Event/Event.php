<?php 

namespace Src\Entity\Event;
use DateTime;

final class Event {

    public function __construct(
        private readonly ?int $id,
        private string $title,
        private string $description,
        private string $image,
        private ?DateTime $end_date,
        private bool $is_active
    ) {
    }

    public static function create(string $title, string $description, string $image, ?DateTime $end_date = null): self
    {
        return new self(null, $title, $description, $image,$end_date, true );
    }

    public function modify(string $title, string $description, string $image,?DateTime $end_date): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->end_date = $end_date;
    }


    public function id(): ?int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function endDate(): ?DateTime
    {
        return $this->end_date;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }
}