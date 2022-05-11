<?php
session_start();
if (!isset($_SESSION['user']['ID'])) {
    header('Location: authentification.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Mentions légales</title>
        <meta charset="UTF-8" />
    </head>

    <body>
        <?php
        include 'header.php';
        ?>

        <main>
            <h1>MENTIONS LÉGALES</h1>
        </main>

        <?php
        include 'footer.php';
        ?>

    </body>
</html>