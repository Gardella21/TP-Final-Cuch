<?php 

final readonly class EventRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "events_get",
        "url" => "/events",
        "controller" => "Event/EventsGetController.php",
        "method" => "GET"
      ]
    ];
  }
}
