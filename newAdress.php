
<?php

    require "database.php";

    session_start();

    //Si intentas añadir contactos, pero no estas logueado, te manda directamente al login
    if (!isset($_SESSION["user"])){
        header("Location: login.php");
        return;
    }

    // La mayoría de comprobaciones de seguridad se repiten aquí.

    $id = $_GET["id"];

    $statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
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

    $error = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        // Comprobamos que se haya rellenado el campo, aunque el navegador lo haga automáticamente en ocasiones.
        if(empty($_POST["adress"])){
            $error = "Please fill the field.";

        }else{

            // Le damos el valor del id del contacto a una variable user_id, que será con la que rellenamos el campo de la base de datos
            $user_id = $id;
            // Se recoge el valor introducido por el usuario y se lo asigna a la variable ad para introducirla en la base de datos
            $ad = $_POST["adress"];

            // Sentencia SQL
            $statement = $conn->prepare("INSERT INTO adresses (user_id, adress) VALUES (:user_id, :ad)");

            $statement->bindParam(":user_id", $user_id);
            $statement->bindParam(":ad", $ad);
            $statement->execute();

            // Mensaje confirmando que se ha añadido correctamente la nueva dirección al contacto
            $_SESSION["flash"] = ["message" => "Adress added for {$contact['name']}"];

            header("Location: home.php");
            return;
        }
    }

?>


<?php require "partials/header.php" ?>

    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New adress</div>
                    <div class="card-body">

                        <?php if($error): ?>
                            <p class="text-danger">
                                <?= $error ?>
                        <?php endif ?>
                        
                        <!-- Se le pasa el id del contacto para poder recogerla  -->
                        <form method="POST" action="newAdress.php?id=<?= $contact["id"] ?>">  

                            <div class="mb-3 row">
                                <label for="adress" class="col-md-4 col-form-label text-md-end">Adress:</label>
                                <div class="col-md-6">
                                    <input id="adress" type="" class="form-control" name="adress" required autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require "partials/footer.php" ?>