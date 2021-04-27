<?php
//
 // session_start(); // On démarre la session AVANT toute chose
 // include("../commun/model.php");
 // include("../commun/functions.php");

if (isset($_POST['VouD']) or isset($_POST['ScoreJ1']) or isset($_POST['ScoreJ2'])) {

  //if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
  if ($_POST['VouD']=="" or $_POST['ScoreJ1']=="" or $_POST['ScoreJ2']=="")
  {
    echo "Tous les champs doivent être remplis. Vous avez saisit : Resultat=" . $_POST['VouD'] . ", Score=" . $_POST['ScoreJ1'] . "/" . $_POST['ScoreJ2'] . "> <br />";
    echo "Retour au formulaire de saisie de résultat : " . '<a href="gestionMatchs.php">Cliquer ici</a>';
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

        $Winner = $_POST['Player2'];

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

      // Ensuite il faut créer le nouveau match en fonction du vainqueur
      // En fonction du numéro de séquence du match joué, le vainqueur se retrouvera en JOU1 ou en JOU2 du match suivant
      // Si Seq impair --> JOU1 (et nouveau numero de séquence = (Seq+1)/2)
      // Si Seq pair   --> JOU2 (et nouveau numero de séquence = Seq/2)
      // Si le nouveau numéro de séquence existe
      // - Mettre à jour le match avec le nouveau joueur
      // sinon
      // - Créer le nouveau match

      //
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

      $newDate = dateNextMatch($dateMatch,2); //next match is in 2 days
      $newDateStr = date('Y-m-d 11:00:00', $newDate);

      echo "La date du nouveau match est: " . $newDateStr . " (" . $dateMatch . " + 2 jours)<br />";

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
}
