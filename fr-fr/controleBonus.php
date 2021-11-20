 <?php

include("baremes.php");


$tournamentWinner = '';
$finalist = '';
$semiFinalist = '';
$tabFrench = array();



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

  echo '<pre>';
  print_r($tabSemiFinalists);
  echo '</pre>';


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

  echo '<pre>';
  print_r($tabFinalists);
  echo '</pre>';


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

// Recherche de tous les points bonus
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
    echo "Joueur " . $prono['PRO_JOU_ID'] . " : Bonus Demi-finalistes = " . $jouPtsBonusDemi . "<br />";
    echo "Joueur " . $prono['PRO_JOU_ID'] . " : Bonus Finalistes = " . $jouPtsBonusFinalist . "<br />";
    echo "Joueur " . $prono['PRO_JOU_ID'] . " : Bonus Vainqueur = " . $jouPtsBonusVqr . "<br />";
    // puis mise à jour de la table score joueur
    updateScoreJoueur($prono['PRO_JOU_ID'], $totJouPtsProno, $nbExactProno, $jouPtsBonusVqr, $jouPtsBonusFinalist, $jouPtsBonusDemi, $zero, $zero);
	}
}

//------------------------------------------------------------
// 03/03/2019: FONCTIONNALITE CONTROLE DES FRANCAIS EN SUSPEND
//------------------------------------------------------------

//********************************
// CONTROLE DES FRANCAIS
//********************************
//if ($_POST['Round'] == 'FINALE') {
//echo 'Level=' . $level . '.<br />';

// Requête pour savoir si tous les matchs du tour sont saisis
//echo 'Recherche si les matchs du niveau ' . $level . ' sont tous terminés.<br />';
$request = getFrenchResultLevel($level);

// Si le retour est nul, on peut tester le bonus
$nbRow = $request->rowcount();

echo '$nbRow=' . $nbRow . '<br />';


if ($nbRow == 0) {

	echo 'Tous les matchs du niveau ' . $level . ' sont terminés --> Recherche si il y a encore des français en liste.<br />';

	// On regarde si il a des français en course
	// $frenchLeft = getFrenchLeft($level);

	// On va chercher si le français a gagné ou perdu
	// - Si tous les français ont perdus ==> Bonus Niveau et Meilleur français

  $i = 0;
	while ($french = $frenchLeft->fetch()) {
		//while ($titre = $response->fetch()) {

		// TABLEAU DES FRANCAIS ENCORE EN COURSE
		$tabFrench[$i]['Player1'] = $french['RES_MATCH_JOU1'];
		$tabFrench[$i]['Result'] = $french['RES_MATCH'];
		$tabFrench[$i]['Player2'] = $french['RES_MATCH_JOU2'];
		$i++;
	}

	echo '<pre>';
	print_r($tabFrench);
	echo '</pre>';

} else {
	echo 'Il reste encore des match à finir pour le niveau ' . $level . '.<br />';
}


?>
