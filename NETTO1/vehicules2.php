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
try {
    $dbh = new PDO($dsn, $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT vehicule.IDVEHICULE, vehicule.IDENTRETIEN, marque.NOMMARQUE, modele.NOMMODELE, vehicule.IMMAT, vehicule.KILOMETRAGE FROM vehicule ';
    $sql = $sql . 'INNER JOIN modele on vehicule.IDMODELE = modele.IDMODELE ';
    $sql = $sql . 'INNER JOIN marque on modele.IDMARQUE = marque.IDMARQUE ';
    $sql = $sql . 'WHERE vehicule.IDVEHICULE = ' . $_GET['id'];
    $stmt = $dbh->query($sql);
    $ligneVehicule = $stmt->fetch();
} catch (PDOException $ex) {
    echo 'Erreur PDO : ' . $ex->getMessage();
    echo '<br>code = ' . $ex->getCode();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>

    <body>
        <?php
        include 'header.php';
        ?>

        <h1> Véhicules </h1>
        <h2></h2>
        <?php
        if (!empty($_POST)) {

            if (empty($_POST['immat'])) {
                echo '<p> Vous devez renseigner l immatriculation..</p>';
                $erreur = true;
            }

            if (empty($_POST['kilometrage'])) {
                echo '<p> Vous devez renseigner le kilometrage..</p>';
                $erreur = true;
            }

            if (!isset($erreur)) {
                try {
                    $dbh2 = new PDO($dsn, $user, $pass);
                    $dbh2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqlUpdate = "UPDATE vehicule SET IMMAT = :immat, KILOMETRAGE = :km WHERE IDVEHICULE = :id";
                    $stmtUpdate = $dbh2->prepare($sqlUpdate);
                    $stmtUpdate->execute([':id' => $_GET['id'], ':immat' => $_POST['immat'], ':km' => $_POST['kilometrage']]);
                } catch (PDOException $ex) {
                    echo 'Erreur PDO : ' . $ex->getMessage();
                    echo ' < br>code = ' . $ex->getCode();
                }
                header('Location: vehicules2.php?id=' . $_GET['id'] . '&change=ok');
                exit();
            }
        }
        if (isset($_GET['change'])) {
            if ($_GET['change'] == 'ok') {
                echo '<p>Changement effectué !</p>';
            }
        }
        if (isset($_GET['supp'])) {
            if ($_GET['supp'] == 'ok') {
                try {
                    $dbh3 = new PDO($dsn, $user, $pass);
                    $dbh3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqlDelete = "DELETE FROM vehicule WHERE IDVEHICULE = :id";
                    $stmtDelete = $dbh3->prepare($sqlDelete);
                    $stmtDelete->execute([':id' => $_GET['id']]);
                } catch (PDOException $ex) {
                    echo 'Erreur PDO : ' . $ex->getMessage();
                    echo ' < br>code = ' . $ex->getCode();
                }

                try {
                    $dbh4 = new PDO($dsn, $user, $pass);
                    $dbh4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqlDelete2 = "DELETE FROM entretien WHERE IDENTRETIEN = :id";
                    $stmtDelete2 = $dbh4->prepare($sqlDelete2);
                    $stmtDelete2->execute([':id' => $ligneVehicule['IDENTRETIEN']]);
                } catch (PDOException $ex) {
                    echo 'Erreur PDO : ' . $ex->getMessage();
                    echo ' < br>code = ' . $ex->getCode();
                }

                try {
                    $dbh5 = new PDO($dsn, $user, $pass);
                    $dbh5->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqlDelete3 = "DELETE FROM entretien_operation WHERE IDENTRETIEN = :id";
                    $stmtDelete3 = $dbh5->prepare($sqlDelete3);
                    $stmtDelete3->execute([':id' => $ligneVehicule['IDENTRETIEN']]);
                } catch (PDOException $ex) {
                    echo 'Erreur PDO : ' . $ex->getMessage();
                    echo ' < br>code = ' . $ex->getCode();
                }

                header('Location: vehicules.php');
                exit();
            }
        }
        if (isset($_GET['suppentretien'])) {
            if ($_GET['suppentretien'] == 'ok') {
                try {
                    $dbh6 = new PDO($dsn, $user, $pass);
                    $dbh6->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqlUpdate2 = "UPDATE vehicule SET IDENTRETIEN = null WHERE IDVEHICULE = :id";
                    $stmtUpdate2 = $dbh6->prepare($sqlUpdate2);
                    $stmtUpdate2->execute([':id' => $_GET['id']]);
                } catch (PDOException $ex) {
                    echo 'Erreur PDO : ' . $ex->getMessage();
                    echo ' < br>code = ' . $ex->getCode();
                }
                try {
                    $dbh7 = new PDO($dsn, $user, $pass);
                    $dbh7->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqlDelete4 = "DELETE FROM entretien WHERE IDENTRETIEN = :id";
                    $stmtDelete4 = $dbh7->prepare($sqlDelete4);
                    $stmtDelete4->execute([':id' => $ligneVehicule['IDENTRETIEN']]);
                } catch (PDOException $ex) {
                    echo 'Erreur PDO : ' . $ex->getMessage();
                    echo ' < br>code = ' . $ex->getCode();
                }
                try {
                    $dbh8 = new PDO($dsn, $user, $pass);
                    $dbh8->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sqlDelete5 = "DELETE FROM entretien_operation WHERE IDENTRETIEN = :id";
                    $stmtDelete5 = $dbh8->prepare($sqlDelete5);
                    $stmtDelete5->execute([':id' => $ligneVehicule['IDENTRETIEN']]);
                } catch (PDOException $ex) {
                    echo 'Erreur PDO : ' . $ex->getMessage();
                    echo ' < br>code = ' . $ex->getCode();
                }
                header('Location: vehicules2.php?id=' . $_GET['id']);
                exit();
            }
        }
        ?>
        <form method="post" action="vehicules2.php?id=<?= $ligneVehicule['IDVEHICULE'] ?>">
            <fieldlist>
                <ul>
                    <li>Modèle : <?= $ligneVehicule['NOMMODELE'] ?></li>

                    <br>

                    <li>Marque : <?= $ligneVehicule['NOMMARQUE'] ?></li>

                    <br>

                    <li><label for="immat">Immatriculation</label>
                        <input id="immat" name="immat" type="text" value="<?= $ligneVehicule['IMMAT'] ?>"/></li>

                    <br>

                    <li><label for="kilometrage">Kilométrage</label>
                        <input id="kilometrage" name="kilometrage" type="number" value="<?= $ligneVehicule['KILOMETRAGE'] ?>"/></li>

                    <br>

                    <?php
                    if ($_SESSION['user']['ADMIN'] == 1 && $ligneVehicule['IDENTRETIEN'] == null) {
                        echo '<li><a href = "operations.php?id=' . $_GET['id'] . '">Créer un entretien</a></li><br>';
                    } else if ($ligneVehicule['IDENTRETIEN'] != null) {
                        echo '<li><a href = "entretiens.php?id=' . $_GET['id'] . '">Voir l\'entretien</a></li><br>';
                    }
                    ?>

                    <?php
                    if ($_SESSION['user']['ADMIN'] == 1 && $ligneVehicule['IDENTRETIEN'] != null) {
                        echo '<li><a href = "vehicules2.php?id=' . $_GET['id'] . '&suppentretien=ok">Supprimer l\'entretien</a></li><br>';
                    }
                    if($_SESSION['user']['ADMIN'] == 1){
                        echo '<li><a href = "vehicules2.php?id=' . $_GET['id'] . '&supp=ok">Supprimer le véhicule</a></li>';
                    }
                    ?>

                </ul>
            </fieldlist>
            <input type="submit" value="Valider" />
        </form>

        <?php
        include 'footer.php';
        ?>
    </body>
</html>
