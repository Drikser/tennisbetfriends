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
        <h1>Le coin de l'Admin</h1>

        <p>
            Création d'un nouveau match<br />
        </p>

		<!-- Connexion base de données -->

		 <?php include("connexionSGBD.php"); ?>

		<?php

		if (empty($_POST['Tournoi']) OR empty($_POST['Categorie']) OR empty($_POST['DateMatch']) OR empty($_POST['Niveau']) OR empty($_POST['Joueur1']) OR empty($_POST['Joueur2']))

		{
			echo "Tous les champs doivent être remplis ==> Retour au formulaire de création de match: " . '<a href="formulaireCreationMatch.php">Cliquer ici</a>';
		}
		else
		{
			//Determination poids du tour

			switch ($_POST['Niveau']) {

				case 'FINALE':
					$poidsTour = 1;
					break;

				case 'DEMI-FINALE':
					$poidsTour = 2;
					break;

				case 'QUART DE FINALE':
					$poidsTour = 4;
					break;

				case 'HUITIEME DE FINALE':
					$poidsTour = 8;
					break;

				case '3EME TOUR':
					$poidsTour = 16;
					break;

				case '2EME TOUR':
					$poidsTour = 32;
					break;

				case '1ER TOUR':
					$poidsTour = 64;
					break;

				default:
					$poidsTour = 0;
					break;
			}


			//Chargement du nouvel inscrit en table MySQL
			$req = $bdd->prepare('INSERT INTO resultats (RES_TOURNOI, RES_TYP_TOURNOI, RES_MATCH_DAT, RES_MATCH_TOUR, RES_MATCH_POIDS_TOUR, RES_MATCH_JOU1, RES_MATCH, RES_MATCH_TYPE, RES_MATCH_SCR_JOU1, RES_MATCH_SCR_JOU2, RES_MATCH_JOU2) VALUES (:Tournoi, :Categorie, :DateMatch, :Niveau, :PoidsTour, :Joueur1, :ResultatMatch, :TypeResultatMatch, :ScoreJoueur1, :ScoreJoueur2, :Joueur2)');
			$req->execute(array(
				'Tournoi' => $_POST['Tournoi'],
				'Categorie' => $_POST['Categorie'],
				'DateMatch' => $_POST['DateMatch'],
				'Niveau' => $_POST['Niveau'],
				'PoidsTour' => $poidsTour,
				'Joueur1' => $_POST['Joueur1'],
				'ResultatMatch' => "",
				'TypeResultatMatch' => "",
				'ScoreJoueur1' => 0,
				'ScoreJoueur2' => 0,
				'Joueur2' => $_POST['Joueur2']));

			$nbRow = $req->rowcount();

			if ($nbRow > 0)
			{
				echo 'Bravo ! Match : ' . htmlspecialchars($_POST['Categorie']) . ' *** ' . htmlspecialchars($_POST['Tournoi']) . ' *** ' . htmlspecialchars($_POST['Niveau']) . ' *** ' . htmlspecialchars($_POST['DateMatch']) . ' : ' . htmlspecialchars($_POST['Joueur1']) . ' contre ' . htmlspecialchars($_POST['Joueur2']) . ' bien créé<br />';
				echo 'Pour créer un nouveau match, clique <a href="formulaireCreationMatch.php">' . 'ICI' . '</a><br/>';

				$SQLMax = $bdd->query('SELECT Max(RES_MATCH_ID) as idMax FROM resultats');
				$donnees = $SQLMax->fetch();
				$idMatch = $donnees['idMax'];

				echo "ID du dernier match créé = " . $idMatch . '<br />';

				include ('creationEntreesTablePronostique.php');

			}
			else
			{
				echo "Match non créé pour une raison inconnue ... ";
			}
		}

		?>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
