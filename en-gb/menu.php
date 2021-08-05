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
                    <li><a class="a_menu" href="index.php">Home</a></li>
                    <li><a class="a_menu" href="creationMatch.php">Create a match</a></li>
                    <li><a class="a_menu" href="saisieResultat.php">Register a result</a></li>
                    <li><a class="a_menu" href="rules.php">Rules</a></li>
                    <li><a class="a_menu" href="deconnexion.php">Log off</a></li>
                </ul>
            </nav>

            <?php
            }
            else
            {
            ?>
            <nav>
                <ul>
                    <li><a class="a_menu" href="index.php">Home</a></li>
                    <li><a class="a_menu" href="resultats.php">Results</a></li>
                    <li><a class="a_menu" href="pronostique.php">Prediction</a></li>
                    <ul>
                        <li><a class="a_menu" href="pronostique_tournoi.php">Bonus</a></li>
                        <li><a class="a_menu" href="pronostique_matchs.php">Match</a></li>
                        <li><a class="a_menu" href="pagePerso.php">Your predictions</a></li>
                        </ul>
                    <li><a class="a_menu" href="rules.php">Rules</a></li>
                    <li><a class="a_menu" href="deconnexion.php">Sign off</a></li>
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
                <li><a class="a_menu" href="inscription.php">Register</a></li>
                <li><a class="a_menu" href="connexion.php">Sign in</a></li>
            </ul>
        </nav>

        <?php
        }
        ?>
    </div>
</nav>
