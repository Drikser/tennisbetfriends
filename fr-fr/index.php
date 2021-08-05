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
	            Bienvenue sur <span class=congrats><i>www.tennisbetfriends.com</i></span>, le site de concours de pronostiques de tennis entre amis !<br />

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
						Le site de référence est <a href="https://www.atptour.com/" target="_blank">www.atptour.com</a><br />
					</p>

		            <?php

				}
				else {

          setlocale(LC_TIME, "fr_FR", "French");

          $tournament= getTournament();
          while ($donnees = $tournament->fetch())
          {
             $startDateTournament = $donnees['SET_DAT_START'];
          }

          $nowDate = date('Y-m-d H:i:s');

          $start = new \DateTime("{$startDateTournament}");
          $end = new \DateTime("{$nowDate}");

          $diff = $start->diff($end);
          $diffStr = $diff->format('%aj %Hh %Im %Ss');
 					?>

          <p>
          <span class=congrats>Important</span>, les pronostiques sur le tournoi doivent impérativement être faits <span class=warning>avant le début du tournoi</span>.<br />
          Pour cela, rendez-vous dans la section <a href="pronostique_tournoi.php">Pronostiques tournoi</a><br />
          <!-- Le tournoi commence le <span class=warning>dimanche <?php echo substr($startDateTournament,0,10); ?> </span> à <span class=warning><?php echo substr($startDateTournament,11,8); ?></span> (heure de Paris). Il vous reste donc <span class=warning><?php echo $diffStr; ?></span> pour vos pronostiques tournoi. -->
          </p>

          <p>
          Ensuite, n'oubliez pas de saisir vos pronostiques pour les matchs <span class=congrats>chaque jour</span>, an allant dans la section <a href="pronostique_matchs.php">Pronostiques matchs</a> <br />
          </p>

          <p>
          Si vous avez un doute sur comment fonctionne le site, vous pouvez consulter le règlement <a href="rules.php">ICI</a>.<br />
          </p>

          <p>
          Pour le reste, j'espère que vous prendrez du plaisir ! Bonne chance !<br /><br />
          </p>

  				<?php
					$dailyMatchs = getDailyMatchs();
          $nbRow = $dailyMatchs->rowcount();
          $niveauPrecedent = "";

          if ($nbRow > 0) {
            if ($nbRow > 1) {
              echo "<p>Les prochains matchs sont :<br /></p>";
            } else {
              echo "<p>Le prochain match est :<br /></p>";
            }
            //while ($donnees = $reponse->fetch()) {
  					while ($donnees = $dailyMatchs->fetch()) {

              if ($niveauPrecedent != $donnees['RES_MATCH_TOUR']) {
                echo "<br />" . $donnees['RES_MATCH_TOUR'] . "<br />";
              };

  						// echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . '<br />';
              echo "(" . $donnees['RES_MATCH_TOUR_SEQ'] . ") - " . $donnees['RES_MATCH_DAT'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . '<br />';

              $niveauPrecedent = $donnees['RES_MATCH_TOUR'];
            }
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

    <!-- Le pied de page -->
    <?php require("../commun/piedDePAge.php"); ?>

    </body>
</html>
