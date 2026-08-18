<?php

declare(strict_types=1);

namespace Src\Infrastructure\Repository\Member;

use Src\Infrastructure\PDO\PDOManager;
use Src\Entity\Member\Member;
use Src\Entity\Member\Exception\MemberNotFoundException;

final readonly class MemberRepository extends PDOManager implements MemberRepositoryInterface
{
    public function find(int $id): ?Member
    {
        $query = <<<SQL
            SELECT * FROM members WHERE id = :id
        SQL;

        $result = $this->execute($query, ['id' => $id]);

        if (empty($result)) {
            throw new MemberNotFoundException($id);
        }

        return $this->primitiveToMember($result[0]);
    }

    public function findByDni(string $dni): ?Member
    {
        $query = <<<SQL
            SELECT * FROM members WHERE dni = :dni
        SQL;

        $result = $this->execute($query, ['dni' => $dni]);

        if (empty($result)) {
            return null;
        }

        return $this->primitiveToMember($result[0]);
    }

    public function search(): array
    {
        $query = <<<SQL
            SELECT * FROM members ORDER BY id DESC
        SQL;

        $results = $this->execute($query);

        if (!is_array($results) || !$results) return [];

        return array_map([$this, 'primitiveToMember'], $results);
    }

    public function insert(Member $member): void
    {
        $query = <<<SQL
            INSERT INTO members (name, surname, dni, email, phone, address, birth_date)
            VALUES (:name, :surname, :dni, :email, :phone, :address, :birth_date)
        SQL;

        $this->execute($query, [
            'name'       => $member->name(),
            'surname'    => $member->surname(),
            'dni'        => $member->dni(),
            'email'      => $member->email(),
            'phone'      => $member->phone(),
            'address'    => $member->address(),
            'birth_date' => $member->birthDate(),
        ]);
    }

    public function updateEstado(int $id, string $estado): void
    {
        $query = <<<SQL
            UPDATE members SET estado = :estado WHERE id = :id
        SQL;

        $this->execute($query, ['estado' => $estado, 'id' => $id]);
    }

    public function delete(int $id): void
    {
        $query = <<<SQL
            DELETE FROM members WHERE id = :id
        SQL;

        $this->execute($query, ['id' => $id]);
    }

    private function primitiveToMember(?array $p): ?Member
    {
        if ($p === null) return null;

        return new Member(
            (int)$p['id'],
            (string)$p['name'],
            (string)$p['surname'],
            (string)$p['dni'],
            (string)$p['email'],
            (string)$p['phone'],
            (string)$p['address'],
            (string)$p['birth_date'],
            (string)$p['estado'],
            $p['fecha_solicitud'] ?? null
        );
    }
}
