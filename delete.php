<?php

    require "database.php";

    session_start();

    //Si intentas añadir contactos, pero no estas logueado, te manda directamente al login
    if (!isset($_SESSION["user"])){
        header("Location: login.php");
        return;
    }

    $id = $_GET["id"];

    $statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
    //$statement->bindParam(":id", $id);
    $statement->execute([":id" => $id]);

    if ($statement->rowCount() == 0){
        http_response_code(404);
        echo("HTTP 404 NOT FOUND");
        return;
    }

    $contact = $statement->fetch(PDO::FETCH_ASSOC);

    if ($contact["user_id"] !== $_SESSION["user"]["id"]){
        http_response_code(403);
        echo("HTTP 403 UNAUTHORIZED");
        return;
    }

    $conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

    $_SESSION["flash"] = ["message" => "Contact {$_POST['name']} deleted."];

    header("Location: home.php");

?>