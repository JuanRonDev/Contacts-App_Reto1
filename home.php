
<?php

    require "database.php";

    session_start();

    if (!isset($_SESSION["user"])){
        header("Location: login.php");
        return;
    }

    $contacts = $conn->query("SELECT * FROM contacts WHERE user_id = {$_SESSION['user']['id']}");

?>

<?php require "partials/header.php" ?>

    <div class="contaienr pt-4 p-3">
        <div class="row">

            <!-- Comprobamos si es 0 para poner una redirección inmediata hacia el Add -->
            <?php if($contacts->rowCount() == 0): ?>

                <div class="col-md-4 mx-auto">
                    <div class="card card-body text-center">
                        <p>No Contacts saved yet</p>
                        <a href="add.php">Add one!</a>
                    </div>
                </div>

            <?php endif ?>

            <!-- Bucle para imprimir por pantalla la información de cada contacto de la lista $contacts -->
            <?php foreach ($contacts as $contact): ?>

                <?php $adresses = $conn->query("SELECT * FROM adresses WHERE user_id = {$contact['id']}"); ?>

                <div class="col-md-4 mb-3">
                    <div class="card text-center">

                        <div class="card-body">
                            <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
                            <p class="m-2"><?= $contact["phone_number"] ?></p>
                            <a href="./edit.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2" style="display: inline-block; margin-left: 10px;">Edit Contact</a>
                            <a href="./delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2" style="display: inline-block; margin-left: 10px;">Delete Contact</a>
                            <a href="./newAdress.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2" style="display: inline-block; margin-left: 10px;">Add adresses</a>
                        </div>

                        <!-- Comprobamos que haya una o más direcciones -->
                        <!-- Lo he compuesto de esta manera ya que así he entendido el enunciado, podemos ver todas las direcciones de un contacto y tenemos la opción de editar y eliminar las mismas. -->
                        <!-- Podría estar más bonito la presentación de las direcciones, pero por ahora lo dejaré como esta. -->
                        <?php

                            if ($adresses->rowCount() > 0) {
                                echo "<h5 style='margin-top: 20px;'>Addresses</h5>";
                                
                                // En el caso de que haya direcciones, imprimimos por pantalla cada una de ellas, junto con sus botones correspondientes para editar o borrar. Se le pasa en los dos casos el id de la dirección.
                                foreach ($adresses as $adress) {
                                    echo "<p style='margin-top: 10px;'>{$adress['adress']}

                                        <a href='./editAdress.php?id={$adress['id']}' class='btn btn-secondary' style='display: inline-block; margin-left: 20px;'>Edit Adress</a>

                                        <a href='./adresses.php?id={$adress['id']}' class='btn btn-danger' style='display: inline-block; margin-left: 20px;'>Delete Adress</a>

                                    </p>";
                                }

                            } else {
                                echo "<p><i>No addresses saved for this contact.</i></p>";
                            }

                        ?>

                    </div>
                </div>

            <?php endforeach ?>

        </div>
    </div>

<?php require "partials/footer.php" ?>