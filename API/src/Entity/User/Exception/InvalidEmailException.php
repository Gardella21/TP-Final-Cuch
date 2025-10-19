<?php 

namespace Src\Entity\User\Exception;

use Exception;

final class InvalidEmailException extends Exception {
    public function __construct(string $email) {
        parent::__construct("Email inválido: {$email}");
    }
}
