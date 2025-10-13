<?php 

final readonly class BookRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "book_get",
        "url" => "/books",
        "controller" => "Book/BookGetController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "id" ,
            "type" => "int"
          ],
        ]
      ],
      [
        "name" => "books_get",
        "url" => "/books",
        "controller" => "Book/BooksGetController.php",
        "method" => "POST"
      ], 

    ];

  }

}

      
    
 