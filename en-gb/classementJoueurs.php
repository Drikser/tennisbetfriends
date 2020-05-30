
<h1>Overall ranking</h1>

<?php
//echo "Le classement des joueurs :<br />";

$classement = 1;

$table = getTable();

?>

<table>
	<tr>
		<th align="center" valign="middle">Rnk.</th>
		<th align="center" valign="middle">Username</th>
		<th align="center" valign="middle">Total points</th>
		<th align="center" valign="middle">Prediction points<br />(including exact prediction)</th>
		<th align="center" valign="middle">Bonus Semi-finalists</th>
		<th align="center" valign="middle">Bonus Finalists</th>
		<th align="center" valign="middle">Bonus Winner</th>
<!--		<th align="center" valign="middle">Bonus Meilleur Français</th>		-->
<!--		<th align="center" valign="middle">Bonus Niveau meilleur Français</th>		-->
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
			<td align="right" valign="middle"><?php echo $classement; ?></td>
			<td align="center" valign="middle"><?php echo $donnees['JOU_PSE']; ?></td>
			<td align="center" valign="middle"><?php echo $donnees['JOU_TOT_PTS']; ?></td>
			<td align="center" valign="middle"><?php echo $donnees['JOU_PTS_PRONO'] . " (" . $donnees['JOU_NB_RES_OK'] . ")"; ?></td>
			<td align="center" valign="middle"><?php echo $donnees['JOU_BONUS_DF']; ?></td>
			<td align="center" valign="middle"><?php echo $donnees['JOU_BONUS_FINAL']; ?></td>
			<td align="center" valign="middle"><?php echo $donnees['JOU_BONUS_VQR']; ?></td>
<!--			<td align="center" valign="middle"><?php echo $donnees['JOU_BONUS_FR_NOM']; ?></td>		-->
<!--			<td align="center" valign="middle"><?php echo $donnees['JOU_BONUS_FR_NIV']; ?></td>		-->
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
