
<!-- Conexión a la base de datos -->

<?php

    $host = "localhost";                  // El host donde esta la base de datos soy yo mismo en este caso
    $database = "contacts_app_reto1";     // Base de datos sobre la que vamos a trabajar
    $user = "root";                       // El usuario con el que nos conectamos es root
    $password = "";                       // La contraseña es una cadena vacía

    try{
        $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        
    }catch(PDOException){
        die("PDO Connection Error: " . $e->getMessage());
    }

?>