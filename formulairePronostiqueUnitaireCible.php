<?php
session_start(); // On démarre la session AVANT toute chose
?>

 <!--
*************************************
*  De mise à jour d'un pronostique  *
*  ==> Un seul match pronostiqué    *
*************************************
-->

<!DOCTYPE html>
<html>

    <?php require("header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php include("entete.php"); ?>


    <div id="conteneur">


	    <!-- Le menu -->

	    <?php include("menu.php"); ?>

	    <!-- Le corps -->

	    <div id="corps">
	        <h1>Pronostiques des matchs</h1>

	        <p>
	            Validation du pronostique<br />
	        </p>

			<!-- Connexion base de données -->

			<?php
			//include("connexionSGBD.php");
			//include("model.php");

			//if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))

			if ($_POST['VouD']=="" OR $_POST['ScoreJ1']=="" OR $_POST['ScoreJ2']=="")
			{
				echo "Tous les champs doivent être remplis. Vous avez saisit : Resultat=" . $_POST['VouD'] . ", Score=" . $_POST['ScoreJ1'] . "/" . $_POST['ScoreJ2'] . "<br />";
				echo "Retour au formulaire de saisie de pronostique: " . '<a href="pronostique	.php">Cliquer ici</a>';
			}
			else
			{
				//echo "Le match saisit est le match n°" . $_POST['idMatch'] . '<br />'; //idMAtch est la valeur du champs caché du formulaire de saisie de score
				//echo "Le joueur est l'ID n°" . $_SESSION['JOU_ID'] . '<br />';

				$typeMatch = $_POST['TypeMatch'];

				//Contrôles avant chargement :
				$pronoOK = 'OK';

				switch ($typeMatch) {
					case 'AB':
						if ($_POST['ScoreJ1'] == 2) {
							echo "<span class='warning'>Attention : Le perdant ne peut pas abandonner si le gagnant a déjà 2 sets</span><br />";
							$pronoOK = 'KO';
						}
						break;
					case 'WO':
						if ($_POST['ScoreJ1'] != 0 AND $_POST['ScoreJ2'] != 0) {
							echo "<span class='warning'>Attention : si il y a forfait, le score doit être 0-0</span><br />";
							$pronoOK = 'KO';
						}
						break;

					default:
	                    if ($_POST['ScoreJ1'] == 0) {
	                        echo "<span class='warning'>Mauvais score renseigné : Le vainqueur ne peut pas gagner avec 0 set</span><br />";
	                        $pronoOK = 'KO';
	                    }

	                    if ($_POST['TypeTournoi'] != 'GC') {

	                    	//echo "type de tournoi différent de GC : <" . $_POST['TypeTournoi'] . "><br />";

		                    if ($_POST['ScoreJ1'] != 2) {
		                        //echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 2 sets !!! Type Tournoi <" . $_POST['TypeTournoi'] . "></span><br />";
		                        echo "<span class='warning'>Mauvais score renseigné : Le vainqueur doit gagner 2 sets</span><br />";
		                        $pronoOK = 'KO';
		                    }
	                    }
	                    else {

	                    	if ($_POST['ScoreJ1'] != 3) {
	                    		//echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 3 sets !!! Type Tournoi = " . $_POST['TypeTournoi'] . "</span><br />";
	                    		echo "<span class='warning'>Mauvais score renseigné : Le vainqueur doit gagner 3 sets</span><br />";
	                        	$pronoOK = 'KO';
	                    	}
	                    }

	                    if ($_POST['ScoreJ2'] >= $_POST['ScoreJ1']) {
	                        echo "<span class='warning'>Mauvais score renseigné : Le nombre de sets du perdant doit être inférieur au vainqueur</span><br />";
	                        $pronoOK = 'KO';
	                    }
						break;
				}

				//Chargement des scores en table MySQL des pronostiques
				$nbRow = 0;

				if ($pronoOK == 'OK') {

					$req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch']);

					$nbRow = $req->rowcount();
				}
				else {
					echo "<span class='warning'>Merci de ré-essayer " . '<a href="pronostique_matchs.php">ICI</a>' . ". Si l'erreur persiste, veuillez contacter l'admninistrateur du site.</span><br />";
				}


				if ($nbRow > 0)
				{
					echo 'Bravo ! Pronostique fait !<br />';

					if ($_POST['VouD'] == 'V') {
					 	switch ($typeMatch) {
					 	 	case 'AB':
					 	 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' par abandon *** ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player2']) . '<br />';
					 	 		break;

					 	 	case 'WO':
				 	 			echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' par forfait. <br />';
				 	 			break;

					 	 	default:
				 	 			echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' : ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . '<br />';
				 	 			break;
					 	 }
					 }
					 else {
					 	switch ($typeMatch) {
					 	 	case 'AB':
					 	 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' par abandon *** ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player1']) . '<br />';
					 	 		break;

					 	 	case 'WO':
					 	 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' par forfait. <br />';
					 	 		break;

					 	 	default:
					 	 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' : ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . '<br />';
					 	 		break;
					 	}
					}

					echo '<br />Pour modifier ce pronostique, aller dans la section "Page perso"';
					echo '<br />Pour faire un nouveau pronostique, clique <a href="pronostique_matchs.php">' . 'ICI' . '</a><br/>';

				}
			}

			?>


	    </div>

    </div>


    <!-- Le pied de page -->

    <?php include("piedDePage.php"); ?>

    </body>
</html>
