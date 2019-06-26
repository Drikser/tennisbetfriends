<nav id="menu">
<!--    <div class="element_menu"> -->
    <div class="element_menu">
        <h3>Menu</h3>

        <?php
        if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']))
        {
            if ($_SESSION['JOU_PSE'] == 'Admin')
            {
        ?>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="creationMatch.php">Créer un match</a></li>
                    <li><a href="saisieResultat.php">Enregistrer un résultat</a></li>
                    <li><a href="rules.php">Règlement</a></li>
                    <li><a href="deconnexion.php">Se déconnecter</a></li>
                </ul>
            </nav>
            <?php
            }
            else
            {
            ?>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="pagePerso.php">Page perso</a></li>
                    <li><a href="resultats.php">Résultats</a></li>
                    <li><a href="pronostique.php">Faire un pronostique</a></li>
                    <ul>
                        <li><a href="pronostique_tournoi.php">Pronostiques tournoi</a></li>
                        <li><a href="pronostique_matchs.php">Pronostiques matchs</a></li>
                    </ul>
                    <li><a href="rules.php">Règlement</a></li>
                    <li><a href="deconnexion.php">Se déconnecter</a></li>
                </ul>
            </nav>
                <?php
            }
        }
        else
        {
        ?>
        <nav>
            <ul>
                <li><a href="inscription.php">S'inscrire</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
            </ul>
        </nav>
        <?php
        }
        ?>
    </div>
</nav>
