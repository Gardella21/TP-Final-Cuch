<?php
declare(strict_types=1);

namespace Src\Entity\User\Exception;

use DomainException;

final class UserAlreadyExistsException extends DomainException
{
    public function __construct(
        string $message = 'El email ingresado ya se encuentra en uso.',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
