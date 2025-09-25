<?php 

final readonly class EventRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "events_get",
        "url" => "/events",
        "controller" => "Event/EventsGetController.php",
        "method" => "GET"
      ],
      [
        "name" => "event_post",
        "url" => "/events",
        "controller" => "Event/EventPostController.php",
        "method" => "POST"
      ]
    ];
  }
}
