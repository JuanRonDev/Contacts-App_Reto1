
<!-- No sé si este archivo está compuesto exactamente cómo se pedía, pero dado que anteriormente se pide que en el home se muestren todas las direcciones, no veía la necesidad de que en este archivo se volviesen a mostrar, por eso lo he convertido en un botón que se encargue de eliminar directamente la dirección. -->
 
<?php

    require "database.php";

    session_start();

    //Si intentas añadir contactos, pero no estas logueado, te manda directamente al login
    if (!isset($_SESSION["user"])){
        header("Location: login.php");
        return;
    }

    $id = $_GET["id"];

    $statement = $conn->prepare("SELECT * FROM adresses WHERE id = :id LIMIT 1");
    $statement->execute([":id" => $id]);

    if ($statement->rowCount() == 0){
        http_response_code(404);
        echo("HTTP 404 NOT FOUND");
        return;
    }

    //$ad = $statement->fetch(PDO::FETCH_ASSOC);

    // Sentencia SQL para eliminar la dirección
    $conn->prepare("DELETE FROM adresses WHERE id = :id")->execute([":id" => $id]);

    $_SESSION["flash"] = ["message" => "Adress deleted."];

    header("Location: home.php");

?>