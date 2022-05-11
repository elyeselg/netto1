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
        <title>Ajouter un véhicule</title>
    <metacharset="UTF-8" />
</head>
<body>
    <?php
    include 'header.php';
    if (!empty($_POST)) {
        if (empty($_POST['marque'])) {
            echo '<p> Vous devez renseigner la marque..</p>';
            $erreur = true;
        }

        if (empty($_POST['modele'])) {
            echo '<p> Vous devez renseigner le modele..</p>';
            $erreur = true;
        }

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
                $sqlInsert = "INSERT INTO vehicule (IDMODELE, IMMAT, KILOMETRAGE) VALUES (:idmodele,:immat,:km)";
                $stmtInsert = $dbh2->prepare($sqlInsert);
                $stmtInsert->execute([':idmodele' => $_POST['modele'], ':immat' => $_POST['immat'], ':km' => $_POST['kilometrage']]);
            } catch (PDOException $ex) {
                echo 'Erreur PDO : ' . $ex->getMessage();
                echo ' < br>code = ' . $ex->getCode();
            }

            header('Location: vehicules.php');
        }
    }
    ?>

    <form method='post' action="ajoutvehicule.php">
        <h1> Ajouter un véhicule </h1>

        <p> Marque</p>
        <label for="marque"></label>
        <select id="marque" name="marque">
            <?php
            try {
                $dbh = new PDO($dsn, $user, $pass);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'SELECT marque.IDMARQUE, marque.NOMMARQUE FROM marque ';
                $stmt = $dbh->query($sql);
                $tabMarques = $stmt->fetchAll();
            } catch (PDOException $ex) {
                echo 'Erreur PDO : ' . $ex->getMessage();
                echo '<br>code = ' . $ex->getCode();
            }
            foreach ($tabMarques as $ligne) {
                echo '<option value="' . $ligne['IDMARQUE'] . '">' . $ligne['NOMMARQUE'] . '</option>';
            }
            ?>
        </select>


        <p> Modèle </p>
        <label for="modele"></label>
        <select id="modele" name="modele">
            <?php
            try {
                $dbh3 = new PDO($dsn, $user, $pass);
                $dbh3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sqlMod = 'SELECT modele.IDMODELE, modele.NOMMODELE FROM modele ';
                $stmtMod = $dbh3->query($sqlMod);
                $tabModeles = $stmtMod->fetchAll();
            } catch (PDOException $ex) {
                echo 'Erreur PDO : ' . $ex->getMessage();
                echo '<br>code = ' . $ex->getCode();
            }
            foreach ($tabModeles as $ligne) {
                echo '<option value="' . $ligne['IDMODELE'] . '">' . $ligne['NOMMODELE'] . '</option>';
            }
            ?>
        </select>

        <p> Immatriculation </p>
        <label for="immat"></label>
        <input id="immat" name="immat" type="text" >

        <p> Kilométrage </p>
        <label for="kilometrage"></label>
        <input id="kilometrage" name="kilometrage" type="number">


        <br> <br> <input type="submit" value="Valider" >
    </form>


    <?php include 'footer.php' ?>

</body>
</html>