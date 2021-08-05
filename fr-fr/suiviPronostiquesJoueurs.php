<!-- <h1>Suivi pronostiques joueurs</h1> -->

<?php

$nbRow = 0;

$incompletePrognosis = getIncompletePrognosis();

$nbRow = $incompletePrognosis->rowcount();

if ($nbRow > 0) {
	echo "<span class='warning'>Attention des joueurs n'ont pas fait tous leurs pronostiques :</span><br />";

	?>

	<table>
		<tr>
			<th>Pseudo</th>
			<th>Tour</th>
			<th>Date</th>
			<th>N°du match</th>
			<th>Match</th>
		</tr>
		<?php
		while ($donnees = $incompletePrognosis->fetch())
			{
		?>
				<tr>
					<td align="center" valign="middle"><?php echo $donnees['JOU_PSE']; ?></td>
					<td align="center" valign="middle"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
					<td align="center" valign="middle"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
					<td align="center" valign="middle"><?php echo $donnees['RES_MATCH_TOUR_SEQ']; ?></td>
					<td align="center" valign="middle"><?php echo $donnees['RES_MATCH_JOU1'] . ' / ' . $donnees['RES_MATCH_JOU2']; ?></td>
				</tr>

		<?php
		}
		?>
	</table>
	<?php
}
else {
	echo "Tous les joueurs sont à jour de leurs pronostiques <br />";
}
