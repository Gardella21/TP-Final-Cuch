<?php
declare(strict_types=1);

namespace Src\Entity\User\Exception;

final class UserNotFoundException extends \RuntimeException
{
    public function __construct(int|string $idOrEmail)
    {
        $msg = is_int($idOrEmail)
            ? "Usuario no encontrado (id: {$idOrEmail})."
            : "Usuario no encontrado (email: {$idOrEmail}).";

        parent::__construct($msg);
    }
}
