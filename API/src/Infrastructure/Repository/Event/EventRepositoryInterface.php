<?php 

declare(strict_types = 1);

namespace Src\Infrastructure\Repository\Event;  


interface EventRepositoryInterface {
    
    public function search(): array;

}