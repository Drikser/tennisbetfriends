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

	        <p>
	            Validation du pronostique<br />
	        </p>

			<!-- Connexion base de données -->

			<?php // include("model.php"); ?>



			<?php

			//if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
			if ($_POST['VouD']=="" OR $_POST['ScoreJ1']=="" OR $_POST['ScoreJ2']=="")

			{
				echo "Tous les champs doivent être remplis. Vous avez saisit : Resultat=" . $_POST['VouD'] . ", Score=" . $_POST['ScoreJ1'] . "/" . $_POST['ScoreJ2'] . "> <br />";
				echo "Retour au formulaire de saisie de résultat : " . '<a href="saisieResultat.php">Cliquer ici</a>';
			}
			else
			{
				echo "Le résultat saisit est pour le match n°" . $_POST['idMatch'] . '<br />'; //idMAtch est la valeur du champs caché du formulaire de saisie de score
				echo "Le joueur est l'ID n°" . $_SESSION['JOU_ID'] . ' (' . $_SESSION['JOU_PSE'] . ')<br />';

				$nbRow = 0;

				$req = updateResult($_POST['idMatch']);

				//$nbRow = $req->rowcount();

				//if ($nbRow > 0)
				if ($req == true)
				{
					echo 'Le Résultat définitif et officiel est bien rentré en base de données !<br />';

					$typeMatch = $_POST['TypeMatch'];

					if ($_POST['VouD'] == 'V') {
					 	switch ($typeMatch) {
					 	 	case 'AB':
					 	 		echo 'Résultat officiel : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' par abandon *** ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player2']) . '<br />';
					 	 		break;

					 	 	case 'WO':
					 	 		echo 'Résultat officiel : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' par forfait. <br />';
					 	 		break;

					 	 	default:
					 	 		echo 'Résultat officiel : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' : ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . '<br />';
					 	 		break;
					 	 }
					}
					else {
						switch ($typeMatch) {
					 	 	case 'AB':
					 	 		echo 'Résultat officiel : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' par abandon *** ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player1']) . '<br />';
					 	 		break;

					 	 	case 'WO':
					 	 		echo 'Résultat officiel : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' par forfait. <br />';
					 	 		break;

					 	 	default:
					 	 		echo 'Résultat officiel : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' : ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . '<br />';
					 	 		break;
						}

	            	}

					echo 'Pour enregistrer un nouveau résultat, clique <a href="saisieResultat.php">' . 'ICI' . '</a><br/>';


					// Il faut maintenant contrôler les pronostiques des joueurs !!!
					// Les étapes :
					// 1- Aller chercher tous les pronostiques pour ce match
					// 2- Comparer chaque pronostique avec le résultat officiel
					// 3- Attribuer les points correspondants aux pronostics

					// 1----------------
					$req = getAllPrognosisForAMatch($_POST['idMatch']);


						// affichage du résulatat du match :
						echo "--------------------------------------------------------------------<br />";
						echo "idMatch=" . $_POST['idMatch'] . " Résultat=" . $_POST['VouD'] . " " . $_POST['ScoreJ1'] . "/" . $_POST['ScoreJ2'] . "<br />";
						echo "--------------------------------------------------------------------<br />";

	            		$level = $_POST['Round'];

						while ($prono = $req->fetch())
	            		{
					// 2----------------

	            			include("controleResultat.php");
	            			include("controleBonus.php");
	          			}
				}
				else
				{
					echo "Résultat non saisit pour une raison inconnue ... ";
				}
			}

			?>

		</div>

    </div>


    <!-- Le pied de page -->

    <?php include("piedDePage.php"); ?>

    </body>
</html>
