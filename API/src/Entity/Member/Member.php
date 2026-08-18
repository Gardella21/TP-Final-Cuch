<?php

namespace Src\Entity\Member;

final class Member implements \JsonSerializable
{
    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $surname,
        private string $dni,
        private string $email,
        private string $phone,
        private string $address,
        private string $birth_date,
        private string $estado = 'pendiente',
        private ?string $fecha_solicitud = null
    ) {}

    public static function create(
        string $name,
        string $surname,
        string $dni,
        string $email,
        string $phone,
        string $address,
        string $birthDate
    ): self {
        return new self(null, $name, $surname, $dni, $email, $phone, $address, $birthDate);
    }

    public function id(): ?int              { return $this->id; }
    public function name(): string          { return $this->name; }
    public function surname(): string       { return $this->surname; }
    public function dni(): string           { return $this->dni; }
    public function email(): string         { return $this->email; }
    public function phone(): string         { return $this->phone; }
    public function address(): string       { return $this->address; }
    public function birthDate(): string     { return $this->birth_date; }
    public function estado(): string        { return $this->estado; }
    public function fechaSolicitud(): ?string { return $this->fecha_solicitud; }

    public function jsonSerialize(): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'surname'         => $this->surname,
            'dni'             => $this->dni,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'address'         => $this->address,
            'birth_date'      => $this->birth_date,
            'estado'          => $this->estado,
            'fecha_solicitud' => $this->fecha_solicitud,
        ];
    }
}
