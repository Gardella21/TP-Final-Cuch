<?php

namespace Src\Entity\BookReservation;

final class BookReservation implements \JsonSerializable
{
    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $surname,
        private string $email,
        private int $phone,
        private int $id_book,
        private ?string $book_titulo = null,
        private ?string $book_codigo = null,
        private string $estado = 'pendiente',
        private ?string $fecha_reserva = null
    ) {}

    public static function create(
        string $name,
        string $surname,
        string $email,
        int $phone,
        int $id_book
    ): self {
        return new self(null, $name, $surname, $email, $phone, $id_book);
    }

    public function id(): ?int          { return $this->id; }
    public function name(): string      { return $this->name; }
    public function surname(): string   { return $this->surname; }
    public function email(): string     { return $this->email; }
    public function phone(): int        { return $this->phone; }
    public function idBook(): int       { return $this->id_book; }
    public function bookTitulo(): ?string { return $this->book_titulo; }
    public function bookCodigo(): ?string { return $this->book_codigo; }
    public function estado(): string    { return $this->estado; }
    public function fechaReserva(): ?string { return $this->fecha_reserva; }

    public function jsonSerialize(): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'surname'      => $this->surname,
            'email'        => $this->email,
            'phone'        => $this->phone,
            'id_book'      => $this->id_book,
            'book_titulo'  => $this->book_titulo,
            'book_codigo'  => $this->book_codigo,
            'estado'       => $this->estado,
            'fecha_reserva'=> $this->fecha_reserva,
        ];
    }
}
