<?php 


final readonly class UserRoutes {

    public static function getRoutes(): array {
        return [
            // lOGIN //
            [
                "name" => "user_login",
                "url" => "/users/login",
                "controller" => "User/UserLoginController.php",
                "method" => "POST",
                "roles_allowed" => ["super_adm", "adm"] 
            ],

            // Crear usuario → Solo super_adm puede crear admins//
            [
                "name" => "user_create",
                "url" => "/users",
                "controller" => "User/UserPostController.php",
                "method" => "POST",
                "roles_allowed" => ["super_adm"] // solo super_adm puede crear admins
            ],

            // Actualizar usuario → Solo super_adm y adm pueden actualizar//
            [
                "name" => "user_update",
                "url" => "/users/{id}",
                "controller" => "User/UserPutController.php",
                "method" => "PUT",
                "roles_allowed" => ["super_adm", "adm"]
            ],

            // Borrar usuario → Solo super_adm//
            [
                "name" => "user_delete",
                "url" => "/users/{id}",
                "controller" => "User/UserDeleteController.php",
                "method" => "DELETE",
                "roles_allowed" => ["super_adm"]
            ],

            // Obtener lista de usuarios → Solo super_adm y adm//
            [
                "name" => "user_search",
                "url" => "/users",
                "controller" => "User/UsersSearcherController.php",
                "method" => "GET",
                "roles_allowed" => ["super_adm", "adm"]
            ]
        ];
    }
}
