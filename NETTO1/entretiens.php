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
        <title>Entretien</title>
        <meta charset="UTF-8" />
    </head>

    <body>
        <?php
        include 'header.php';
        ?>

        <main>
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
                        echo '<li><a href = "vehicules2.php?id=' . $_GET['id'] . '">Masquer l\'entretien</a></li>';
                        ?>

                        <ul>
                            <?php
                            try {
                                $dbh6 = new PDO($dsn, $user, $pass);
                                $dbh6->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $sqlSelect = 'SELECT entretien.DATEENTRETIEN, operation.NOMOPERATION FROM operation ';
                                $sqlSelect = $sqlSelect . 'INNER JOIN entretien_operation on operation.IDOPERATION = entretien_operation.IDOPERATION ';
                                $sqlSelect = $sqlSelect . 'INNER JOIN entretien on entretien_operation.IDENTRETIEN = entretien.IDENTRETIEN ';
                                $sqlSelect = $sqlSelect . 'INNER JOIN vehicule on entretien.IDENTRETIEN = vehicule.IDENTRETIEN ';
                                $sqlSelect = $sqlSelect . 'WHERE vehicule.IDVEHICULE = ' . $_GET['id'];
                                $stmtSelect = $dbh6->query($sqlSelect);
                                $tabEntretien = $stmtSelect->fetchAll();
                            } catch (PDOException $ex) {
                                echo 'Erreur PDO : ' . $ex->getMessage();
                                echo '<br>code = ' . $ex->getCode();
                            }
                            foreach ($tabEntretien as $ligne) {
                                if (!isset($dateEntretien)) {
                                    echo 'Pour le : ' . $ligne['DATEENTRETIEN'];
                                    $dateEntretien = 'ok';
                                }
                                echo '<li>' . $ligne['NOMOPERATION'] . '</li>';
                            }
                            ?>
                        </ul>

                        <?php
                        if ($_SESSION['user']['ADMIN'] == 1 && $ligneVehicule['IDENTRETIEN'] != null) {
                            echo '<li><a href = "vehicules2.php?id=' . $_GET['id'] . '&suppentretien=ok">Supprimer l\'entretien</a></li><br>';
                        }
                        if ($_SESSION['user']['ADMIN'] == 1) {
                            echo '<li><a href = "vehicules2.php?id=' . $_GET['id'] . '&supp=ok">Supprimer le véhicule</a></li>';
                        }
                        ?>

                    </ul>
                </fieldlist>
                <input type="submit" value="Valider" />
            </form>
        </main>

        <?php
        include 'footer.php';
        ?>
    </body>
</html>