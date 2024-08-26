<?php

    require "database.php";

    session_start();

    $id = $_GET["id"];

    // Seleccionamos los datos de la dirección que estamos editando
    $statement = $conn->prepare("SELECT * FROM adresses WHERE id = :id LIMIT 1");
    $statement->execute([":id" => $id]);

    if ($statement->rowCount() == 0){
        http_response_code(404);
        echo("HTTP 404 NOT FOUND");
        return;
    }

    // Recogemos los datos y los almacenamos en una variable
    $adress = $statement->fetch(PDO::FETCH_ASSOC);

    $error = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        // Comprobamos que se haya rellenado el campo, aunque el navegador lo haga automáticamente en ocasiones.
        if(empty($_POST["adress"])){
            $error = "Please fill the field.";

        }else{
            // Seguimos el mismo proceso
            $adress = $_POST["adress"];

            // Se actualiza el valor de adress con la nueva entrada 
            $statement = $conn->prepare("UPDATE adresses SET adress = :adress WHERE id = :id");

            $statement->bindParam(":id", $id);
            $statement->bindParam(":adress", $adress);
            $statement->execute();

            // Mensaje de éxito
            $_SESSION["flash"] = ["message" => "Adress updated successfully."];

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
                    <div class="card-header">Edit Adress</div>
                    <div class="card-body">

                        <?php if($error): ?>
                            <p class="text-danger">
                                <?= $error ?>
                        <?php endif ?>

                        <form method="POST" action="editAdress.php?id=<?= $adress["id"] ?>">  

                            <div class="mb-3 row">
                                <label for="adress" class="col-md-4 col-form-label text-md-end">Adress:</label>
                                <div class="col-md-6">
                                    <input id="adress" type="text" class="form-control" name="adress" value="<?= $adress["adress"] ?>" required autofocus>
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