<?php

namespace Src\Service\Book;

use Src\Infrastructure\Repository\Book\BookRepository;
use Throwable;

final readonly class BooksUpdaterService
{
    private BookRepository $repository;

    public function __construct() {
        $this->repository = new BookRepository();
    }


 public function updateBooks(array $books): array
    {
        if (!$this->validateBooks($books)) {
            return [
                'status' => 'error',
                'message' => 'Formato de libros inválido o faltan campos obligatorios'
            ];
        }

        try {
            $this->repository->beginTransaction();

            $this->repository->clearAllBooks();

            $inserted = $this->repository->insertBooks($books);

            $this->repository->commit();

            return [
                'status' => 'ok',
                'message' => 'Libros actualizados correctamente',
                'insertados' => $inserted
            ];
        } catch (Throwable $e) {
            $this->repository->rollback();
            return [
                'status' => 'error',
                'message' => 'Error al actualizar libros: ' . $e->getMessage()
            ];
        }
    }

    private function validateBooks(array $books): bool
    {
        foreach ($books as $book) {
            if (empty($book['titulo']) || empty($book['autor'])) {
                return false;
            }
        }
        return true;
    }
}