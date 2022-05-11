<header>
    <img src="Images/logoNetto.png">
    <nav>
        <ul>
            <li><a href="index.php"> <img src="Images/logoAccueil.png"> </a></li>
            <li><option value="nomPrenom"><?= $_SESSION['user']['NOM'] . ' ' . $_SESSION['user']['PRENOM'] ?></option></li>
            <li><a href="index.php?deconnexion=oui">Déconnexion</a></li>
        </ul>
    </nav>
</header>