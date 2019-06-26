<header>

	<!-- Ceci est l'entête de tennisbetfriends.com de pronostiques <br /> -->

	<?php
    include("model.php");

    $tournament= getTournament();

    while ($donnees = $tournament->fetch()) {

			if ($donnees['SET_TYP_TOURNAMENT'] ==  "GC") {
				?>
<!--		<span class='tournoi'><?php echo $donnees['SET_LIB_TOURNAMENT'] . ' (' . $donnees['SET_LIB_TYP'] . ')' ?></span> -->
					<h6><?php echo 'Pronostiques du tournoi de ' . $donnees['SET_LIB_TOURNAMENT'] ?></h6>
				<?php
			}
			else {
				?>
				<h6><?php echo 'Pronostiques du tournoi de ' . $donnees['SET_TOURNAMENT'] . ' (' . $donnees['SET_LIB_TYP'] . ')' ?></h6>
				<?php
			}
		}
    ?>



	<?php
	if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']))
	{
    	echo "Bonjour " . $_SESSION['JOU_PSE'];
	}
	else
	{
		echo "Bonjour visiteur";
	}
	?>
</header>
