<?php

namespace Src\Entity\Member\Exception;

final class MemberAlreadyExistsException extends \RuntimeException
{
    public function __construct(string $dni)
    {
        parent::__construct("Ya existe una solicitud registrada con el DNI $dni.", 409);
    }
}
