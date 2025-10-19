<?php

declare(strict_types=1);

namespace Src\Entity\User\Exception;

use RuntimeException;

final class UserPendingApprovalException extends RuntimeException
{
    public function __construct(string $message = "El usuario tiene la solicitud pendiente de aprobación por un administrador/a.")
    {
        parent::__construct($message);
    }
}
