<nav id="menu">
<!--    <div class="element_menu"> -->
    <div class="element_menu">
        <!-- <h3>Menu</h3> -->

        <?php
        if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']))
        {
            if ($_SESSION['JOU_PSE'] == 'Admin')
            {
        ?>
            <nav>
                <ul>
                    <li><a class="a_menu" href="index.php">Accueil</a></li>
                    <!-- <li><a class="a_menu" href="draw.php">Tableau</a></li> -->
                    <li><a class="a_menu" href="gestionMatchs.php">Gestion des matchs</a></li>
                    <!-- <li><a class="a_menu" href="saisieResultat.php">Enregistrer un résultat</a></li> -->
                    <li><a class="a_menu" href="rules.php">Règlement</a></li>
                    <li><a class="a_menu" href="deconnexion.php">Se déconnecter</a></li>
                </ul>
            </nav>

            <?php
            }
            else
            {
            ?>
            <nav>
                <ul>
                    <li><a class="a_menu" href="index.php">Accueil</a></li>
                    <li><a class="a_menu" href="resultats.php">Résultats</a></li>
                    <li><a class="a_menu" href="pronostique.php">Les pronostiques</a></li>
                    <ul>
                        <li><a class="a_menu" href="pronostique_tournoi.php">Bonus</a></li>
                        <li><a class="a_menu" href="pronostique_matchs.php">Matchs</a></li>
                        <li><a class="a_menu" href="pagePerso.php">Vos pronostiques</a></li>
                    </ul>
                    <li><a class="a_menu" href="rules.php">Règlement</a></li>
                    <li><a class="a_menu" href="deconnexion.php">Se déconnecter</a></li>
                </ul>
            </nav>

            <!-- <h4><a href="../en-gb/index.php"><img src="../images/english_flag_rectangle_mini.png" alt="English flag" /></a><a class="a_menu" href="../en-gb/index.php"> Version anglaise</a></h4> -->

                <?php
            }
        }
        else
        {
        ?>
        <nav>
            <ul>
              <li><a class="a_menu" href="inscription.php">S'inscrire</a></li>
              <li><a class="a_menu" href="connexion.php">Se connecter</a></li>
            </ul>
        </nav>

        <!-- <h4><a href="../en-gb/index.php"><img src="../images/english_flag_rectangle_mini.png" alt="English flag" /></a><a class="a_menu" href="../en-gb/index.php"> Version anglaise</a></h4> -->

        <?php
        }
        ?>
    </div>
</nav>
