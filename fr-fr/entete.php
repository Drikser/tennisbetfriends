<header>

	<!-- Ceci est l'entête de tennisbetfriends.com de pronostiques <br /> -->

	<div id="banner">

	<?php
    include("../commun/model.php");
		include("../commun/functions.php");

    $tournament= getTournament();

    while ($donnees = $tournament->fetch()) {

			//echo $donnees['SET_LIB_TOURNAMENT'];

			if ($donnees['SET_TYP_TOURNAMENT'] ==  "GC") {

				switch ($donnees['SET_LIB_TOURNAMENT']) {

					case 'Australian Open':
					case 'US Open':
						if ($_SERVER['HTTP_HOST'] == 'localhost') {
							echo "<span class='warning'>TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST</span>";
						}
						echo "<h6>Pronostiques de l'" . $donnees['SET_LIB_TOURNAMENT'] . "</h6>";
						if ($_SERVER['HTTP_HOST'] == 'localhost') {
							echo "<span class='warning'>TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST</span>";
						}
						break;

					case 'Roland Garros':
					case 'Wimbledon':
						if ($_SERVER['HTTP_HOST'] == 'localhost') {
							echo "<span class='warning'>TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST</span>";
						}
						echo "<h6>Pronostiques de " . $donnees['SET_LIB_TOURNAMENT'] . "</h6>";
						if ($_SERVER['HTTP_HOST'] == 'localhost') {
							echo "<span class='warning'>TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST</span>";
						}
					break;
				}
			}

			else {
/*
				?>
<!-- 				<h6><?php echo 'Pronostiques du ' . $donnees['SET_LIB_TOURNAMENT'] . ' (' . $donnees['SET_LIB_TYP'] . ')' ?></h6> -->
				<!-- <h6><?php echo 'Pronostiques ' . $donnees['SET_LIB_TOURNAMENT'] . SUBSTR($donnees['SET_DAT_START'], 0, 3) . ' (' . $donnees['SET_LIB_TYP'] . ')'?></h6> -->
				<h6><?php echo 'Pronostiques ' . $donnees['SET_LIB_TOURNAMENT'] . ' (' . $donnees['SET_LIB_TYP'] . ')'?></h6>
				<?php
*/
				echo '<h6>Pronostiques ' . $donnees['SET_LIB_TOURNAMENT'] . ' (' . $donnees['SET_LIB_TYP'] . ')</h6>';
			}
		}
    ?>

		<?php // require("menu.php"); ?>

	</div>

	<div class="language_choice" >
		<br />
		<!-- <a href="../en-gb/index.php"><img src="../images/french_flag_rectangle_mini.png" alt="English flag" /></a><a class="a_menu" href="../en-gb/index.php"> (Allez sur la version anglaise)</a>; -->
		Version <img src="../images/french_flag_rectangle_mini.png" alt="French flag" /><a class="lang_menu" href="../en-gb/index.php"></a> (Basculer vers <a href="../en-gb/index.php"><img src="../images/english_flag_rectangle_mini2.png" alt="English flag" title="Allez sur la version anglaise"/></a><a class="lang_menu" href="../en-gb/index.php"></a>)
	</div>

	<?php
	echo "<br />";

	if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']))
	{
    	echo "<span class='Hello'>Bonjour " . $_SESSION['JOU_PSE'] . " </span><br />";
	}
	else
	{
		echo "<span class='Hello'>Bonjour visiteur </span><br />";
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
					echo "<span class='localClock'>Heure à Melbourne	: " . $H_Mel . "</span><br /><br />";
				break;

				case 'Roland Garros':
					date_default_timezone_set('Europe/Paris');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Par = date('d/m/Y H:i');
					//echo 'Heure à Paris				: ' . $H_Par . '<br /><br />';
					echo "<span class='localClock'>Heure à Paris : " . $H_Par . "</span><br /><br />";
				break;

				case 'Wimbledon':
					date_default_timezone_set('Europe/London');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Lon = date('d/m/Y H:i');
					echo "<span class='localClock'>Heure à Londres : " . $H_Lon . "</span><br /><br />";
				break;

				case 'US Open':
					date_default_timezone_set('America/New_York');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Nyk = date('d/m/Y H:i');
					// echo 'Heure à New-York		: ' . $H_Nyk . '<br /><br />';
					echo "<span class='localClock'>Heure à New-York : " . $H_Nyk . "</span><br /><br />";
				break;
			}
	}
	?>

</header>
