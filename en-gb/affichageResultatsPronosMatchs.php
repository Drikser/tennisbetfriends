<!-- Afichage de tous les résultats des joueurs -->

<h1>Player match predictions</h1>


<?php
//echo "Les résultats de la compétition :<br />";

$tabPseudo = array();
$tabPseudoProno = array();
$i = 0;
$idMatchPrecedent = '';
$nbplayers = 0;

$allPrognosis = getAllPrognosis();

while ($titre = $allPrognosis->fetch()) {
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
	$tabPseudoProno[$i]['matchId'] = $titre['PRO_MATCH_ID'];
	// $tabPseudoProno[$i]['proRes'] = $titre['PRO_RES_MATCH'];
	//change display for english version of the website
  $outputResult = ConvertResultFTE($titre['PRO_RES_MATCH']);
	$tabPseudoProno[$i]['proRes'] = $outputResult;
	$tabPseudoProno[$i]['proScore1'] = $titre['PRO_SCORE_JOU1'];
	$tabPseudoProno[$i]['proScore2'] = $titre['PRO_SCORE_JOU2'];
	$outputType = ConvertTypeResultFTE($titre['PRO_TYP_MATCH']);
	$tabPseudoProno[$i]['proTypMatch'] = $outputType;
	$tabPseudoProno[$i]['proDoublePoints'] = $titre['PRO_DBL_PTS'];
	$tabPseudoProno[$i]['proPoints'] = $titre['PRO_PTS_JOU'];
	$i++;

}

// echo '<pre>';
// print_r($tabPseudoProno);
// echo '</pre>';

?>
<table>
	<!-- <caption>Players match predictions</caption> -->
	<tr>
  	<th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
    <th colspan="4" align="center" valign="middle" class="cellule">OFFICIAL RESULTS</th>
		<th align="center" valign="middle" class="cellule"></th>
		<th colspan="<?php echo $nbplayers ?>" align="center" valign="middle">PLAYER PREDICTIONS</th>
  </tr>

  <tr>
		<th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
    <th width="150" align="center" valign="middle" class="cellule">Round</th>
    <th width="200" align="center" valign="middle" class="cellule">Player 1</th>
    <th width="100" align="center" valign="middle" class="cellule">Result</th>
    <th width="200" align="center" valign="middle" class="cellule">player 2</th>
		<th align="center" valign="middle" class="cellule"></th>
      <?php
		foreach($tabPseudo as $element) {
		?>
			<th width="150" align="center" valign="middle" class="cellule"><?php echo $element; ?></th>
		<?php
		}
        ?>

  </tr>

  <?php

  //include("affichageResultatsPronoMatchsRequete.php");
	$allPrognosis = getAllPrognosis();

	$ResMatchPoidsTourPrecedent = "";
	$colorLine = "";
	//while ($donnees = $response->fetch()) {
  while ($donnees = $allPrognosis->fetch()) {


   	if ($donnees['RES_MATCH_ID'] != $idMatchPrecedent) {

			//change display for english version of the website
			$outputRound = ConvertRoundFTE($donnees['RES_MATCH_TOUR']);
			$outputResult = ConvertResultFTE($donnees['RES_MATCH']);
			$outputType = ConvertTypeResultFTE($titre['PRO_TYP_MATCH']);

			//Classe permettant de modifier légèrement la couleur des lignes en fonction du tour
			if ($donnees['RES_MATCH_POIDS_TOUR'] !== $ResMatchPoidsTourPrecedent) {
				if ($colorLine == '' or $colorLine == 'lignenormale2') {
					$colorLine = 'lignenormale';
				} else {
					$colorLine = 'lignenormale2';
				}
			}
			$ResMatchPoidsTourPrecedent = $donnees['RES_MATCH_POIDS_TOUR'];

   		?>
    	<tr class="<?php echo $colorLine; ?>">
    		<td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="idMatch" class="form-control" id="idMatch" value= <?php echo $donnees['RES_MATCH_ID']; ?> required="required"></td>
            <!-- <td align="center" valign="middle" class="cellule"><b><?php echo $donnees['RES_MATCH_TOUR']; ?></b></td> -->
						<td align="center" valign="middle" class="cellule"><b><?php echo $outputRound; ?></b></td>
            <td align="center" valign="middle" class="cellule"><b><?php echo $donnees['RES_MATCH_JOU1']; ?></b></td>
            <!-- <td align="center" valign="middle" class="cellule"><b><?php echo $donnees['RES_MATCH'] . " " . $donnees['RES_MATCH_SCR_JOU1'] . "/" . $donnees['RES_MATCH_SCR_JOU2'] . " " . $donnees['RES_MATCH_TYP']; ?></b></td> -->
						<td align="center" valign="middle" class="cellule"><b><?php echo $outputResult . " " . $donnees['RES_MATCH_SCR_JOU1'] . "/" . $donnees['RES_MATCH_SCR_JOU2'] . " " . $outputType; ?></b></td>
            <td align="center" valign="middle" class="cellule"><b><?php echo $donnees['RES_MATCH_JOU2']; ?></b></td>
						<th align="center" valign="middle" class="cellule"></th>
            <?php
            $i = 0;
            foreach($tabPseudoProno as $prono) {
            	if ($tabPseudoProno[$i]['matchId'] == $donnees['RES_MATCH_ID']) {
								if ($tabPseudoProno[$i]['proDoublePoints'] == 2) {
						?>
									<td align="center" valign="middle" class="cellule"><?php echo "&#9733 " . $tabPseudoProno[$i]['proRes'] . " " . $tabPseudoProno[$i]['proScore1'] . "/" . $tabPseudoProno[$i]['proScore2'] . " " . $tabPseudoProno[$i]['proTypMatch'] . " (" . $tabPseudoProno[$i]['proPoints'] . "pts)"; ?></td>
						<?php
									} else {
						?>
									<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['proRes'] . " " . $tabPseudoProno[$i]['proScore1'] . "/" . $tabPseudoProno[$i]['proScore2'] . " " . $tabPseudoProno[$i]['proTypMatch'] . " (" . $tabPseudoProno[$i]['proPoints'] . "pts)"; ?></td>
						<?php
									}
								}
								$i++;
							}
    		?>
        </tr>

    	<?php
    	$idMatchPrecedent = $donnees['RES_MATCH_ID'];
      }
		}
    ?>

   </table>

   <?php
//$response->closeCursor();
?>
