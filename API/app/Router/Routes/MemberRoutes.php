<?php 

final readonly class MemberRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "member_post",
        "url" => "/members",
        "controller" => "Member/MemberPostController.php",
        "method" => "POST"
      ],
      [
        "name" => "members_get",
        "url" => "/members",
        "controller" => "Member/MembersGetController.php",
        "method" => "GET"
      ],
      [
        "name" => "member_put",
        "url" => "/members/{id}",
        "controller" => "Member/MemberPutController.php",
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
