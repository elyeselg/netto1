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
        <meta charset="UTF-8">
        <title>Véhicules</title>
    </head>

    <body>
        <?php
        include 'header.php';
        ?>

        <h1> Véhicules </h1>
        <h2> Les différents véhicules</h2>
        <ul>
            <?php
            try {
                $dbh = new PDO($dsn, $user, $pass);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'SELECT vehicule.IDVEHICULE, marque.NOMMARQUE, modele.NOMMODELE, vehicule.IMMAT FROM vehicule ';
                $sql = $sql . 'INNER JOIN modele on vehicule.IDMODELE = modele.IDMODELE ';
                $sql = $sql . 'INNER JOIN marque on modele.IDMARQUE = marque.IDMARQUE ';
                $stmt = $dbh->query($sql);
                $tabVehicules = $stmt->fetchAll();
            } catch (PDOException $ex) {
                echo 'Erreur PDO : ' . $ex->getMessage();
                echo '<br>code = ' . $ex->getCode();
            }
            foreach ($tabVehicules as $ligne) {
                echo '<li><a href="vehicules2.php?id=' . $ligne['IDVEHICULE'] . '">' . $ligne['NOMMARQUE'] . ' ' . $ligne['NOMMODELE'] . ' ' . $ligne['IMMAT'] . '</a></li>';
            }
            if ($_SESSION['user']['ADMIN'] == 1) {
                echo '<li><a href="ajoutvehicule.php">Ajouter un véhicule</a></li>';
            }
            ?>
        </ul>

        <?php
        include 'footer.php';
        ?>

    </body>
</html>
