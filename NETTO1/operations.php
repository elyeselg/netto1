<?php
session_start();
if (!isset($_SESSION['user']['ID'])) {
    header('Location: authentification.php');
}
?>
<!DOCTYPE html>
<?php
//$dsn = 'mysql:host=172.28.32.21:9000;dbname=netto1;charset=UTF8';
include 'configbdd.php';
?>
<html>
    <head>
        <title>Opérations</title>
        <meta charset="UTF-8" />
    </head>

    <body>
        <?php
        include 'header.php';
        ?>

        <form method="post" action="operations.php?id=<?= $_GET['id'] ?>">

            <fieldset>
                <legend> Opérations </legend>			



                <label for= "vidange"> Vidange </label>
                <input id="vidange" type="checkbox" name="type[]" value="C1">

                <br>

                <label for= "filtre à huile"> filtre à huile </label>
                <input id="filtre à huile" type="checkbox" name="type[]" value="C2">

                <br>

                <label for= "filtre à air"> filtre à air </label>
                <input id="filtre à air" type="checkbox" name="type[]" value="C3">

                <br>

                <label for= "filtre à carburant"> filtre à carburant </label>
                <input id="filtre à carburant" type="checkbox" name="type[]" value="C4">

                <br>

                <label for= "filtre à habitacle"> filtre à habitacle </label>
                <input id="filtre à habitacle" type="checkbox" name="type[]" value="C5">

                <br>

                <label for= "Vérifiez le niveau huile moteur"> Vérifiez le niveau d'huile moteur </label>
                <input id="Vérifiez le niveau huile moteur" type="checkbox" name="type[]" value="C6">

                <br>

                <label for= "Contrôlez le niveau du liquide de refroidissement"> Contrôlez le niveau du liquide de refroidissement </label>
                <input id="Contrôlez le niveau du liquide de refroidissement" type="checkbox" name="type[]" value="C7">

                <br>

                <label for= "Contrôlez les niveaux des liquides de freins et de direction assistée"> Contrôlez les niveaux des liquides de freins et de direction assistée </label>
                <input id="Contrôlez les niveaux des liquides de freins et de direction assistée" type="checkbox" name="type[]" value="C8">

                <br>

                <label for= "Testez état de la batterie"> Testez l'état de la batterie </label>
                <input id="Testez état de la batterie" type="checkbox" name="type[]" value="C9">

                <br>

                <label for= "Entretenir les pneumatiques"> Entretenir les pneumatiques </label>
                <input id="Entretenir les pneumatiques" type="checkbox" name="type[]" value="C10">

                <br>

                <label for= "Gardez les freins en bonne état"> Gardez les freins en bonne état </label>
                <input id="Gardez les freins en bonne état" type="checkbox" name="type[]" value="C11">


            </fieldset>

            <label for="date">Entretien pour le :</label>
            <input type="date" id="date" name="dateentretien"><br>

            <?php
            if (!empty($_POST)) {
                if (!isset($_POST['type'])) {
                    echo '<p>Veuillez cochez au moins une case</p>';
                    $erreur = true;
                }
                if ($_POST['dateentretien'] == '') {
                    echo '<p>Veuillez choisir une date</p>';
                    $erreur = true;
                }
                if (!isset($erreur)) {
                    try {
                        $dbh1 = new PDO($dsn, $user, $pass);
                        $dbh1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sqlInsert1 = "INSERT INTO entretien (DATEENTRETIEN) VALUES (:date)";
                        $stmtInsert1 = $dbh1->prepare($sqlInsert1);
                        $stmtInsert1->execute([':date' => $_POST['dateentretien']]);
                        $idEntretien = $dbh1->lastInsertId();
                    } catch (PDOException $ex) {
                        echo 'Erreur PDO : ' . $ex->getMessage();
                        echo ' < br>code = ' . $ex->getCode();
                    }

                    try {
                        $dbh2 = new PDO($dsn, $user, $pass);
                        $dbh2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sqlUpdate = "UPDATE vehicule SET IDENTRETIEN = :identretien WHERE IDVEHICULE = :id";
                        $stmtUpdate = $dbh2->prepare($sqlUpdate);
                        $stmtUpdate->execute([':identretien' => $idEntretien, ':id' => $_GET['id']]);
                    } catch (PDOException $ex) {
                        echo 'Erreur PDO : ' . $ex->getMessage();
                        echo ' < br>code = ' . $ex->getCode();
                    }

                    foreach ($_POST['type'] as $v) {
                        if ($v == 'C1') {
                            try {
                                $dbh3 = new PDO($dsn, $user, $pass);
                                $dbh3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert2 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert2 = $dbh3->prepare($sqlInsert2);
                                $stmtInsert2->execute([':identretien' => $idEntretien, ':idoperation' => 1]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C2') {
                            try {
                                $dbh4 = new PDO($dsn, $user, $pass);
                                $dbh4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert3 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert3 = $dbh4->prepare($sqlInsert3);
                                $stmtInsert3->execute([':identretien' => $idEntretien, ':idoperation' => 2]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C3') {
                            try {
                                $dbh5 = new PDO($dsn, $user, $pass);
                                $dbh5->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert4 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert4 = $dbh5->prepare($sqlInsert4);
                                $stmtInsert4->execute([':identretien' => $idEntretien, ':idoperation' => 3]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C4') {
                            try {
                                $dbh6 = new PDO($dsn, $user, $pass);
                                $dbh6->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert5 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert5 = $dbh6->prepare($sqlInsert5);
                                $stmtInsert5->execute([':identretien' => $idEntretien, ':idoperation' => 4]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C5') {
                            try {
                                $dbh7 = new PDO($dsn, $user, $pass);
                                $dbh7->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert6 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert6 = $dbh7->prepare($sqlInsert6);
                                $stmtInsert6->execute([':identretien' => $idEntretien, ':idoperation' => 5]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C6') {
                            try {
                                $dbh8 = new PDO($dsn, $user, $pass);
                                $dbh8->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert7 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert7 = $dbh8->prepare($sqlInsert7);
                                $stmtInsert7->execute([':identretien' => $idEntretien, ':idoperation' => 6]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C7') {
                            try {
                                $dbh9 = new PDO($dsn, $user, $pass);
                                $dbh9->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert8 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert8 = $dbh9->prepare($sqlInsert8);
                                $stmtInsert8->execute([':identretien' => $idEntretien, ':idoperation' => 7]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C8') {
                            try {
                                $dbh10 = new PDO($dsn, $user, $pass);
                                $dbh10->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert9 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert9 = $dbh10->prepare($sqlInsert9);
                                $stmtInsert9->execute([':identretien' => $idEntretien, ':idoperation' => 8]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C9') {
                            try {
                                $dbh11 = new PDO($dsn, $user, $pass);
                                $dbh11->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert10 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert10 = $dbh11->prepare($sqlInsert10);
                                $stmtInsert10->execute([':identretien' => $idEntretien, ':idoperation' => 9]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C10') {
                            try {
                                $dbh12 = new PDO($dsn, $user, $pass);
                                $dbh12->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert11 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert11 = $dbh12->prepare($sqlInsert11);
                                $stmtInsert11->execute([':identretien' => $idEntretien, ':idoperation' => 10]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                        if ($v == 'C11') {
                            try {
                                $dbh13 = new PDO($dsn, $user, $pass);
                                $dbh13->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlInsert12 = "INSERT INTO entretien_operation (IDENTRETIEN, IDOPERATION) VALUES (:identretien, :idoperation)";
                                $stmtInsert12 = $dbh13->prepare($sqlInsert12);
                                $stmtInsert12->execute([':identretien' => $idEntretien, ':idoperation' => 11]);
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo ' < br>code = ' . $ex->getCode();
                            }
                        }
                    }

                    header("Location: entretiens.php?id=$_GET[id]");
                }
            }
            ?>

            <input type="submit" name="valid" value="Valider" />

        </form>
        <?php
        include 'footer.php';
        ?>
    </body>
</html>