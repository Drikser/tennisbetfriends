<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <?php require("../commun/header.php"); ?>

<!--
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="prono.css" />
        <title>tennisbetfriends.com</title>
    </head>
-->

    <body>

    <!-- L'en-tête -->

    <?php require("entete.php"); ?>


    <div id="conteneur">


	    <!-- Le menu -->

	    <?php require("menu.php"); ?>

	    <!-- Le corps -->

	    <div class="element_corps" id="corps">

	        <p>
	            Welcome to <i>www.tennisbetfriends.com</i>, the tennis prediction website to compete with friends!<br />

	        </p>

			<?php
			if (isset($_SESSION['JOU_PSE'])) {

				if ($_SESSION['JOU_PSE'] == "Admin") {


				 	// Affichage des joueurs pour lesquels il reste des pronostiques à faire
				 	// *** Suivi pronostiques joueurs ***
				 	// include ("suiviPronostiquesJoueurs.php");
				 	?>

				 	<p></p>

				 	<?php
				 	// Affichage du classement des joueurs pour l'admin
				 	// *** Classement général ***
				 	include ("classementJoueurs.php");
				 	?>

				 	<p></p>

				 	<?php
					// *** Récap pronostiques bonus des joueurs ***
				 	include ("affichageResultatsPronosBonus.php");

				 	?>

          <p></p>

			    <?php
			    // *** Récap pronostiques matchs des joueurs ***
			    include ("affichageResultatsPronosMatchs.php");

			    ?>

					<p>
						The reference website is <a href="https://www.atptour.com/" target="_blank">www.atptour.com</a><br />
					</p>

		            <?php

				}
				else {


 					?>

          <p>
          To enter your predictions, go to the match prediction section <a href="pronostique_matchs.php">Matches predictions</a><br /> <br />
          </p>
          <p>
          Next match(es) is(are) :<br />
          </p>

  				<?php

					$dailyMatchs = getDailyMatchs();
          $niveauPrecedent = "";

					//while ($donnees = $reponse->fetch()) {
					while ($donnees = $dailyMatchs->fetch()) {

              $outputRound = ConvertRoundFTE($donnees['RES_MATCH_TOUR']);

              if ($niveauPrecedent != $outputRound) {
                echo "<br />" . $outputRound . "<br />";
              };

  						// echo $donnees['RES_MATCH_DAT'] . " - " . $outputRound . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . '<br />';
              echo "(" . $donnees['RES_MATCH_TOUR_SEQ'] . ") - " . $donnees['RES_MATCH_DAT'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . '<br />';

              $niveauPrecedent = $outputRound;
          }

					//$reponse->closeCursor();

					//****************************************************
					//echo "<br /><br />Le prochain match est :<br />";

					//$nextMatchs = getNextMatchs();

					//while ($donnees = $reponse->fetch()) {
					//while ($donnees = $nextMatchs->fetch()) {

					//		echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . '<br />';
					//}
					//****************************************************
					//$reponse->closeCursor();

					?>
					<p>
						The reference website is <a href="https://www.atptour.com/" target="_blank">www.atptour.com</a><br />
					</p>

		            <?php
				}
			}
			else {
				?>


        <?php
        //  include ("clock.php");
        ?>

				<p>

  					Not registered yet? Please visit the page : <a href="inscription.php">Register</a><br />

            To make a prediction, please log into your account here:  <a href="connexion.php">Sign in</a><br />

		    </p>
		    <?php
			}
			?>
		</div>
    </div>

	<?php
	//$monfichier = fopen('compteurPageIndex.txt', 'r+');

	//$pages_vues = fgets($monfichier); // On lit la première ligne (nombre de pages vues)
	//$pages_vues++; // On augmente de 1 ce nombre de pages vues
	//fseek($monfichier, 0); // On remet le curseur au début du fichier
	//fputs($monfichier, $pages_vues); // On écrit le nouveau nombre de pages vues

	//fclose($monfichier);

	//echo '<p>Cette page a été vue ' . $pages_vues . ' fois !</p>';
	?>

    <!-- Le pied de page -->

    <?php require("../commun/piedDePAge.php"); ?>

    </body>
</html>
