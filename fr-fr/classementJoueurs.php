
<h1>Classement général</h1>

<?php
//echo "Le classement des joueurs :<br />";

$classement = 1;

$table = getTable();

?>

<table>
	<tr>
		<th align="center" valign="middle">Clst</th>
		<th align="center" valign="middle">Pseudo</th>
		<th align="center" valign="middle">Total points</th>
		<th align="center" valign="middle">Points pronostiques<br />(Dont nb prono exacts)</th>
		<th align="center" valign="middle">Bonus Demi-finalistes</th>
		<th align="center" valign="middle">Bonus Finalistes</th>
		<th align="center" valign="middle">Bonus Vainqueur</th>
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
