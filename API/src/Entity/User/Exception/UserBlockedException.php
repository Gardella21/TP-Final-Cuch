<?php
declare(strict_types=1);

namespace Src\Entity\User\Exception;

use DomainException;

final class UserBlockedException extends DomainException
{
    public function __construct(
        string $message = 'Usuario bloqueado por varios intentos fallidos.',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
