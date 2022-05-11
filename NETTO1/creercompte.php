<?php
session_start();
?>
<!DOCTYPE html>
<?php
//$dsn = 'mysql:host=172.28.32.21:9000;dbname=netto1;charset=UTF8';
include 'configbdd.php';
?>
<html>
    <head>
        <title>Créer un compte</title>
        <meta charset="UTF-8" />
        <style>
            ul {
                list-style: none; 
                text-align: center;
            }
        </style>
    </head>

    <body>

        <main>

            <ul>
                <form method="post" action="creercompte.php">
                    <p><label for="login">Nom d'utilisateur :</label>
                        <input id="login" type="text" name="login"></p>

                    <p><label for="pass">Mot de passe :</label>
                        <input id="pass" type="password" name="pass"></p>

                    <p><label for="mail">E-mail :</label>
                        <input id="mail" type="text" name="mail"></p>

                    <p><label for="nom">Nom :</label>
                        <input id="nom" type="text" name="nom"></p>

                    <p><label for="prenom">Prénom :</label>
                        <input id="prenom" type="text" name="prenom"></p>

                    <p><input type="submit" value="Créer le compte"></p>
                </form>
                <a href="authentification.php"> Se connecter </a>
            </ul>
            <?php
            if (!empty($_POST)) {

                if (!empty($_POST['login']) && !empty($_POST['pass']) && !empty($_POST['mail']) && !empty($_POST['nom']) && !empty($_POST['prenom'])) {

                    try {
                        $dbh = new PDO($dsn, $user, $pass);
                        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sqlInsert = "INSERT INTO user (login, pass, email, nom, prenom) VALUES (:login,:pass,:mail,:nom,:prenom)";
                        $stmtInsert = $dbh->prepare($sqlInsert);
                        $stmtInsert->execute([':login' => $_POST['login'], ':pass' => $_POST['pass'], ':mail' => $_POST['mail'], ':nom' => $_POST['nom'], ':prenom' => $_POST['prenom']]);
                        $sqlSelect = 'SELECT * FROM user WHERE login = :login AND pass = :pass';
                        $stmtSelect = $dbh->prepare($sqlSelect);
                        $stmtSelect->execute([':login' => $_POST['login'], ':pass' => $_POST['pass']]);
                    } catch (PDOException $ex) {
                        echo 'Erreur PDO : ' . $ex->getMessage();
                        echo ' < br>code = ' . $ex->getCode();
                    }

                    $_SESSION['user'] = $stmtSelect->fetch();
                    //echo 'Nom : ' . $_SESSION['user']['nom'] . ' Prénom : ' . $_SESSION['user']['prenom'];

                    header('Location: index.php');
                } else {
                    echo '<p>Création impossible, veuillez ';
                    echo 'réessayer</p>';
                }
            }
            ?>
        </main>

    </body>
</html>