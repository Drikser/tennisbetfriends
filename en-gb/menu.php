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
                    <li><a class="a_menu" href="index.php">Home</a></li>
                    <li><a class="a_menu" href="creationMatch.php">Create a match</a></li>
                    <li><a class="a_menu" href="saisieResultat.php">Register a result</a></li>
                    <li><a class="a_menu" href="rules.php">Rules</a></li>
                    <li><a class="a_menu" href="deconnexion.php">Log off</a></li>
                </ul>
            </nav>

            <h4><a href="../fr-fr/index.php"><img src="../images/french_flag_rectangle_mini.png" alt="French flag" /></a><a class="a_menu" href="../fr-fr/index.php"> French version</a></h4>

            <?php
            }
            else
            {
            ?>
            <nav>
                <ul>
                    <li><a class="a_menu" href="index.php">Home</a></li>
                    <li><a class="a_menu" href="pagePerso.php">Personal page</a></li>
                    <li><a class="a_menu" href="resultats.php">Results</a></li>
                    <li><a class="a_menu" href="pronostique.php">Make a prediction</a></li>
                    <ul>
                        <li><a class="a_menu" href="pronostique_tournoi.php">Bonus predictions</a></li>
                        <li><a class="a_menu" href="pronostique_matchs.php">Matches predictions</a></li>
                    </ul>
                    <li><a class="a_menu" href="rules.php">Rules</a></li>
                    <li><a class="a_menu" href="deconnexion.php">Sign off</a></li>
                </ul>
            </nav>

            <h4><a href="../fr-fr/index.php"><img src="../images/french_flag_rectangle_mini.png" alt="French flag" /></a><a class="a_menu" href="../fr-fr/index.php"> French version</a></h4>

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

        <h4><a href="../fr-fr/index.php"><img src="../images/french_flag_rectangle_mini.png" alt="French flag" /></a><a class="a_menu" href="../fr-fr/index.php"> French version</a></h4>

        <?php
        }
        ?>
    </div>
</nav>
