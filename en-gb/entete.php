<header>

	<!-- Ceci est l'entête de tennisbetfriends.com de pronostiques <br /> -->

	<?php
    include("../commun/model.php");
		include("../commun/functions.php");

    $tournament= getTournament();

    while ($donnees = $tournament->fetch()) {

			//echo $donnees['SET_LIB_TOURNAMENT'];
			?>
			<h6><?php echo $donnees['SET_LIB_TOURNAMENT'] . " forecasts" ?></h6>
			<?php
			}
    ?>


	<?php
	echo "<br />";
	if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']))
	{
    	echo "<span class='Hello'>Hello " . $_SESSION['JOU_PSE'] . " </span><br />";
	}
	else
	{
		echo "<span class='Hello'>Hello visitor </span><br />";
	}

	// Horloge qui affiche l'heure et les secondes (basé sur l'heure du PC)
	include ("../commun/clock2.php");

	//var datePC = new Date();

	//echo 'Date et heure chez toi : ' . date('d/m/Y H:i') . '<br />';

	$tournament= getTournament();

	while ($donnees = $tournament->fetch()) {
			switch ($donnees['SET_LIB_TOURNAMENT']) {

				case 'Australian Open':
					date_default_timezone_set('Australia/Melbourne');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Mel = date('d/m/Y H:i');
					echo "<span class='localClock'>Melbourne time: " . $H_Mel . "</span><br /><br />";
				break;

				case 'Roland Garros':
					date_default_timezone_set('Europe/Paris');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Par = date('d/m/Y H:i');
					//echo 'Heure à Paris				: ' . $H_Par . '<br />';
					echo "<span class='localClock'>Paris time: " . $H_Par . "</span><br /><br />";
				break;

				case 'Wimbledon':
					date_default_timezone_set('Europe/London');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Lon = date('d/m/Y H:i');
					echo 'London time: ' . $H_Lon . '<br /><br />';
				break;

				case 'US Open':
					date_default_timezone_set('America/New_York');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Nyk = date('d/m/Y H:i');
					echo 'New-York time: ' . $H_Nyk . '<br /><br />';
				break;
			}
	}
	?>

</header>
