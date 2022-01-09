 <?php

include("baremes.php");


$tournamentWinner = '';
$finalist = '';
$semiFinalist = '';


//********************************
// CONTROLE DES DEMI-FINALISTES
//********************************
//if ($_POST['Round'] == 'FINALE') {

if ($level == 'QUART DE FINALE') {

  echo 'Level=' . $level . ' <br />';

  // Rechercher les joueurs qui sont en demi-finale ==> requête sur les matchs avec poids 2 (demi-finales)
  // Pour chaque enregistrement trouvé, garder joueur 1 et joueur 2 et alimenter un tableau des demi-Finalistes
  // Ensuite chercher si dans les pronostiques bonus du participant, une des valeur est trouvée dans le Tableau
  // Si trouvé = points du bonus demi-finale
  // Si non trouvé = zéro
  // --> ici écrire requête pour lire table 'resultat'
  $tabSemiFinalists = array();
  $i = 0;
  $iMax = 0;
  $actualSemiFinalists = getSemiFinalists();

  while ($donnees = $actualSemiFinalists->fetch()){
    if ($donnees['RES_MATCH_JOU1'] != "") {
      $tabSemiFinalists[$i] = $donnees['RES_MATCH_JOU1'];
      $iMax = $i;
      $i++;
    }
    if ($donnees['RES_MATCH_JOU2'] != "") {
  	  $tabSemiFinalists[$i] = $donnees['RES_MATCH_JOU2'];
      $iMax = $i;
  	  $i++;
    }
	}

  // echo '<pre>';
  // print_r($tabSemiFinalists);
  // echo '</pre>';


	$bonusPrognosis = getBonusPrognosis($prono['PRO_JOU_ID']);
	//$bonusPrognosis = getPronostique_Bonus($_SESSION['JOU_ID']);
	//$req = getBonusPrognosis($prono['PRO_JOU_ID']);
	//$req = getPronostique_Bonus($prono['PRO_JOU_ID']);

  if (in_array($bonusPrognosis['PROB_DEMI1'], $tabSemiFinalists)) {
    echo 'Bravo à ' . $prono['PRO_JOU_ID'] . ' : pronostique demi-finaliste 1 correct - ' . $bonusPrognosis['PROB_DEMI1'] . ' est en demi-finale !<br />';
    updateBonusPrognosisSemi1Pts($prono['PRO_JOU_ID'],$ptsSemi);
  } else {
    updateBonusPrognosisSemi1Pts($prono['PRO_JOU_ID'],$zero);
  }

  if (in_array($bonusPrognosis['PROB_DEMI2'], $tabSemiFinalists)) {
    echo 'Bravo à ' . $prono['PRO_JOU_ID'] . ' : pronostique demi-finaliste 2 correct - ' . $bonusPrognosis['PROB_DEMI2'] . ' est en demi-finale !<br />';
    updateBonusPrognosisSemi2Pts($prono['PRO_JOU_ID'],$ptsSemi);
  } else {
    updateBonusPrognosisSemi2Pts($prono['PRO_JOU_ID'],$zero);
  }

  if (in_array($bonusPrognosis['PROB_DEMI3'], $tabSemiFinalists)) {
    echo 'Bravo à ' . $prono['PRO_JOU_ID'] . ' : pronostique demi-finaliste 3 correct - ' . $bonusPrognosis['PROB_DEMI3'] . ' est en demi-finale !<br />';
    updateBonusPrognosisSemi3Pts($prono['PRO_JOU_ID'],$ptsSemi);
  } else {
    updateBonusPrognosisSemi3Pts($prono['PRO_JOU_ID'],$zero);
  }

  if (in_array($bonusPrognosis['PROB_DEMI4'], $tabSemiFinalists)) {
    echo 'Bravo à ' . $prono['PRO_JOU_ID'] . ' : pronostique demi-finaliste 4 correct - ' . $bonusPrognosis['PROB_DEMI4'] . ' est en demi-finale !<br />';
    updateBonusPrognosisSemi4Pts($prono['PRO_JOU_ID'],$ptsSemi);
  } else {
    updateBonusPrognosisSemi4Pts($prono['PRO_JOU_ID'],$zero);
  }
}

//***************************
// CONTROLE DES FINALISTES
//***************************
if ($level == 'DEMI-FINALE') {

  echo 'Level=' . $level . ' <br />';

  // Rechercher les joueurs qui sont en demi-finale ==> requête sur les matchs avec poids 2 (demi-finales)
  // Pour chaque enregistrement trouvé, garder joueur 1 et joueur 2 et alimenter un tableau des demi-Finalistes
  // Ensuite chercher si dans les pronostiques bonus du participant, une des valeur est trouvée dans le Tableau
  // Si trouvé = points du bonus demi-finale
  // Si non trouvé = zéro
  // --> ici écrire requête pour lire table 'resultat'
  $tabFinalists = array();
  $i = 0;
  $actualFinalists = getFinalists();

  while ($donnees = $actualFinalists->fetch()){
    if ($donnees['RES_MATCH_JOU1'] != ""){
      $tabFinalists[$i] = $donnees['RES_MATCH_JOU1'];
      $i++;
    }
    if ($donnees['RES_MATCH_JOU2'] != "") {
      $tabFinalists[$i] = $donnees['RES_MATCH_JOU2'];
    	$i++;
    }
	}

  // echo '<pre>';
  // print_r($tabFinalists);
  // echo '</pre>';

	$bonusPrognosis = getBonusPrognosis($prono['PRO_JOU_ID']);
	//$bonusPrognosis = getPronostique_Bonus($_SESSION['JOU_ID']);
	//$req = getBonusPrognosis($prono['PRO_JOU_ID']);
	//$req = getPronostique_Bonus($prono['PRO_JOU_ID']);

  if (in_array($bonusPrognosis['PROB_FINAL1'], $tabFinalists)) {
    echo 'Bravo à ' . $prono['PRO_JOU_ID'] . ' : pronostique finaliste 1 correct - ' . $bonusPrognosis['PROB_FINAL1'] . ' est en finale !<br />';
    updateBonusPrognosisFinal1Pts($prono['PRO_JOU_ID'],$ptsFinalist);
  } else {
    updateBonusPrognosisFinal1Pts($prono['PRO_JOU_ID'],$zero);
  }

  if (in_array($bonusPrognosis['PROB_FINAL2'], $tabFinalists)) {
    echo 'Bravo à ' . $prono['PRO_JOU_ID'] . ' : pronostique finaliste 2 correct - ' . $bonusPrognosis['PROB_FINAL2'] . ' est en finale !<br />';
    updateBonusPrognosisFinal2Pts($prono['PRO_JOU_ID'],$ptsFinalist);
  } else {
    updateBonusPrognosisFinal2Pts($prono['PRO_JOU_ID'],$zero);
  }
}


//********************************
// CONTROLE DU VAINQUEUR
//********************************
//if ($_POST['Round'] == 'FINALE') {
if ($level == 'FINALE') {
  echo 'Level=' . $level . ' <br />';

	if ($_POST['VouD'] == 'V') {
		$tournamentWinner = $_POST['Player1'];
	}
	else {
		$tournamentWinner = $_POST['Player2'];
	}

	// echo 'Le vainqueur du tournoi est : ' . $tournamentWinner . '<br />';

	$bonusPrognosis = getBonusPrognosis($prono['PRO_JOU_ID']);

	echo $prono['PRO_JOU_ID'] . ' a choisit comme vainqueur: ' . $bonusPrognosis['PROB_VQR'] . '.<br />';

	if ($bonusPrognosis['PROB_VQR'] == $tournamentWinner) {
    echo 'Bravo à ' . $prono['PRO_JOU_ID'] . ' : pronostique vainqueur correct - ' . $tournamentWinner . ' a gagné le tournoi !<br />';
    updateBonusPrognosisWinnerPts($prono['PRO_JOU_ID'],$ptsWinner);
	}
	else {
		updateBonusPrognosisWinnerPts($prono['PRO_JOU_ID'],$zero);
	}
}

//********************************
// CONTROLE DES FRANCAIS
//********************************
//if ($_POST['Round'] == 'FINALE') {
//echo 'Level=' . $level . '.<br />';

// On regarde si il a des français encore en course
// Peu importe les résultats, ou si le match a été joué ou pas, on regarde juste si il a encore des français
$frenchLeft = getFrenchLeft($level);

$nbRow = $req->rowcount();

// Si le retour est nul, pas besoin de tester le bonus, il a déjà été attribué, tous les français ont été éliminés
if ($nbRow != 0) {

	echo 'Encore des français en course à ce stade (' . $level . ').<br />';

  // Recherche pour savoir si tous les matchs des français ont été saisis
  $request = getFrenchResultEntered($level);
  $nbRow = $request->rowcount();

  // Si le retour est nul, tous les matchs des français ont été saisis pour ce tour
  // On peut regarder les résultats
  if ($nbRow == 0) {

    echo 'Tous les résultas des français ont été saisis. Voyons si on peut affecter les bonus FR<br />';

    $iTab = 0;
    $nbVictoire = 0;
    $nbDefaite = 0;
    $fra = "(fra)";
    $tabBestFrench = array();

    // Recherche des résultats des matchs des français restants
    $request = getFrenchResultLevel($level);

  	while ($donnees = $request->fetch()) {

      if (strpos($donnees['RES_MATCH_JOU1'], $fra) and strpos($donnees['RES_MATCH_JOU2'], $fra) == true)
      {
          $nbVictoire++;
          $nbDefaite++;
          if ($donnees['RES_MATCH'] == 'V') {
            echo ' - ' . $donnees['RES_MATCH_JOU1'] . ' a gagné contre ' . $donnees['RES_MATCH_JOU2'] . '<br />';
            $tabBestFrench[$iTab]['FrenchPlayer'] = $donnees['RES_MATCH_JOU1'];
            $tabBestFrench[$iTab]['Tour'] = $level;
        		$tabBestFrench[$iTab]['Result'] = 'Victoire';
            $iTab++;
            $tabBestFrench[$iTab]['FrenchPlayer'] = $donnees['RES_MATCH_JOU2'];
            $tabBestFrench[$iTab]['Tour'] = $level;
        		$tabBestFrench[$iTab]['Result'] = 'Défaite';
          } else {
            echo ' - ' . $donnees['RES_MATCH_JOU2'] . ' a gagné contre ' . $donnees['RES_MATCH_JOU1'] . '<br />';
            $tabBestFrench[$iTab]['FrenchPlayer'] = $donnees['RES_MATCH_JOU2'];
            $tabBestFrench[$iTab]['Tour'] = $level;
        		$tabBestFrench[$iTab]['Result'] = 'Victoire';
            $iTab++;
            $tabBestFrench[$iTab]['FrenchPlayer'] = $donnees['RES_MATCH_JOU1'];
            $tabBestFrench[$iTab]['Tour'] = $level;
        		$tabBestFrench[$iTab]['Result'] = 'Défaite';
          }
      } else {
        if (strpos($donnees['RES_MATCH_JOU1'], $fra) == true)
        {
          if ($donnees['RES_MATCH'] == 'V') {
            $nbVictoire++;
            echo ' - ' . $donnees['RES_MATCH_JOU1'] . ' a gagné.<br />';
            $tabBestFrench[$iTab]['FrenchPlayer'] = $donnees['RES_MATCH_JOU1'];
            $tabBestFrench[$iTab]['Tour'] = $level;
        		$tabBestFrench[$iTab]['Result'] = 'Victoire';
          } else {
            $nbDefaite++;
            echo ' - ' . $donnees['RES_MATCH_JOU1'] . ' a perdu.<br />';
            $tabBestFrench[$iTab]['FrenchPlayer'] = $donnees['RES_MATCH_JOU1'];
            $tabBestFrench[$iTab]['Tour'] = $level;
        		$tabBestFrench[$iTab]['Result'] = 'Défaite';
          }
        } else { // this means player2 is french
          if ($donnees['RES_MATCH'] == 'D') {
            $nbVictoire++;
            echo ' - ' . $donnees['RES_MATCH_JOU2'] . ' a gagné.<br />';
            $tabBestFrench[$iTab]['FrenchPlayer'] = $donnees['RES_MATCH_JOU2'];
            $tabBestFrench[$iTab]['Tour'] = $level;
        		$tabBestFrench[$iTab]['Result'] = 'Victoire';
          } else {
            $nbDefaite++;
            echo ' - ' . $donnees['RES_MATCH_JOU2'] . ' a perdu.<br />';
            $tabBestFrench[$iTab]['FrenchPlayer'] = $donnees['RES_MATCH_JOU2'];
            $tabBestFrench[$iTab]['Tour'] = $level;
        		$tabBestFrench[$iTab]['Result'] = 'Défaite';
          }
        }
      }

  		$iTab++;
  	} // end of while

    echo 'Nb de victoires françaises dans ce tour: ' . $nbVictoire . '<br />';
    echo 'Nb de défaites françaises dans ce tour : ' . $nbDefaite . '<br />';

    // Affichier le tableau des français encore en lice sur ce tour
    echo '<pre>';
    print_r($tabBestFrench);
    echo '</pre>';

    if ($nbVictoire == 1) {
      echo "On peut charger en table le MEILLEUR FRANCAIS car il n'en reste plus qu'un en course. <br />";

      // On vérifie si le bonus MEILLEUR FRANCAIS n'a pas déjà été attribué
      $bonusFrNom = getBonusBestFrench();
      $nbRow = $bonusFrNom->rowcount();
      if ($nbRow == 0) {
        $i = 0;
        foreach($tabBestFrench as $bestFrench) {
          if (($i <= $iTab) and ($tabBestFrench[$i]['Result'] == 'Victoire')) {
            echo 'Tableau(' . $i . ')=' . $tabBestFrench[$i]['FrenchPlayer'] . ', ' . $tabBestFrench[$i]['Tour'] . ', ' . $tabBestFrench[$i]['Result'] . '<br />';
            echo '--> Load Bonus Best French <br />';
            loadBonusBestFrench($tabBestFrench[$i]['FrenchPlayer']);
            $i++;
          }
        }
      }
    } else {
      if ($nbVictoire == 0) {
        echo "On peut attribuer le bonus MEILLEUR FRANCAIS et NIVEAU MEILLEUR FRANCAIS car ils ont tous perdu au même niveau. <br />";
        echo "Ou alors le seul joueur encore en course a perdu. <br />";

        // On vérifie si le bonus MEILLEUR FRANCAIS n'a pas déjà été attribué
        $bonusFrNom = getBonusBestFrench();
        $nbRow = $bonusFrNom->rowcount();
        if ($nbRow == 0) {
          $i = 0;
          foreach($tabBestFrench as $bestFrench) {
            if (($i <= $iTab) and ($tabBestFrench[$i]['Result'] == 'Défaite')) {
              echo 'Tableau(' . $i . ')=' . $tabBestFrench[$i]['FrenchPlayer'] . ', ' . $tabBestFrench[$i]['Tour'] . ', ' . $tabBestFrench[$i]['Result'] . '<br />';
              echo '--> Load Bonus Best French <br />';
              loadBonusBestFrench($tabBestFrench[$i]['FrenchPlayer']);
              $i++;
            }
          }
        }

        // On vérifie si le bonus NIVEAU MEILLEUR FRANCAIS n'a pas déjà été attribué
        $bonusFrLevel = getBonusLevelBestFrench();
        $nbRow = $bonusFrLevel->rowcount();
        if ($nbRow == 0) {
          echo 'Tableau(0)=' . $tabBestFrench[0]['FrenchPlayer'] . ', ' . $tabBestFrench[0]['Tour'] . ', ' . $tabBestFrench[0]['Result'] . '<br />';
          echo '--> Load Bonus Level Best French <br />';
          loadBonusLevelBestFrench($tabBestFrench[0]['Tour']);
        }
      } else {
        echo "Pas assez d'info pour attribuer l'un ou l'autre des bonus. <br />";
      }
    }

    // Maintenant qu'on a chargé (ou pas) les bonus en table, on va lire la table des bonus pour attribuer
    // les points aux JOUEURS
    $bonusBestFrenchAffected = 'N';
    $bonusLevelBestFrenchAffected = 'N';

    // 1. Meilleur françaises
    $bonusPrognosis = getBonusPrognosis($prono['PRO_JOU_ID']);
    echo '-------------------- Bonus Frenchman - Nouveau joueur --------------------<br />';
    echo 'Pronostique pour ID ' . $prono['PRO_JOU_ID'] . ' - BestFrench = ' . $bonusPrognosis['PROB_FR_NOM'] . '<br />';
    echo 'Pronostique pour ID ' . $prono['PRO_JOU_ID'] . ' - Level BestFrench = ' . $bonusPrognosis['PROB_FR_NIV'] . '<br />';

    $bonusFrNom = getBonusBestFrench();
    while ($donnees = $bonusFrNom->fetch()) {
      if ($donnees['RESB_VALUE'] == $bonusPrognosis['PROB_FR_NOM']) {
        updateBonusPrognosisFrNomPts($prono['PRO_JOU_ID'],$ptsFrNom);
        $bonusBestFrenchAffected = 'Y';
        echo '***** ' . $ptsFrNom . ' points de bonus meilleur français pour ' . $prono['PRO_JOU_ID'] . ' *****<br />';
      }
    }
    if ($bonusBestFrenchAffected != 'Y') {
      echo '***** Zero points de bonus meilleur français pour ' . $prono['PRO_JOU_ID'] . ' *****<br />';
      updateBonusPrognosisFrNomPts($prono['PRO_JOU_ID'],$zero);
    }

    // 2. Niveau du meilleur français
    $bonusPrognosis = getBonusPrognosis($prono['PRO_JOU_ID']);
    $bonusFrNiv = getBonusLevelBestFrench();
    while ($donnees = $bonusFrNiv->fetch()) {
      if ($donnees['RESB_VALUE'] == $bonusPrognosis['PROB_FR_NIV']) {
        updateBonusPrognosisFrNivPts($prono['PRO_JOU_ID'],$ptsFrNiv);
        $bonusLevelBestFrenchAffected = 'Y';
        echo '***** ' . $ptsFrNiv . ' points de bonus niveau meilleur français pour ' . $prono['PRO_JOU_ID'] . ' *****<br />';
      }
    }
    if ($bonusLevelBestFrenchAffected != 'Y') {
      echo '***** Zero points de bonus niveau meilleur français pour ' . $prono['PRO_JOU_ID'] . ' *****<br />';
      updateBonusPrognosisFrNivPts($prono['PRO_JOU_ID'],$zero);
    }
  } else {
    echo 'Tous les résultats des français ne sont pas encore saisis. Encore des matchs en cours ou à venir pour les frenchies.<br />';
  }

} // end of if ($nbRow !=0)

//**************************************
// Update du score de tous les joueurs
// Recherche de tous les points bonus
//**************************************
// (Comme ça, le compteur bonus correpond vraiment à l'additions des points obtenus par les pronostiques bonus)
// La fonction ramène le cumul du nb de points bonus (demi + finalistes + vainqueur)
//------------------------------------------------------------------------------------------------------------------
$allPtsBonusPrognosisPlayer = getAllPtsBonusPrognosisPlayer($prono['PRO_JOU_ID']);

$nbRow = $allPtsBonusPrognosisPlayer->rowcount();

if ($nbRow > 0) {

	while ($donnees = $allPtsBonusPrognosisPlayer->fetch()){
		$jouPtsBonusDemi = $donnees['total_demi'];
    $jouPtsBonusFinalist = $donnees['total_finalist'];
    $jouPtsBonusVqr = $donnees['total_vqr'];
    $jouPtsBonusFrNom = $donnees['best_Fr'];
    $jouPtsBonusFrNiv = $donnees['level_Best_Fr'];
    echo "Joueur " . $prono['PRO_JOU_ID'] . " : Bonus Demi-finalistes = " . $jouPtsBonusDemi . "<br />";
    echo "Joueur " . $prono['PRO_JOU_ID'] . " : Bonus Finalistes = " . $jouPtsBonusFinalist . "<br />";
    echo "Joueur " . $prono['PRO_JOU_ID'] . " : Bonus Vainqueur = " . $jouPtsBonusVqr . "<br />";
    echo "Joueur " . $prono['PRO_JOU_ID'] . " : Bonus Meilleur Français = " . $jouPtsBonusFrNom . "<br />";
    echo "Joueur " . $prono['PRO_JOU_ID'] . " : Bonus Niveau Meilleur Français = " . $jouPtsBonusFrNiv . "<br />";
    // puis mise à jour de la table score joueur
    updateScoreJoueur($prono['PRO_JOU_ID'], $totJouPtsProno, $nbExactProno, $jouPtsBonusVqr, $jouPtsBonusFinalist, $jouPtsBonusDemi, $jouPtsBonusFrNom, $jouPtsBonusFrNiv);
	}
}

?>
