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
        "name" => "books_update",
        "url" => "/books/update",
        "controller" => "Book/BooksUpdateController.php",
        "method" => "POST"
      ],
      [
        "name" => "books_get",
        "url" => "/books",
        "controller" => "Book/BooksGetController.php",
        "method" => "POST"
      ],
      [
        "name" => "book_reservation_create",
        "url" => "/book-reservations",
        "controller" => "BookReservation/BookReservationPostController.php",
        "method" => "POST"
      ],
      [
        "name" => "book_reservations_get",
        "url" => "/book-reservations",
        "controller" => "BookReservation/BookReservationsGetController.php",
        "method" => "GET"
      ],
      [
        "name" => "book_reservation_update",
        "url" => "/book-reservations/{id}",
        "controller" => "BookReservation/BookReservationPutController.php",
        "method" => "PUT",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ]
    ];
  }
}

      
    
 