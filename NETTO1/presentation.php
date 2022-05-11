<?php
session_start();
if (!isset($_SESSION['user']['ID'])) {
    header('Location: authentification.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Qui somme-nous ?</title>
        <meta charset="UTF-8" />
    </head>

    <body>
        <?php
        include 'header.php';
        ?>

        <main>
            <h1>QUI SOMME-NOUS ?</h1>
        </main>

        <?php
        include 'footer.php';
        ?>

    </body>
</html>