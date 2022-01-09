<!-- Afichage de tous les résultats des joueurs -->

<h1>Players bonus predictions</h1>


<?php
$tabPseudo = array();
$tabPseudoProno = array();
$tabBestFrench = array();
$i = 0;
$iTab = 0;
$idMatchPrecedent = '';
$nbplayers = 0;
$Winner = "";
$Finalist1 = "";
$Finalist2 = "";
$Semi1 = "";
$Semi2 = "";
$Semi3 = "";
$Semi4 = "";
$BestFrench = "";
$BestFrenchLevel = "";

// Renseigner un tableau contenant tous les pseudo des joueurs
// ==> Pour affichage dynamique des pseudo dans les titres du tableau
//$reqPseudo = $bdd->query('SELECT JOU_PSE
//                          FROM joueur
//                         WHERE JOU_PSE != "Admin"
//                      ORDER BY JOU_PSE ASC');

//while ($titre = $reqPseudo->fetch()) {

//  $tabPseudo[] = $titre['JOU_PSE'];
//  echo $titre['JOU_PSE'] . '<br />';
//}


//Sélection des pronostiques effectués par le joueur :

//include("affichageResultatsPronoMatchsRequete.php");
//include("../commun/model.php");
$allBonus = getAllBonus();

while ($titre = $allBonus->fetch()) {
//while ($titre = $response->fetch()) {

	// TABLEAU DES PSEUDO POUR LES TITRES
	if (!in_array($titre['JOU_PSE'], $tabPseudo)) {
		$tabPseudo[] = $titre['JOU_PSE'];
	//	echo $titre['JOU_PSE'] . ' = nouveau<br />';
	}
	$nbplayers = count($titre);

	// TABLEAU DES PRONOS POUR REMPLISSAGE DE TOUS LES PRONOS
	$tabPseudoProno[$i]['jouId'] = $titre['JOU_ID'];
	$tabPseudoProno[$i]['jouPse'] = $titre['JOU_PSE'];
	$tabPseudoProno[$i]['winner'] = $titre['PROB_VQR'];
	$tabPseudoProno[$i]['winner-pts'] = $titre['PROB_VQR_PTS'] . "pts";
	$tabPseudoProno[$i]['finalist1'] = $titre['PROB_FINAL1'];
	$tabPseudoProno[$i]['finalist1-pts'] = $titre['PROB_FINAL1_PTS'] . "pts";
	$tabPseudoProno[$i]['finalist2'] = $titre['PROB_FINAL2'];
	$tabPseudoProno[$i]['finalist2-pts'] = $titre['PROB_FINAL2_PTS'] . "pts";
	$tabPseudoProno[$i]['semiFinalist1'] = $titre['PROB_DEMI1'];
	$tabPseudoProno[$i]['semiFinalist1-pts'] = $titre['PROB_DEMI1_PTS'] . "pts";
	$tabPseudoProno[$i]['semiFinalist2'] = $titre['PROB_DEMI2'];
	$tabPseudoProno[$i]['semiFinalist2-pts'] = $titre['PROB_DEMI2_PTS'] . "pts";
  $tabPseudoProno[$i]['semiFinalist3'] = $titre['PROB_DEMI3'];
	$tabPseudoProno[$i]['semiFinalist3-pts'] = $titre['PROB_DEMI3_PTS'] . "pts";
	$tabPseudoProno[$i]['semiFinalist4'] = $titre['PROB_DEMI4'];
	$tabPseudoProno[$i]['semiFinalist4-pts'] = $titre['PROB_DEMI4_PTS'] . "pts";
	$tabPseudoProno[$i]['bestFrench'] = $titre['PROB_FR_NOM'];
	$tabPseudoProno[$i]['bestFrench-pts'] = $titre['PROB_FR_NOM_PTS'] . "pts";
	$outputRound = ConvertRoundFTE($titre['PROB_FR_NIV']);
	$tabPseudoProno[$i]['bestFrenchLevel'] = $outputRound;
	$tabPseudoProno[$i]['bestFrenchLevel-pts'] = $titre['PROB_FR_NIV_PTS'] . "pts";
	$i++;
}

//echo '<pre>';
//print_r($tabPseudoProno);
//echo '</pre>';

?>

<table>
	<!-- <caption>Players bonus predictions</caption> -->
	<tr>
  	<th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
    <th colspan="2" align="center" valign="middle">OFFICIAL RESULT</th>
		<th align="center" valign="middle"></th>
		<th colspan="<?php echo $nbplayers ?>" align="center" valign="middle">PLAYERS PREDICTIONS</th>
  </tr>

  <tr>
		<th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
		<th width="150" align="center" valign="middle" class="cellule">ROUND</th>
		<th width="190" align="center" valign="middle" class="cellule">NAME</th>
		<th align="center" valign="middle" class="cellule"></th>
    <?php
		foreach($tabPseudo as $element) {
		?>
			<th colspan="2" width="200" align="center" valign="middle" class="cellule"><?php echo $element; ?></th>
		<?php
		}
		?>
  </tr>

	<?php
	//Recherche des matchs finale et demi-finale dans la table des résultats
	//poids 1 = finale
	//poids 2 = demi-finales
	//--> Les demi-finalsites sont player1 et player2 pour les 2 matchs dont le poids est 2
	//--> Les finalistes sont les joueurs player1 et player2 du match dont le poids est 1
	//--> Le vainqueur est le vainqueur du match dont le poids est 1
	$allSemisAndFinalists = getSemisAndFinalists();
	//$allFinalists = getFinalists();

	//while ($donnees = $response->fetch()) {
	while ($donnees = $allSemisAndFinalists->fetch()) {

		if ($donnees['RES_MATCH_POIDS_TOUR'] == 1) {
			$Finalist1 = $donnees['RES_MATCH_JOU1'];
			$Finalist2 = $donnees['RES_MATCH_JOU2'];

			if ($donnees['RES_MATCH'] == 'V') {
				$Winner = $donnees['RES_MATCH_JOU1'];
			}

			if ($donnees['RES_MATCH'] == 'D') {
				$Winner = $donnees['RES_MATCH_JOU2'];
			}
		}

		if ($donnees['RES_MATCH_POIDS_TOUR'] == 2) {
			if ($Semi1 == "" and $Semi2 == "") {
				$Semi1 = $donnees['RES_MATCH_JOU1'];
				$Semi2 = $donnees['RES_MATCH_JOU2'];
			} else {
				$Semi3 = $donnees['RES_MATCH_JOU1'];
				$Semi4 = $donnees['RES_MATCH_JOU2'];
			}
		}
	}

	$iTab = 0;
	$bonusFrNom = getBonusBestFrench();
	while ($donnees = $bonusFrNom->fetch()) {
		$tabBestFrench[$iTab] = $donnees['RESB_VALUE'];
		$BestFrench = 'Y';
		$iTab++;
	}
	echo '<pre>';
	print_r($tabBestFrench);
	echo '</pre>';

	$bonusFrNiv = getBonusLevelBestFrench();
	while ($donnees = $bonusFrNiv->fetch()) {
		$outputRound = ConvertRoundFTE($donnees['RESB_VALUE']);
		$BestFrenchLevel = $outputRound;
		// $BestFrenchLevel = $donnees['RESB_VALUE'];
	}

	//echo "Après chargement variables<br />";
	//echo "Vainqueur        = "	. $Winner . "<br />";
	//echo "Finaliste 1      = "	. $Finalist1 . "<br />";
	//echo "Finaliste 2      = "	. $Finalist2 . "<br />";
	//echo "Demi-Finaliste 1 = "	. $Semi1 . "<br />";
	//echo "Demi-Finaliste 2 = "	. $Semi2 . "<br />";
	//echo "Demi-Finaliste 3 = "	. $Semi3 . "<br />";
	//echo "Demi-Finaliste 4 = "	. $Semi4 . "<br />";

	// Affichage des pronostiques bonnus des vainqueurs si vainqueur du tournoi connu
	//---------------------------------------------------------------------------------

	if ($Winner != "") {
		?>
		<tr>
			<td align="center" valign="middle" class="cellule"><b>WINNER</b></td>
			<td align="center" valign="middle" class="cellule"><b><?php echo $Winner; ?><b></td>
			<td align="center" valign="middle" class="cellule"></td>
			<?php
			$i = 0;
			foreach($tabPseudoProno as $prono) {
			 ?>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['winner']; ?></td>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['winner-pts']; ?></td>
			<?php
			$i++;
			}
		 ?>
		 </tr>
		 <?php
	}

	// Affichage des pronostiques bonnus des vainqueurs si vainqueur du tournoi connu
	//---------------------------------------------------------------------------------

	if ($Finalist1 != "" AND $Finalist2 != "") {
		?>
		<tr class="<?php echo 'lignenormale2'; ?>">
			<td rowspan="2" align="center" valign="middle" class="cellule"><b>FINALISTS</b></td>
			<td align="center" valign="middle" class="cellule"><b><?php echo $Finalist1; ?></b></td>
			<td align="center" valign="middle" class="cellule"></td>
			<?php
			$i = 0;
			foreach($tabPseudoProno as $prono) {
			?>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['finalist1']; ?></td>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['finalist1-pts']; ?></td>
			<?php
			$i++;
			}
		 	?>
		 </tr>

		 <tr class="<?php echo 'lignenormale2'; ?>">
 			<td align="center" valign="middle" class="cellule"><b><?php echo $Finalist2; ?></b></td>
			<td align="center" valign="middle" class="cellule"></td>
 			<?php
 			$i = 0;
 			foreach($tabPseudoProno as $prono) {
 			?>
 				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['finalist2']; ?></td>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['finalist2-pts']; ?></td>
 			<?php
 			$i++;
 			}
 		 	?>
 		 </tr>

		 <?php
	}

	// Affichage des pronostiques bonnus des demi-fnales si demi-finalistes du tournoi connus
	//----------------------------------------------------------------------------------------
	if ($Semi1 != "" AND $Semi2 != "" AND $Semi3 != "" AND $Semi4 != "") {
		?>
		<tr>
			<td rowspan="4" align="center" valign="middle" class="cellule"><b>SEMI-FINALISTS</b></td>
			<td align="center" valign="middle" class="cellule"><b><?php echo $Semi1; ?></b></td>
			<td align="center" valign="middle" class="cellule"></td>
			<?php
			$i = 0;
			foreach($tabPseudoProno as $prono) {
			 ?>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['semiFinalist1']; ?></td>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['semiFinalist1-pts']; ?></td>
			<?php
			$i++;
			}
		 ?>
		</tr>

		<tr>
			<td align="center" valign="middle" class="cellule"><b><?php echo $Semi2; ?></b></td>
			<td align="center" valign="middle" class="cellule"></td>
			<?php
			$i = 0;
			foreach($tabPseudoProno as $prono) {
			?>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['semiFinalist2']; ?></td>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['semiFinalist2-pts']; ?></td>
			<?php
			$i++;
			}
		 	?>
		</tr>

		<tr>
			<td align="center" valign="middle" class="cellule"><b><?php echo $Semi3; ?></b></td>
			<td align="center" valign="middle" class="cellule"></td>
			<?php
			$i = 0;
			foreach($tabPseudoProno as $prono) {
			?>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['semiFinalist3']; ?></td>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['semiFinalist3-pts']; ?></td>
			<?php
			$i++;
			}
		 	?>
		</tr>

		<tr>
			<td align="center" valign="middle" class="cellule"><b><?php echo $Semi4; ?></b></td>
			<td align="center" valign="middle" class="cellule"></td>
			<?php
			$i = 0;
			foreach($tabPseudoProno as $prono) {
			?>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['semiFinalist4']; ?></td>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['semiFinalist4-pts']; ?></td>
			<?php
			$i++;
			}
		 ?>
		 </tr>

	<?php
	}

	// Affichage des pronostiques bonus des meilleurs français choisis si meilleur français connu
	//---------------------------------------------------------------------------------------------

	if ($BestFrench != "") {
		?>
		<tr class="<?php echo 'lignenormale2'; ?>">
			<td align="center" valign="middle" class="cellule"><b>BEST FRENCHMAN</b></td>
			<td align="center" valign="middle" class="cellule"><b>
				<?php
				$i = 0;
				foreach($tabBestFrench as $bestFrench) {
					if ($i <= $iTab) {
						echo $tabBestFrench[$i] . '<br />';
						$i++;
					}
				}
				?>
				<b>
			</td>
			<td align="center" valign="middle" class="cellule"></td>
			<?php
			$i = 0;
			foreach($tabPseudoProno as $prono) {
			 ?>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['bestFrench']; ?></td>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['bestFrench-pts']; ?></td>
			<?php
			$i++;
			}
		 ?>
		 </tr>
		 <?php
	}

	// Affichage des pronostiques bonus du niveau des meilleurs français choisis
	//----------------------------------------------------------------------------
	if ($BestFrenchLevel != "") {
		?>
		<tr>
			<td align="center" valign="middle" class="cellule"><b>LEVEL BEST FRENCHMAN</b></td>
			<td align="center" valign="middle" class="cellule"><b><?php echo $BestFrenchLevel; ?><b></td>
			<td align="center" valign="middle" class="cellule"></td>
			<?php
			$i = 0;
			foreach($tabPseudoProno as $prono) {
			 	?>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['bestFrenchLevel']; ?></td>
				<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['bestFrenchLevel-pts']; ?></td>
			<?php
			$i++;
			}
		 ?>
		 </tr>
		 <?php
	}





	?>

</table>

   <?php
//$response->closeCursor();
?>
