<?php 

namespace Src\Entity\User;

use DateTime;

final class User {

    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $email,
        private string $password,
        private ?string $token,
        private ?DateTime $token_auth_date,
        private string $role,      // Agrego super_adm, adm, visitor
        private bool $is_Active  // Agrego true o false

    ) {
    }
//Agrego los prametros que faltan para poder crear objetos User//
    public static function create(
    string $name,
    string $email,
    string $password,
    string $role,
    bool $is_Active = true,
    ?string $token = null,
    ?DateTime $token_auth_date = null

): self {
    return new self(
        null,
        $name,
        $email,
        password_hash($password, PASSWORD_BCRYPT),
        $token,
        $token_auth_date,
        $role,
        $is_Active
    );
}
//Agrego funcion que permite actualizar datos de usuario existente//
public function modify(
    string $name,
    string $email,
    ?string $password = null,
    string $role,
    bool $is_Active
): void {
    $this->name = $name;
    $this->email = $email;
    if ($password !== null) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
    $this->role = $role;
    $this->is_Active = $is_Active;
}

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function token_auth_date(): ?DateTime
    {
        return $this->token_auth_date;
    }

    public function generateToken(): void
    {
        $this->token = md5($this->email.$this->id.rand(1000, 9999).date("YmdHis"));
        $this->token_auth_date = new DateTime("+1 hours");
    }
    //Agrego role y isActive//
    public function role(): string
    {
        return $this->role;
    }
    public function is_Active(): bool
    {
        return $this->is_Active;
    }
}