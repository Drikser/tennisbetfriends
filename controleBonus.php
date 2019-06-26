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
echo 'Level=' . $level . '.<br />';

if ($level == 'QUART DE FINALE') {
	if ($_POST['VouD'] == 'V') {
		$semiFinalist = $_POST['Player1'];
	}
	else {
		$semiFinalist = $_POST['Player2'];
	}

	echo $semiFinalist . ' est en demi-finale<br />';

	$bonusPrognosis = getBonusPrognosis($prono['PRO_JOU_ID']);
	//$bonusPrognosis = getPronostique_Bonus($_SESSION['JOU_ID']);
	//$req = getBonusPrognosis($prono['PRO_JOU_ID']);
	//$req = getPronostique_Bonus($prono['PRO_JOU_ID']);

	//echo $prono['PRO_JOU_ID'] . ' a choisit comme demi-finalistes: ' . $bonusPrognosis['PROB_DEMI1'] . ', ' . $bonusPrognosis['PROB_DEMI2'] . ', ' . $bonusPrognosis['PROB_DEMI3'] . ', ' . $bonusPrognosis['PROB_DEMI4'] . '.<br />';

	if ($bonusPrognosis['PROB_DEMI1'] == $semiFinalist
	or  $bonusPrognosis['PROB_DEMI2'] == $semiFinalist
	or  $bonusPrognosis['PROB_DEMI3'] == $semiFinalist
	or  $bonusPrognosis['PROB_DEMI4'] == $semiFinalist) {

		echo 'Bravo ' . $prono['PRO_JOU_ID'] . ', tu as trouvé que ' . $semiFinalist . ' serait en demi-finale !<br />';

		// $totJouPtsProno et $nbExactProno sont les valeurs qui ont été calculées dans la page controleResultat

		updateScoreJoueur($prono['PRO_JOU_ID'], $totJouPtsProno, $nbExactProno, $zero, $zero, $ptsSemi, $zero, $zero);
		//updateScoreJoueur($prono['PRO_JOU_ID'], $zero, $zero, $zero, $ptsSemi, $zero, $zero);
	}
	else {
		updateScoreJoueur($prono['PRO_JOU_ID'], $totJouPtsProno, $nbExactProno, $zero, $zero, $zero, $zero, $zero);
	}

}

//***************************
// CONTROLE DES FINALISTES
//***************************
echo 'Level=' . $level . '.<br />';

if ($level == 'DEMI-FINALE') {
	if ($_POST['VouD'] == 'V') {
		$finalist = $_POST['Player1'];
	}
	else {
		$finalist = $_POST['Player2'];
	}

	echo $finalist . ' est en finale<br />';

	$bonusPrognosis = getBonusPrognosis($prono['PRO_JOU_ID']);
	//$bonusPrognosis = getPronostique_Bonus($_SESSION['JOU_ID']);
	//$req = getBonusPrognosis($prono['PRO_JOU_ID']);
	//$req = getPronostique_Bonus($prono['PRO_JOU_ID']);

	//echo $prono['PRO_JOU_ID'] . ' a choisit comme finalistes: ' . $bonusPrognosis['PROB_FINAL1'] . ', ' . $bonusPrognosis['PROB_FINAL2'] . '.<br />';

	if ($bonusPrognosis['PROB_FINAL1'] == $finalist
	or  $bonusPrognosis['PROB_FINAL2'] == $finalist) {

		echo 'Bravo ' . $prono['PRO_JOU_ID'] . ', tu as trouvé que ' . $finalist . ' serait en finale !<br />';

		updateScoreJoueur($prono['PRO_JOU_ID'], $totJouPtsProno, $nbExactProno, $zero, $ptsFinalist, $zero, $zero, $zero);
		//updateScoreJoueur($prono['PRO_JOU_ID'], $zero, $zero, $zero, $ptsSemi, $zero, $zero);
	}
	else {
		updateScoreJoueur($prono['PRO_JOU_ID'], $totJouPtsProno, $nbExactProno, $zero, $zero, $zero, $zero, $zero);
	}

}


//********************************
// CONTROLE DU VAINQUEUR
//********************************
//if ($_POST['Round'] == 'FINALE') {
if ($level == 'FINALE') {
	if ($_POST['VouD'] == 'V') {
		$tournamentWinner = $_POST['Player1'];
	}
	else {
		$tournamentWinner = $_POST['Player2'];
	}

	echo 'Le vainqueur du tournoi est : ' . $tournamentWinner . '<br />';

	$bonusPrognosis = getBonusPrognosis($prono['PRO_JOU_ID']);

	echo $prono['PRO_JOU_ID'] . ' a choisit comme vainqueur: ' . $bonusPrognosis['PROB_VQR'] . '.<br />';

	if ($bonusPrognosis['PROB_VQR'] == $tournamentWinner) {

		//echo 'Bravo ' . $prono['PRO_JOU_ID'] . ', a trouvé que ' . $tournamentWinner . ' gagnerait le tournoi !<br />';

		// $totJouPtsProno et $nbExactProno sont les valeurs qui ont été calculées dans la page controleResultat

		updateScoreJoueur($prono['PRO_JOU_ID'], $totJouPtsProno, $nbExactProno, $ptsWinner, $zero, $zero, $zero, $zero);
		//updateScoreJoueur($prono['PRO_JOU_ID'], $ptsWinner, $zero, $zero, $zero);
	}
	else {
		updateScoreJoueur($prono['PRO_JOU_ID'], $totJouPtsProno, $nbExactProno, $zero, $zero, $zero, $zero, $zero);
	}

}


//------------------------------------------------------------
// 03/03/2019: FONCTIONNALITE CONTROLE DES FRANCIAS EN SUSPEND
//------------------------------------------------------------

/*
// DEBUT COMMENTAGE

//********************************
// CONTROLE DES FRANCAIS
//********************************
//if ($_POST['Round'] == 'FINALE') {
//echo 'Level=' . $level . '.<br />';

// Requête pour savoir si tous les matchs du tour sont saisis
//echo 'Recherche si les matchs du niveau ' . $level . ' sont tous terminés.<br />';
$request = getResultLevel($level);

// Si le retour est nul, on peut tester le bonus
$nbRow = $request->rowcount();

echo '$nbRow=' . $nbRow . '<br />';


if ($nbRow == 0) {

	echo 'Tous les matchs du niveau ' . $level . ' sont terminés --> Recherche si il y a encore des français en liste.<br />';

	// On regarde si il a des français en course
	$frenchLeft = getFrenchLeft($level);

	// On va chercher si le français a gagné ou perdu
	// - Si tous les français ont perdus ==> Bonus Niveau et Meilleur français

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

// FIN COMMENTAGE
*/

?>
