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
        <title>Connexion</title>
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
                <form method="post" action="authentification.php">
                    <p><label for="login">Nom d'utilisateur :</label>
                        <input id="login" type="text" name="login"></p>

                    <p><label for="pass">Mot de passe :</label>
                        <input id="pass" type="password" name="pass"></p>

                    <p><input href="index.php" type="submit" value="Se connecter"></p>
                </form>
                <a href="creercompte.php"> Créer un compte </a>
            </ul>
            <?php
            if (!empty($_POST)) {

                if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['login'])) {
                    echo 'Veuillez entrer un nom d\'utilisateur correct';
                } else {
                    if (isset($_POST['login']) && isset($_POST['pass'])) {

                        try {
                            $dbh = new PDO($dsn, $user, $pass);
                            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = 'SELECT * FROM user WHERE login = :login AND pass = :pass';
                            $stmt = $dbh->prepare($sql);
                            $stmt->execute([':login' => $_POST['login'], ':pass' => $_POST['pass']]);
                            $nbsLignes = $stmt->rowCount();
                        } catch (PDOException $ex) {
                            echo 'Erreur PDO : ' . $ex->getMessage();
                            echo '<br>code = ' . $ex->getCode();
                        }
                        if ($nbsLignes == 1) {

                            $_SESSION['user'] = $stmt->fetch();

                            header('Location: index.php');
                        } else {
                            echo '<p>Authentification impossible, veuillez saisir ';
                            echo 'votre login et mot de passe à nouveau</p>';
                        }
                    }
                }
            }
            ?>

        </main>

    </body>
</html>
