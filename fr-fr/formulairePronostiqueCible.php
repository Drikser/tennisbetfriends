<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <?php require("../commun/header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php include("entete.php"); ?>

    <!-- Le menu -->

    <?php include("menu.php"); ?>

    <!-- Le corps -->

    <div id="corps">
        <h1>tennisbetfriends.com</h1>

        <p>
            Validation des pronostiques<br />
        </p>

		<!-- Connexion base de données -->

		<?php
		//include("connexionSGBD.php");
		include("../commun/model.php");
		?>



		<?php

		if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))

		{
			echo "Tous les champs doivent être remplis ==> Retour au formulaire de création de match: " . '<a href="formulaireCreationMatch.php">Cliquer ici</a>';
		}
		else
		{
			//Chargement des scores en table MySQL des pronostiques
			$req = $bdd->prepare('INSERT INTO pronostique (PRO_JOU_ID, PRO_MATCH_ID, PRO_NOM_VQR, PRO_SCORE_JOU1, PRO_SCORE_JOU2, PRO_TYP_MATCH) VALUES (:IdJoueur, :IdMatch, :Vainqueur, :ScoreJoueur1, :ScoreJoueur2, :TypeMatch) WHERE PRO_MATCH_ID == $uneligne['RES_MATCH_ID']');
			$req->execute(array(
				'IdJoueur' => $_SESSION['JOU_ID'],
				'IdMatch' => $_POST['RES_MATCH_ID'],
				'VouD' => $_POST['Tournoi'],
				'Categorie' => $_POST['Categorie'],
				'DateMatch' => $_POST['DateMatch'],
				'Niveau' => $_POST['Niveau'],
				'Joueur1' => $_POST['Joueur1'],
				'ResultatMatch' => "",
				'TypeResultatMatch' => "",
				'ScoreJoueur1' => 0,
				'ScoreJoueur2' => 0,
				'Joueur2' => $_POST['Joueur2'],
				'Vainqueur' => ""));

			$nbRow = $req->rowcount();

			if ($nbRow > 0)
			{
				echo 'Bravo ! Pronostique fait !<br />';

				if ($_POST['VouD'] == 'V') {
					switch ($_POST['TypeMatch']) {
					 	case 'AB':
					 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Joueur1']) . ' contre ' . htmlspecialchars($_POST['Joueur2']) . ' par abandon *** ' . htmlspecialchars($_POST['ScoreJoueur1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJoueur2']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Joueur2'] . '<br />';
					 		break;

					 	case 'WO':
					 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Joueur1']) . ' contre ' . htmlspecialchars($_POST['Joueur2']) . ' par forfait. <br />';
					 		break;

					 	default:
					 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Joueur1']) . ' contre ' . htmlspecialchars($_POST['Joueur2']) . ' *** ' . htmlspecialchars($_POST['ScoreJoueur1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJoueur2']) . '<br />';
					 		break;
					 }
				}
				else {
					switch ($_POST['TypeMatch']) {
					 	case 'AB':
					 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Joueur2']) . ' contre ' . htmlspecialchars($_POST['Joueur1']) . ' par abandon *** ' . htmlspecialchars($_POST['ScoreJoueur2']) . ' sets à ' . htmlspecialchars($_POST['ScoreJoueur1']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Joueur1'] . '<br />';
					 		break;

					 	case 'WO':
					 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Joueur2']) . ' contre ' . htmlspecialchars($_POST['Joueur1']) . ' par forfait. <br />';
					 		break;

					 	default:
					 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Joueur2']) . ' contre ' . htmlspecialchars($_POST['Joueur1']) . ' *** ' . htmlspecialchars($_POST['ScoreJoueur2']) . ' sets à ' . htmlspecialchars($_POST['ScoreJoueur1']) . '<br />';
					 		break;
					}

				}
			}

				echo 'Pour créer un nouveau match, clique <a href="pronostique.php">' . 'ICI' . '</a><br/>';

			else
			{
				echo "Pronostique non créé pour une raison inconnue ... ";
			}

		?>



    </div>


    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
