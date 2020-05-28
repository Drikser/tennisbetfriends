<h1>Suivi pronostiques joueurs</h1>

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
			<th>Match</th>
		</tr>
		<?php
		while ($donnees = $incompletePrognosis->fetch())
			{
		?>
				<tr>
					<td><?php echo $donnees['JOU_PSE']; ?></td>
					<td><?php echo $donnees['RES_MATCH_JOU1'] . ' / ' . $donnees['RES_MATCH_JOU2']; ?></td>
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
