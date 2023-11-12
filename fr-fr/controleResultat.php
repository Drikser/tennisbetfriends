 <?php
 // affichage des pronostiques des joueurs :
 echo "idJoueur=" . $prono['PRO_JOU_ID'] . " Résultat=" . $prono['PRO_RES_MATCH'] . " " . $prono['PRO_SCORE_JOU1'] . "/" . $prono['PRO_SCORE_JOU2'] . "<br />";

include("baremes.php");

$ptsPrognosis = 0;
$nbPrognosisOK = 0;
$nbExactProno = 0;
$jouPtsProno = 0;
$totJouPtsProno = 0;

//********************************
// CONTROLE DU MATCH
//********************************

if ($prono['PRO_RES_MATCH'] == $_POST['VouD']) {

	if ($prono['PRO_SCORE_JOU1']==$_POST['ScoreJ1'] AND
        $prono['PRO_SCORE_JOU2']==$_POST['ScoreJ2'] AND
    	$prono['PRO_TYP_MATCH']==$_POST['TypeMatch']) {

		// RESULTAT OK ET SCORE EXACT
		// $ptsPrognosis = $ptsExactPrognosis;
    $ptsPrognosis = $ptsExactPrognosis * $prono['PRO_DBL_PTS'];
		//$nbPrognosisOK = $one;
	}
	else {

		// RESULTAT OK MAIS PAS LE SCORE EXACT
    // $ptsPrognosis = $ptsGoodPrognosis;
		$ptsPrognosis = $ptsGoodPrognosis * $prono['PRO_DBL_PTS'];
		//$nbPrognosisOK = $zero;
	}

}
//case ($prono['PRO_RES_MATCH'] != $_POST['VouD']) :
else {

		// RESULTAT PAS BON
		$ptsPrognosis = $ptsBadPrognosis;
		//$nbPrognosisOK = $zero;
}


//Mise a jour compteur points pronostiques dans la table pronostique
//-------------------------------------------------------------------
updateScorePronostique($prono['PRO_JOU_ID'], $prono['PRO_MATCH_ID'], $ptsPrognosis);

//Mise à jour du compteur des points pronostiques dans la table joueur, et comptage du nb de bon résultats
//(Comme ça, le compteur correpond vraiment à l'additions des points obtenus par les pronostiques de chaque match)
//La fonction ramène :
//- le total des points dûs aux pronostiques ($jouPtsProno)
//- le nb de pronstiques exacts ($nbExactProno)
//------------------------------------------------------------------------------------------------------------------
$allPtsPrognosisPlayer = getAllPtsPrognosisPlayer($prono['PRO_JOU_ID']);

$nbRow = $allPtsPrognosisPlayer->rowcount();

//echo 'nbRow=' . $nbRow . '<br />';

if ($nbRow > 0) {

	while ($donnees = $allPtsPrognosisPlayer->fetch()){

		//echo 'Point avant = ' . $jouPtsProno . ' pts<br />';

		$jouPtsProno = $jouPtsProno + $donnees['PRO_PTS_JOU'];

		//echo 'Point après = ' . $jouPtsProno . ' pts (+' . $donnees['PRO_PTS_JOU'] . ')<br />';

		if ($donnees['PRO_PTS_JOU'] == $ptsExactPrognosis){
			$nbExactProno = $nbExactProno + 1;

			// echo 'Pronostique exact.<br />';

		}
	}

	//echo 'Total des points de prono de Joueur ' . $prono['PRO_JOU_ID'] . ' = ' . $jouPtsProno . ' (dont ' . $nbExactProno . ' pronostiques exacts).';

}


$totJouPtsProno = $jouPtsProno;
$nbPrognosisOK = $nbExactProno;


//Mise à jour des autres compteurs dans la table joueur
//A partir du calcul précédent
//-------------------------------------------------------
updateScoreJoueur($prono['PRO_JOU_ID'], $totJouPtsProno, $nbExactProno, $zero, $zero, $zero, $zero, $zero);


?>
