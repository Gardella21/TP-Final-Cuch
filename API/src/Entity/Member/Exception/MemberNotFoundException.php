<?php

namespace Src\Entity\Member\Exception;

final class MemberNotFoundException extends \RuntimeException
{
    public function __construct(int $id)
    {
        parent::__construct("Socio con id $id no encontrado.", 404);
    }
}
