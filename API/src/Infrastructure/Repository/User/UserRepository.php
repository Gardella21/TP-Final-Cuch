<?php 

declare(strict_types=1);

namespace Src\Infrastructure\Repository\User;

use DateTime;
use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\User\User;

final readonly class UserRepository extends PDOManager implements UserRepositoryInterface
{
    public function find(int $id): ?User
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $result = $this->execute($query, ["id" => $id]);

        return $this->primitiveToUser($result[0] ?? null);
    }

    public function findByEmail(string $email): ?User
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $result = $this->execute($query, ["email" => $email]);

        return $this->primitiveToUser($result[0] ?? null);
    }

    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user->password())) {
            return $user;
        }

        return null;
    }

    public function findByToken(string $token): ?User
    {
        $query = "SELECT * FROM users WHERE token = :token AND :date <= token_auth_date";
        $parameters = [
            "token"=> $token,
            "date"=> date("Y-m-d H:i:s"),
        ];

        $result = $this->execute($query, $parameters);
        return $this->primitiveToUser($result[0] ?? null);
    }

    public function insert(User $user): void
    {
        $query = <<<SQL
            INSERT INTO users (name, email, password, token, role, is_active)
            VALUES (:name, :email, :password, :token, :role, :is_active)
        SQL;

        $parameters = [
            "name"=> $user->name(),
            "email"=> $user->email(),
            "password"=> $user->password(),
            "token"=> $user->token(),
            "role"=> $user->role(),
            "is_active"=> $user->is_active() ? 1 : 0,
        ];

        $this->execute($query, $parameters);
    }

    public function update(User $user): void
    {
        $query = <<<SQL
            UPDATE users
            SET name = :name,
                email = :email,
                password = :password,
                token = :token,
                token_auth_date = :token_auth_date,
                role = :role,
                is_active = :is_active
            WHERE id = :id
        SQL;

        $parameters = [
            "name"=> $user->name(),
            "email"=> $user->email(),
            "password"=> $user->password(),
            "token"=> $user->token(),
            "token_auth_date"=> $user->token_auth_date()?->format("Y-m-d H:i:s"),
            "role" => $user->role(),
            "is_active"=> $user->is_active() ? 1 : 0,
            "id"=> $user->id(),
        ];

        $this->execute($query, $parameters);
    }

    public function updateToken(User $user): void
    {
        $query = "UPDATE users SET token = :token, token_auth_date = :token_auth_date WHERE id = :id";
        $parameters = [
            "token"=> $user->token(),
            "token_auth_date"=> $user->token_auth_date()?->format("Y-m-d H:i:s"),
            "id"=> $user->id(),
        ];
        $this->execute($query, $parameters);
    }

    public function delete(int $id): void
    {
        $this->execute("DELETE FROM users WHERE id = :id", ["id" => $id]);
    }

    public function findAllActive(): array
    {
        $results = $this->execute("SELECT * FROM users WHERE is_active = 1", []);
        return array_map(fn($row) => $this->primitiveToUser($row), $results);
    }

    public function findAllPending(): array
    {
        $results = $this->execute("SELECT * FROM users WHERE is_active = 0", []);
        return array_map(fn($row) => $this->primitiveToUser($row), $results);
    }

    public function activateUser(int $userId): void
    {
        $this->execute("UPDATE users SET is_active = 1 WHERE id = :id", ["id" => $userId]);
    }

    public function authorizeAdmin(int $userId): void
    {
        $this->execute("UPDATE users SET role = 'admin' WHERE id = :id", ["id" => $userId]);
    }

    private function primitiveToUser(?array $primitive): ?User
    {
        if (!$primitive) {
            return null;
        }

        return new User(
            (int)$primitive["id"],
            (string)$primitive["name"],
            (string)$primitive["email"],
            (string)$primitive["password"],
            $primitive["token"],
            !empty($primitive["token_auth_date"]) ? new DateTime($primitive["token_auth_date"]) : null,
            role: $primitive["role"] ?? "visitor",
            is_active: (bool)($primitive["is_active"] ?? 0)
        );
    }
}
