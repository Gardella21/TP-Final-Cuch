<?php 

declare(strict_types = 1);

namespace Src\Infrastructure\Repository\User;

use DateTime;
use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\User\User;

final readonly class UserRepository extends PDOManager implements UserRepositoryInterface {

    public function find(int $id): ?User
{
    $query = "SELECT * FROM users WHERE id = :id";
    $parameters = ["id" => $id];
    $result = $this->execute($query, $parameters);

    return $this->primitiveToUser($result[0] ?? null);
}

public function authorizeAdministrative(int $userId): void
{
    $query = "UPDATE users SET role = 'adm' WHERE id = :id";
    $parameters = ["id" => $userId];
    $this->execute($query, $parameters);
}


    public function findByEmail(string $email): ?User 
    {
        $query = "SELECT * FROM users WHERE email = :email";

        $parameters = [
            "email" => $email,
        ];

        $result = $this->execute($query, $parameters);
        
        $user = $this->primitiveToUser($result[0] ?? null); 

        if (empty($user)) {
            return null;
        }

        return $user;
    }

    public function findByEmailAndPassword(string $email, string $password): ?User 
    {
        $user = $this->findByEmail($email);

        if (empty($user)) {
            return null;
        }

        if (password_verify($password, $user->password())) {
            return $user;
        }
        
        return null;
    }

    public function findByToken(string $token): ?User 
    {
        $query = "SELECT * FROM users WHERE token = :token AND :date <= token_auth_date";

        $parameters = [
            "token" => $token,
            "date" => date("Y-m-d H:i:s"),
        ];

        $result = $this->execute($query, $parameters);
        
        return $this->primitiveToUser($result[0] ?? null);
    }

    public function insert(User $user): void
    {
        $query = <<<INSERT_QUERY
                    INSERT INTO
                        users
                    (name, email, password, token, role, is_Active)
                        VALUES
                    (:name, :email, :password, :token, :role, :is_Active)
                INSERT_QUERY;
            
        $parameters = [
            "name" => $user->name(),
            "email" => $user->email(),
            "password" => $user->password(),
            "token" => "",
            /*Agerego nuevos campos sol*/
           "role" => $user->role(),                             
           "is_Active" => $user->is_Active() ? 1 : 0 
        ];
         $this->execute($query, $parameters);
    }

    public function update(User $user): void
    {
        $query = <<<UPDATE_QUERY
                        UPDATE
                            users
                        SET
                            email = :email,
                            password = :password,
                            token = :token,
                            token_auth_date = :token_auth_date,
                            role = :role,
                            is_Active = :is_Active
                        WHERE
                            id = :id
                    UPDATE_QUERY;

        $parameters = [
            "email" => $user->email(),
            "password" => $user->password(),
            "token" => $user->token(),
            "tokenAuthDate" => $user->token_auth_date()->format("Y-m-d H:i:s"),
            "role" => $user->role(),                  // nuevo parametro//
            "is_Active" => $user->is_Active() ? 1 : 0, // nuevo parametro//
            "id" => $user->id()

        ];

        $this->execute($query, $parameters);
    }
    public function delete(int $id): void
{
    $query = "DELETE FROM users WHERE id = :id";
    $parameters = ["id" => $id];
    $this->execute($query, $parameters);
}
    public function search(): array
{
    $query = "SELECT * FROM users";
    $results = $this->execute($query, []);

    $users = [];
    foreach ($results as $row) {
        $users[] = $this->primitiveToUser($row);
    }

    return $users;
}


    private function primitiveToUser(?array $primitive): ?User
    {
        if ($primitive === null) {
            return null;
        }

        return new User(
            $primitive["id"],
            $primitive["name"],
            $primitive["email"],
            $primitive["password"],
            $primitive["token"],
            new DateTime($primitive["token_auth_date"]),
            role: $primitive["role"],             // nuevo parametro//
            is_Active: $primitive["is_Active"] == 1   // nuevo //
        );
    }
}