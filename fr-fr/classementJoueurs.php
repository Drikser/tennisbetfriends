
<h1>Classement général</h1>

<?php
//echo "Le classement des joueurs :<br />";

//Recherche si c'est la fin du tournoi (le score de la finale est renseigné)
$endTournament = false;
$resultFinal = getFinalists();
while ($donnees = $resultFinal->fetch()) {
	if ($donnees['RES_MATCH'] != '') {
		$endTournament = true;
	}
}

$NbPlayersContest = 0;
$classement = 1;
$rowcount = getPlayersContest();
$donnees = $rowcount->fetch();
$NbPlayersContest = $donnees['NbPlayersContest'];

$table = getTable();

?>

<table>
	<tr>
		<th align="center" valign="middle" class="cellule">Clst</th>
		<th align="center" valign="middle" class="cellule">Pseudo</th>
		<th align="center" valign="middle" class="cellule">Total points</th>
		<th align="center" valign="middle" class="cellule"></th>
		<th align="center" valign="middle" class="cellule">Points pronostiques<br />(Dont nb prono exacts)</th>
		<th align="center" valign="middle" class="cellule">Bonus Meilleur Français</th>
		<th align="center" valign="middle" class="cellule">Bonus Niveau meilleur Français</th>
		<th align="center" valign="middle" class="cellule">Bonus Demi-finalistes</th>
		<th align="center" valign="middle" class="cellule">Bonus Finalistes</th>
		<th align="center" valign="middle" class="cellule">Bonus Vainqueur</th>
		<!-- <th align="center" valign="middle" class="cellule">Bonus Meilleur Français</th>
		<th align="center" valign="middle" class="cellule">Bonus Niveau meilleur Français</th> -->
	</tr>
	<?php
	//while ($donnees = $reponse->fetch()) {
	while ($donnees = $table->fetch()) {
		?>


		<?php
		//Classe permettant de surligner la ligne qui correspond au pseudo du joueur
		$surlignage=$donnees['JOU_PSE'] !== $_SESSION['JOU_PSE'] ? 'lignenormale' : 'lignecoloree';
		//echo $donnees['JOU_PSE'] . ' / ' . $_SESSION['JOU_PSE'] . ' / ' . $surlignage . '<br />';
		?>

		<!-- Tableau avec la classe $surlignage : le joueur verra sa ligne surlignée pour se repérer plus facilement -->
		<tr class="<?php echo $surlignage; ?>">
			<?php
			if ($endTournament) {
				if ($classement == 1) {
					?>
					<!-- <td align="right" valign="middle"><span class="clignote" <i> Winner </i></span><img src="../images/winnerRolandGarros-resized2.png" ></td> -->
					<!-- <td align="right" valign="middle"><span class="clignote"> <i> Winner </i></span></td> -->
					<td align="right" valign="middle" class="cellule"><i> Winner </i></td>
					<?php
				} elseif ($classement == $NbPlayersContest) {
					?>
					<!-- <td align="right" valign="middle"><i> Loser </i><img src="../images/loser6-resized2.png" ></td> -->
					<!-- <td align="right" valign="middle"><span class="clignote"><i> Loser </i></span></td> -->
					<td align="right" valign="middle" class="cellule"><i> Loser </i></td>
					<?php
				} else {
					?>
					<td align="right" valign="middle" class="cellule"><?php echo $classement; ?></td>
					<?php
				}
				?>

			<?php
			} else {
			?>
				<td align="right" valign="middle" class="cellule"><?php echo $classement; ?></td>
			<?php
			}
			?>
			<td align="center" valign="middle" class="cellule"><?php echo $donnees['JOU_PSE']; ?></td>
			<td align="center" valign="middle" class="cellule"><?php echo '<b>' . $donnees['JOU_TOT_PTS'] . '</b>'; ?></td>
			<th align="center" valign="middle" class="cellule"></th>
			<td align="center" valign="middle" class="cellule"><?php echo $donnees['JOU_PTS_PRONO'] . " (" . $donnees['JOU_NB_RES_OK'] . ")"; ?></td>
			<td align="center" valign="middle" class="cellule"><?php echo $donnees['JOU_BONUS_FR_NOM']; ?></td>
			<td align="center" valign="middle" class="cellule"><?php echo $donnees['JOU_BONUS_FR_NIV']; ?></td>
			<td align="center" valign="middle" class="cellule"><?php echo $donnees['JOU_BONUS_DF']; ?></td>
			<td align="center" valign="middle" class="cellule"><?php echo $donnees['JOU_BONUS_FINAL']; ?></td>
			<td align="center" valign="middle" class="cellule"><?php echo $donnees['JOU_BONUS_VQR']; ?></td>
			<!-- <td align="center" valign="middle" class="cellule"><?php echo $donnees['JOU_BONUS_FR_NOM']; ?></td>
			<td align="center" valign="middle" class="cellule"><?php echo $donnees['JOU_BONUS_FR_NIV']; ?></td> -->
		</tr>

		<?php

		$classement++;
	}
	?>
</table>

	<?php
	//	echo $classement . ' # ' . $donnees['JOU_PSE'] . ' : ' . $donnees['JOU_NB_PTS'] . ' (' . $donnees['JOU_NB_RES_OK'] . ')<br />';
		$classement++;
	//$reponse->closeCursor();
?>
