<?php
session_start(); // On démarre la session AVANT toute chose
?>

 <!--
*****************************************
*  De mise à jour de la date d'un match *
*****************************************
-->

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

	    <div id="corps">

	        <p>
	            Validation de la nouvelle date<br />
	        </p>

			<!-- Connexion base de données -->

			<?php // include("../commun/model.php"); ?>



			<?php

			//if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
			if ($_POST['NewDateMatch']=="")

			{
				echo "La date est vide, vous n'avez saisi aucune date ! <br />";
				echo "Retour au formulaire de Modification de date : " . '<a href="gestionMatchs.php#saisieResultat">Cliquer ici</a>';
			}
			else
			{
				echo "La nouvelle date saisie est pour le match n°" . $_POST['idMatch'] . '<br />'; //idMAtch est la valeur du champs caché du formulaire de saisie de score
				echo "Le joueur est l'ID n°" . $_SESSION['JOU_ID'] . ' (' . $_SESSION['JOU_PSE'] . ')<br />';

				$nbRow = 0;

				$req = updateDate($_POST['idMatch']);

				//$nbRow = $req->rowcount();

				//if ($nbRow > 0)
				if ($req == true)
				{
					echo 'La date du match a bien été mise à jour dans la base de données !<br />';

					$newDateMatch = $_POST['NewDateMatch'];
					echo 'Nouvelle date = ' . htmlspecialchars($_POST['NewDateMatch']) . '<br />';

					echo 'Pour retourner à la page de gestion des matchs, clique <a href="gestionMatchs.php#saisieResultat">' . 'ICI' . '</a><br/>';

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

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
