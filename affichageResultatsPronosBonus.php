<!-- Afichage de tous les résultats des joueurs -->

<h1>Récap pronostiques bonus des joueurs</h1>


<?php
echo "Les pronostiques bonus :<br />";

$tabPseudo = array();
$tabPseudoProno = array();
$i = 0;
$idMatchPrecedent = '';
$nbplayers = 0;

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
//include("model.php");
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
	$tabPseudoProno[$i]['finalist1'] = $titre['PROB_FINAL1'];
	$tabPseudoProno[$i]['finalist2'] = $titre['PROB_FINAL2'];
	$tabPseudoProno[$i]['semiFinalist1'] = $titre['PROB_DEMI1'];
    $tabPseudoProno[$i]['semiFinalist2'] = $titre['PROB_DEMI2'];
    $tabPseudoProno[$i]['semiFinalist3'] = $titre['PROB_DEMI3'];
	$tabPseudoProno[$i]['semiFinalist4'] = $titre['PROB_DEMI4'];
	$i++;

}

echo '<pre>';
print_r($tabPseudoProno);
echo '</pre>';

?>


<table>
	<tr>
    	<th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
        <th colspan="2" align="center" valign="middle">RESULTAT OFFICIEL</th>
		<th colspan="<?php echo $nbplayers ?>" align="center" valign="middle">PRONOSTIQUES JOUEURS</th>
    </tr>

    <tr>
    	<th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
        <th width="150" align="center" valign="middle" class="cellule">Niveau</th>
        <th width="150" align="center" valign="middle" class="cellule">Nom du joueur</th>
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
	$allPrognosis = getAllBonus();

	//while ($donnees = $response->fetch()) {
    while ($donnees = $allPrognosis->fetch()) {

       	if ($donnees['RES_MATCH_ID'] != $idMatchPrecedent) {
       		?>
        	<tr>
        		<td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="idMatch" class="form-control" id="idMatch" value= <?php echo $donnees['RES_MATCH_ID']; ?> required="required"></td>
                <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_TOURNOI']; ?></td>
                <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
                <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH'] . " " . $donnees['RES_MATCH_SCR_JOU1'] . "/" . $donnees['RES_MATCH_SCR_JOU2'] . " " . $donnees['RES_MATCH_TYP']; ?></td>
                <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                <?php
                $i = 0;
                foreach($tabPseudoProno as $prono) {
                	if ($tabPseudoProno[$i]['matchId'] == $donnees['RES_MATCH_ID']) {
					?>
						<td align="center" valign="middle" class="cellule"><?php echo $tabPseudoProno[$i]['proRes'] . " " . $tabPseudoProno[$i]['proScore1'] . "/" . $tabPseudoProno[$i]['proScore2'] . " " . $tabPseudoProno[$i]['proTypMatch'] . " (" . $tabPseudoProno[$i]['proPoints'] . "pts)"; ?></td>
					<?php
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
