<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <?php require("header.php"); ?>

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
	            Bienvenue sur <i>www.tennisbetfriends.com</i>, le site de concours de pronostiques de tennis entre amis !<br />

	        </p>

			<!-- Connexion base de données -->

			 <?php
			 //include("connexionSGBD.php");
			 //include("model.php");
			 //dbConnect();
			 ?>

			<?php
			if (isset($_SESSION['JOU_PSE'])) {

				if ($_SESSION['JOU_PSE'] == "Admin") {


				 	// Affichage des joueurs pour lesquels il reste des pronostiques à faire
				 	// *** Suivi pronostiques joueurs ***
				 	include ("suiviPronostiquesJoueurs.php");
				 	?>

				 	<p></p>

				 	<?php
				 	// Affichage du classement des joueurs pour l'admin
				 	// *** Classement général ***
				 	include ("classementJoueurs.php");
				 	?>

				 	<p></p>

				 	<?php
					// Affichage du classement des joueurs pour l'admin
					// *** Récap pronostiques matchs des joueurs ***
				 	//include ("affichageResultats.php");
				 	include ("affichageResultatsPronosMatchs.php");

				 	?>
					<p>
						Le site de référence est <a href="https://www.atptour.com/" target="_blank">www.atptour.com</a><br />
					</p>

		            <?php

				}
				else {


 					?>

   				    <!--
   				    <script>
       					alert('Hello toi!');
    				</script>
    				-->

          <p>
          Pour saisir vos pronostiques, rendez-vous dans la section <a href="pronostique_matchs.php">Pronostiques matchs</a><br /> <br />
          </p>
          <p>
          Le(s) prochains (s) match(s) est(sont) :<br />
          </p>

  				<?php

					$dailyMatchs = getDailyMatchs();

					//while ($donnees = $reponse->fetch()) {
					while ($donnees = $dailyMatchs->fetch()) {

							echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . '<br />';
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
						Le site de référence est <a href="https://www.atptour.com/" target="_blank">www.atptour.com</a><br />
					</p>

		            <?php
				}
			}
			else {
				?>
				<p>
					Pas encore inscrit ? Faites partie de la communauté en cliquant en allant sur la page : <a href="inscription.php">Inscription</a><br />

		            Pour pronostiquer, vous devez vous connecter à votre compte en allant sur la page :  <a href="connexion.php">Connexion</a><br />

		        </p>
		    <?php
			}
			?>
		</div>
    </div>

	<?php
	$monfichier = fopen('compteurPageIndex.txt', 'r+');

	$pages_vues = fgets($monfichier); // On lit la première ligne (nombre de pages vues)
	$pages_vues++; // On augmente de 1 ce nombre de pages vues
	fseek($monfichier, 0); // On remet le curseur au début du fichier
	fputs($monfichier, $pages_vues); // On écrit le nouveau nombre de pages vues

	fclose($monfichier);

	//echo '<p>Cette page a été vue ' . $pages_vues . ' fois !</p>';
	?>


    <!-- Le pied de page -->

    <?php require("piedDePage.php"); ?>

    </body>
</html>
