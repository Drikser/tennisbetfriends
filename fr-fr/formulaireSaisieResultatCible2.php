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
	            Validation du pronostique<br />
	        </p>

			<!-- Connexion base de données -->

			<?php // include("../commun/model.php"); ?>



			<?php

			//if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
			// if ($_POST['VouD']=="" OR $_POST['ScoreJ1']=="" OR $_POST['ScoreJ2']=="")
      if ($_POST['VouD']=="")

			{
				echo "Vainqueur doit être saisit. <br />";
				echo "Retour au formulaire de saisie de résultat : " . '<a href="gestionMatchs.php">Cliquer ici</a>';
			}
			else
			{
        if ($_POST['TypeMatch'] != "") {
          $_POST['TypeMatch'] = "";
          // echo 'Type Match initialized';
        }
				echo "Le résultat saisit est pour le match n°" . $_POST['idMatch'] . '<br />'; //idMAtch est la valeur du champs caché du formulaire de saisie de score
				echo "Le joueur est l'ID n°" . $_SESSION['JOU_ID'] . ' (' . $_SESSION['JOU_PSE'] . ')<br />';
        echo "Match: " . $_POST['Player1'] . ' ' . $_POST['VouD'] . ' ' . $_POST['Player2'] . ' <br />';
        // echo "Autre données - Score J1=" . $_POST['ScoreJ1'] . ', Score J2=' . $_POST['ScoreJ2'] . ', Type Match=' . $_donnees['RES_MATCH_TYP'] . '.<br />';
        echo "Autre données - Score J1=" . $_POST['ScoreJ1'] . ', Score J2=' . $_POST['ScoreJ2'] . ', Type Match=' . $_POST['TypeMatch'] . '.<br />';


				$nbRow = 0;

				$req = updateResult($_POST['idMatch']);

				//$nbRow = $req->rowcount();

				//if ($nbRow > 0)
				if ($req == true)
				{
					echo 'Le Résultat définitif et officiel est bien rentré en base de données !<br />';

					$typeMatch = $_POST['TypeMatch'];
          $tournoi = $_POST['Tournoi'];
          $dateMatch = $_POST['DateMatch'];
          // $dateMatch = $DateMatch;
          $categorie = $_POST['Categorie'];
          $poids = $_POST['Poids'];
          $seq = $_POST['Sequence'];

					if ($_POST['VouD'] == 'V') {

            $Winner = $_POST['Player1'];

            switch ($typeMatch) {
					 	 	case 'AB':
					 	 		echo '<span class=info>Résultat officiel : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> par abandon : ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player2']) . '</span><br />';
					 	 		break;

					 	 	case 'WO':
					 	 		echo '<span class=info>Résultat officiel : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> par forfait. </span><br />';
					 	 		break;

					 	 	default:
					 	 		echo '<span class=info>Résultat officiel : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> : ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . '</span><br />';
					 	 		break;
					 	 }
					}
					else {

            $Winner = $_POST['Player2'];

						switch ($typeMatch) {
              case 'AB':
					 	 		echo '<span class=info>Résultat officiel : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> par abandon : ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player1']) . '<br />';
					 	 		break;

					 	 	case 'WO':
					 	 		echo '<span class=info>Résultat officiel : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> par forfait. </span><br />';
					 	 		break;

					 	 	default:
					 	 		echo '<span class=info>Résultat officiel : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> : ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . '</span><br />';
					 	 		break;
						  }

	        }

					echo 'Pour enregistrer un nouveau résultat, clique <a href="gestionMatchs.php#saisieResultat">' . '<span class=warning>ICI</span>' . '</a><br/>';

          // Ensuite il faut créer le nouveau match en fonction du vainqueur
					// En fonction du numéro de séquence du match joué, le vainqueur se retrouvera en JOU1 ou en JOU2 du match suivant
					// Si Seq impair --> JOU1 (et nouveau numero de séquence = (Seq+1)/2)
					// Si Seq pair   --> JOU2 (et nouveau numero de séquence = Seq/2)
          // Si le nouveau numéro de séquence existe
          // - Mettre à jour le match avec le nouveau joueur
          // sinon
          // - Créer le nouveau match

          // Si poids = 1, c'est la finale, pas besoin de créer un autre match
          //-------------------------------------------------------------------
          if ($poids > 1) {

            $newPoids = $poids / 2;
            echo "Poids du match rentré = " . $poids . " ==> nouveau poids = " . $newPoids . "<br />";

            if ($seq % 2 == 1) {
              $newSeq = ($seq + 1) / 2;
              echo "Seq du match rentré (" . $seq . ") est impair ==> Nouveau seq = " . $newSeq . "<br />";
              $newJou1 = $Winner;
              $newJou2 = "";
              echo "Nouveau match ==> Joueur1 = " . $newJou1 . " contre Joueur2 = " . $newJou2 . "<br />";
            }
            elseif ($seq % 2 == 0) {
              $newSeq = $seq / 2;
              echo "Seq du match rentré (" . $seq . ") est pair ==> Nouveau seq = " . $newSeq . "<br />";
              $newJou1 = "";
              $newJou2 = $Winner;
              echo "Nouveau match ==> Joueur1 = " . $newJou1 . " contre Joueur2 = " . $newJou2 . "<br />";
            }

            // IF poids=2 (semi-final), the new date will be the one in the settings_tournament table
            if ($poids != 2) {
              $newDate = dateNextMatch($dateMatch,2); //next match is in 2 days
              $newDateStr = date('Y-m-d 11:00:00', $newDate);
              echo "La date du nouveau match est: " . $newDateStr . " (" . $dateMatch . " + 2 jours)<br />";
            } else {
              $finalDate = getDateFinal();
              while ($donnees = $finalDate->fetch())
              {
                  $newDateStr = $donnees['SET_DAT_END'];
                  echo "La date de la finale est: " . $newDateStr . "<br />";
              }
            }
            // $newDateStr = date('Y-m-d 11:00:00', $newDate);

            // echo "La date du nouveau match est: " . $newDateStr . " (" . $dateMatch . " + 2 jours)<br />";

            //Determination libellé du tour du tour
            switch ($newPoids) {

            case 1:
                $niveau = 'FINALE';
                break;

            case 2:
                $niveau = 'DEMI-FINALE';
                break;

            case 4:
                $niveau = 'QUART DE FINALE';
                break;

            case 8:
                $niveau = 'HUITIEME DE FINALE';
                break;

            case 16:
                $niveau = '3EME TOUR';
                break;

            case 32:
                $niveau = '2EME TOUR';
                break;

            case 64:
                $niveau = '1ER TOUR';
                break;

            default:
                $Niveau = '';
                break;
            }

            // search if match exist: if YES, update with the 2nd player, if NO, create a new match
            $matchExists = searchIfMatchExists($newPoids, $newSeq);

            $nbRow = $matchExists->rowCount();

            echo "nbRow=" . $nbRow . "<br />";

            if ($nbRow > 0) {
            // update existing match
            //---------------------------------------
               echo "Il faut mettre à jour le match " . $newPoids . " - n° " . $newSeq . "<br />";

               if ($newJou1 != "") {
                 updateNextMatchJou1($newPoids, $newSeq, $newJou1);
                 echo "Match " . $newPoids . " - n° " . $newSeq . " mis à jour avec le joueur 1 : " . $newJou1 . "<br />";
               } else {
                 if ($newJou2 != "") {
                   updateNextMatchJou2($newPoids, $newSeq, $newJou2);
                   echo "Match " . $newPoids . " - n° " . $newSeq . " mis à jour avec le joueur 2 : " . $newJou2 . "<br />";
                 } else {
                   echo "Au moins un des deux joueurs doit être renseignés, il y a un problème !!! <br />";
                 }
               }

            } else {
              // create a new match
              //---------------------------------------
              $createMatchNextRound = createNextMatch();
              // récupérer l'Id du dernier match créé
              //---------------------------------------
              $lastMatch = getLastCreatedMatch();
              $donnees = $lastMatch->fetch();
              $idMatch = $donnees['RES_MATCH_ID'];
              echo "L'ID du dernier match créé est = " . $idMatch . "<br />";
              // récupérer les Id de tous les joueurs inscrits
              //------------------------------------------------
              $allPlayers = getAllPlayers();
              $nbRow = $allPlayers->rowcount();

              if ($nbRow > 0) {
                  while ($donnees = $allPlayers->fetch()) {

                      createMatchToPrognosis($donnees['JOU_ID'],$idMatch);

                      echo "Match " . $idMatch . " créé pour le joueur " . $donnees['JOU_ID'] . '<br />';
                  }

                  //echo 'Bravo ! Match : ' . htmlspecialchars($_POST['Categorie']) . ' *** ' . htmlspecialchars($_POST['Tournoi']) . ' *** ' . htmlspecialchars($_POST['Niveau']) . ' *** ' . htmlspecialchars($_POST['DateMatch']) . ' : ' . htmlspecialchars($_POST['Joueur1']) . ' contre ' . htmlspecialchars($_POST['Joueur2']) . ' bien créé<br />';
                  echo 'Pour créer un nouveau match, clique <a href="creationMatch.php">' . 'ICI' . '</a><br/>';
              }
              else {
                  echo "<span class='warning'>Aucun joueur n'est encore enregistré pour le concours, les entrées n'ont pas été créées !</span><br />";
              }
             }
          }
          // -- fin test si poids = 1


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

        // include("redirect_page.php");
      }

			?>

		</div>

    </div>


    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
