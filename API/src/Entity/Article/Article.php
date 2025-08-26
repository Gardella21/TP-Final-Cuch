<?php 

namespace Src\Entity\Article;
use DateTime;

final class Article {

    public function __construct(
        private readonly ?int $id,
        private string $title,
        private string $image,
        private string $content,
        private string $date
    ) {
    }

    public static function create(string $title, string $image, string $content, string $date): self
    {
        return new self(null, $title, $image, $content, $date);
    }

    public function modify(string $title, string $image, string $content, string $date): void
    {
        $this->title = $title;
        $this->image = $image;
        $this->content = $content;
        $this->date = $date;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title();
    }

    public function image(): string
    {
        return $this->image;
    }

    public function content(): string
    {
        return $this->content;
    }
    public function date(): DateTime
    {
        return new DateTime($this->date);
    }
}