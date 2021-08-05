<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <?php require("../commun/header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php include("entete.php"); ?>


    <div id="conteneur">

        <!-- Le menu -->

        <?php include("menu.php"); ?>

        <!-- Le corps -->

        <div class="element_corps" id="corps">

            <p>
                Choose if you want to make an overall prediction for the tournament or make a prediction for the tournament matches:<br />
            </p>

    		<!-- Connexion base de données -->

    		<?php
            //include("connexionSGBD.php");
            // insertion page qui contient toutes les requêtes
            //include("../commun/model.php");


            if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE'])) {
                //$reponse = $bdd->query('SELECT * FROM résultats WHERE RES_MATCH_DAT = CURDATE()');
                //$reponse = $bdd->query('SELECT * FROM resultats WHERE RES_MATCH_DAT = CURDATE() AND RES_MATCH = ""');


                //*************************************************************************************************************
                //*                                       AFFICHAGE DES MATCHS DU JOUR
                //*************************************************************************************************************
                //$dailyMatchs = getDailyMatchs();

                //$nbRow = $reponse->rowcount();
                //$nbRow = $dailyMatchs->rowcount();

                //if ($nbRow > 0) {
                    //while ($donnees = $reponse->fetch())
                //    echo "<br />Le(s) match(s) du jour est(sont) :<br />";
                //    while ($donnees = $response->fetch()) {
                //        echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . '<br />';
                //    }
                //}
                //else {
                //    echo "Pas de matchs aujourd'hui. Repos !<br />";
                //}

            ?>
                <!-- PRONOSTIQUES DU TOURNOI -->
                <br /><a href="pronostique_tournoi.php"><h1>Bonus predictions</h1></a><br />

                <!-- PRONOSTIQUES DES MATCHS -->
                <br /><a href="pronostique_matchs.php"><h1>Match predictions</h1><br />

            <?php
            }
            else {

                echo "Pour pronostiquer, vous devez vous connecter à votre compte : <br />";

                // Affichage du formulaire de connexion
                include("formulaireConnexion.php");

                echo "Pas encore inscrit ? Faites partie de la communauté en cliquant <a href='formulaireInscription.php'>ICI</a><br />";
            }
      		?>

        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
