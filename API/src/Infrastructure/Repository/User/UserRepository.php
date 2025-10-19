<?php
declare(strict_types=1);

namespace Src\Infrastructure\Repository\User;

use DateTime;
use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\User\User;

final readonly class UserRepository extends PDOManager implements UserRepositoryInterface
{
    // Buscar usuario por ID //
    public function find(int $id): ?User
    {
        $query  = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $result = $this->execute($query, ["id" => $id]);
        return $this->primitiveToUser($result[0] ?? null);
    }

    // Buscar usuario por email //
    public function findByEmail(string $email): ?User
    {
        $query  = "SELECT * FROM users WHERE LOWER(email) = :email LIMIT 1";
        $params = ["email" => strtolower(trim($email))];
        $result = $this->execute($query, $params);
        return $this->primitiveToUser($result[0] ?? null);
    }

    // Buscar usuario por DNI //
    public function findByDni(string $dni): ?User
    {
        $sql   = "SELECT * FROM users WHERE dni = :dni LIMIT 1";
        $rows  = $this->execute($sql, ['dni' => trim($dni)]);
        return $this->primitiveToUser($rows[0] ?? null);
    }

    public function findByToken(string $token): ?User
    {
        $query = "SELECT * FROM users 
                  WHERE token = :token
                    AND :now <= token_auth_date
                    AND is_active = 1
                    AND (is_blocked = 0 OR is_blocked IS NULL)
                  LIMIT 1";
        $params  = [
            "token" => $token,
            "now"   => date("Y-m-d H:i:s"),
        ];
        $result = $this->execute($query, $params);
        return $this->primitiveToUser($result[0] ?? null);
    }

    // Insertar nuevo usuario //
    public function insert(User $user): void
    {
        $query = <<<SQL
            INSERT INTO users (
                name, apellido, dni, email, password, token, role, is_active, is_blocked, token_auth_date, failed_attempts
            )
            VALUES (
                :name, :apellido, :dni, :email, :password, :token, :role, :is_active, :is_blocked, :token_auth_date, :failed_attempts
            )
        SQL;

        $parameters = [
            "name" => $user->name(),
            "apellido"=> $user->apellido(),
            "dni" => $user->dni(),
            "email"=> $user->email(),
            "password"=> $user->password(),
            "token"=> $user->token(),
            "role"=> $user->role(),
            "is_active" => $user->is_active() ? 1 : 0,
            "is_blocked"=> $user->is_blocked() ? 1 : 0,
            "token_auth_date" => $user->token_auth_date()?->format("Y-m-d H:i:s"),
            "failed_attempts" => 0,
        ];

        $this->execute($query, $parameters);
    }
    public function create(array $fields): User
    {
        // Asegurar role //
        $role = $fields['role'] ?? 'visitor';

        $sql = "INSERT INTO users (name, apellido, dni, email, password, role, is_active, is_blocked)
                VALUES (:name, :apellido, :dni, :email, :password, :role, :is_active, :is_blocked)";

        $this->execute($sql, [
            'name' => $fields['name'],
            'apellido'=> $fields['apellido'],
            'dni'=> $fields['dni'],
            'email'=> $fields['email'],
            'password'=> $fields['password'],
            'role'=> $role,
            'is_active'=> (int)($fields['is_active'] ?? 0),
            'is_blocked'=> (int)($fields['is_blocked'] ?? 0),
        ]);
        
        $user = $this->findByEmail($fields['email']);
        if (!$user) {
            throw new \RuntimeException('No se pudo recuperar el usuario recién creado.');
        }
        return $user;
    }
    public function update(User $user): void
    {
        $query = <<<SQL
            UPDATE users
            SET name = :name,
                apellido = :apellido,
                dni = :dni,
                email = :email,
                password = :password,
                token = :token,
                token_auth_date = :token_auth_date,
                role = :role,
                is_active = :is_active,
                is_blocked = :is_blocked
            WHERE id = :id
        SQL;

        $parameters = [
            "name"=> $user->name(),
            "apellido"=> $user->apellido(),
            "dni"=> $user->dni(),
            "email"=> $user->email(),
            "password"=> $user->password(),
            "token"=> $user->token(),
            "token_auth_date" => $user->token_auth_date()?->format("Y-m-d H:i:s"),
            "role"=> $user->role(),
            "is_active" => $user->is_active() ? 1 : 0,
            "is_blocked"=> $user->is_blocked() ? 1 : 0,
            "id"=> $user->id(),
        ];

        $this->execute($query, $parameters);
    }

    // Actualizar token, renovar sesion//
    public function updateToken(User $user): void
    {
        $query = "UPDATE users 
                  SET token = :token, token_auth_date = :token_auth_date 
                  WHERE id = :id";
        $parameters = [
            "token"=> $user->token(),
            "token_auth_date" => $user->token_auth_date()?->format("Y-m-d H:i:s"),
            "id"=> $user->id(),
        ];
        $this->execute($query, $parameters);
    }

    // Eliminar usuario //
    public function delete(int $id): void
    {
        $this->execute("DELETE FROM users WHERE id = :id", ["id" => $id]);
    }

    // Listados //
    public function findAllActive(): array
    {
        $results = $this->execute(
            "SELECT * FROM users 
             WHERE is_active = 1 
               AND (is_blocked = 0 OR is_blocked IS NULL)",
            []
        );
        return array_map(fn($row) => $this->primitiveToUser($row), $results);
    }

    public function findAllPending(): array
    {
        $results = $this->execute(
            "SELECT * FROM users 
             WHERE is_active = 0",
            []
        );
        return array_map(fn($row) => $this->primitiveToUser($row), $results);
    }
    public function findAllBlocked(): array
    {
        $results = $this->execute(
            "SELECT * FROM users 
             WHERE is_blocked = 1",
            []
        );
        return array_map(fn($row) => $this->primitiveToUser($row), $results);
    }
    // Aprobacion / Activacion //
    public function activateUser(int $userId): void
    {
        $user = $this->find($userId);
        if (!$user) return;

        $user->activate();

        $this->execute(
            "UPDATE users 
             SET is_active = 1,
                 is_blocked = 0,
                 failed_attempts = 0,
                 token = :token,
                 token_auth_date = :token_auth_date
             WHERE id = :id",
            [
                "id" => $userId,
                "token"=> $user->token(),
                "token_auth_date"=> $user->token_auth_date()?->format('Y-m-d H:i:s')
            ]
        );
    }
    public function authorizeAdmin(int $userId): void
    {
        $user = $this->find($userId);
        if (!$user) return;

        $user->promoteToAdmin();

        $this->execute(
            "UPDATE users 
             SET role = 'admin',
                 is_active = 1,
                 is_blocked = 0,
                 failed_attempts = 0,
                 password = :password,
                 token = :token,
                 token_auth_date = :token_auth_date
             WHERE id = :id",
            [
                "id" => $userId,
                "password"=> $user->password(),
                "token"=> $user->token(),
                "token_auth_date"=> $user->token_auth_date()?->format('Y-m-d H:i:s')
            ]
        );
    }
    public function updateRole(int $userId, string $role): void
    {  
        $this->execute(
            "UPDATE users SET role = :role WHERE id = :id",
            [
                "id"   => $userId,
                "role" => $role
            ]
        );
    }
    // Seguridad (login)//
    public function incrementFailedAttempts(int $userId): void
    {
        $this->execute(
            "UPDATE users SET failed_attempts = failed_attempts + 1 WHERE id = :id",
            ["id" => $userId]
        );
    }
    public function resetFailedAttempts(int $userId): void
    {
        $this->execute(
            "UPDATE users SET failed_attempts = 0 WHERE id = :id",
            ["id" => $userId]
        );
    }

    public function getFailedAttempts(int $userId): int
    {
        $result = $this->execute(
            "SELECT failed_attempts FROM users WHERE id = :id",
            ["id" => $userId]
        );
        return !empty($result) ? (int)$result[0]['failed_attempts'] : 0;
    }

    public function blockUser(int $userId): void
    {
        $this->execute(
            "UPDATE users SET is_blocked = 1 WHERE id = :id",
            ["id" => $userId]
        );
    }
    private function primitiveToUser(?array $primitive): ?User
    {
        if (!$primitive) return null;

        return new User(
            (int)$primitive["id"],
            (string)$primitive["name"],
            (string)($primitive["apellido"] ?? ''),
            (string)($primitive["dni"] ?? ''),
            (string)$primitive["email"],
            (string)$primitive["password"],
            $primitive["token"],
            !empty($primitive["token_auth_date"])
                ? new DateTime($primitive["token_auth_date"])
                : null,
            $primitive["role"] ?? "visitor",
            (bool)($primitive["is_active"] ?? 0),
            (bool)($primitive["is_blocked"] ?? 0)
        );
    }
}
