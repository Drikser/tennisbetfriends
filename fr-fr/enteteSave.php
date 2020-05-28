<header>

	<!-- Ceci est l'entête de tennisbetfriends.com de pronostiques <br /> -->

	<?php
    include("../commun/model.php");

    $tournament= getTournament();

    while ($donnees = $tournament->fetch()) {

			//echo $donnees['SET_LIB_TOURNAMENT'];

			if ($donnees['SET_TYP_TOURNAMENT'] ==  "GC") {


				switch ($donnees['SET_LIB_TOURNAMENT']) {

					case 'Australian Open':
					case 'US Open':
						?>
						<h6><?php echo "Pronostiques de l'" . $donnees['SET_LIB_TOURNAMENT'] ?></h6>
						<?php
						break;

					case 'Roland Garros':
					case 'Wimbledon':
					?>
					<h6><?php echo "Pronostiques de " . $donnees['SET_LIB_TOURNAMENT'] ?></h6>
					<?php
					break;
				}
			}

			else {
				?>
<!-- 				<h6><?php echo 'Pronostiques du ' . $donnees['SET_LIB_TOURNAMENT'] . ' (' . $donnees['SET_LIB_TYP'] . ')' ?></h6> -->
				<h6><?php echo 'Pronostiques du ' . $donnees['SET_LIB_TOURNAMENT'] ?></h6>
				<?php
			}
		}
    ?>


	<?php
	if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']))
	{
    	echo "Bonjour " . $_SESSION['JOU_PSE'] . " <br />";
	}
	else
	{
		echo "Bonjour visiteur <br />";
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
					echo "<span class='localClock'>Heure à Melbourne	: " . $H_Mel . "</span><br />";
				break;

				case 'Roland Garros':
					date_default_timezone_set('Europe/Paris');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Par = date('d/m/Y H:i');
					//echo 'Heure à Paris				: ' . $H_Par . '<br />';
					echo "<span class='localClock'>Heure à Paris : " . $H_Par . "</span><br />";
				break;

				case 'Wimbledon':
					date_default_timezone_set('Europe/London');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Lon = date('d/m/Y H:i');
					echo 'Heure à Londres			: ' . $H_Lon . '<br />';
				break;

				case 'US Open':
					date_default_timezone_set('America/New_York');
					//$H_Mel = date('d/m/Y H:i:s');
					$H_Nyk = date('d/m/Y H:i');
					echo 'Heure à New-York		: ' . $H_Nyk . '<br />';
				break;
			}
	}


	//include ("localTime.php");

	//echo "Date et heure chez toi <br />";
	//include ("../commun/clock2.php");

	//echo "Date et heure à New-York <br />";
	//include ("clock3.php");

	//include ("moment.js");
	?>

<!--
	<script>

		//---------------------------------------
		// Calculer une différence entre 2 dates
		//---------------------------------------
		var debut = new Date();

		var i = 0
		while(i < 9999999)
			i++;

		var fin = new Date();

		duree = fin.getTime() - debut.getTime();

		//alert("debut script=" + debut + " fin script=" + fin);
		console.log("debut du script=", debut)
		console.log("fin du script=", fin)
		console.log("durée du script=", duree, "ms")

		//----------------------------------------
		// new exemple setTime()
		//---------------------------------------
		var uneDate = new Date();
		uneDate.setTime(987654321);
		//uneDate.setTime(99999999999);
		console.log("UneDate=", uneDate)

		//document.write(uneDate + "<br />");


		//----------------------------------------
		// Décalage horaire avec Greenwich
		//---------------------------------------
		var date = new Date();
		var jetlag = date.getTimezoneOffset();

		console.log("decalage=", jetlag, "minutes")

		//----------------------------------------
		// Fonction afficher heure
		//---------------------------------------

		//function localTime()
		//{
		//     var date = new Date();
		//     var hours = date.getHours();
		//     var minutes = date.getMinutes();
		//     if(minutes < 10)
		//          minutes = "0" + minutes;
		//     var seconds = date.getSeconds();
		//     if (seconds < 10)
		//          seconds = "0" + seconds;

		//     return hours + ":" + minutes + ":" + seconds;
		//}

		//console.log("il est exactement", localTime());

		//onLoad="localTime();"

		//document.write("Voilà un test d'affichage de javascript");

		var november = moment("2019-11-14T12:00:00Z");
		console.console.log(november.tz('America/Los_Angeles').format('LLLL'));

/*
		var newYork    = moment.tz("2014-06-01 12:00", "America/New_York");
		var losAngeles = newYork.clone().tz("America/Los_Angeles");
		var london     = newYork.clone().tz("Europe/London");

		newYork.format();    // 2014-06-01T12:00:00-04:00
		losAngeles.format(); // 2014-06-01T09:00:00-07:00
		london.format();     // 2014-06-01T17:00:00+01:00

		var today = moment.tz("2019-10-27 12:00", "Europe/London");
		//var newYork    = moment.tz("2014-06-01 12:00", "America/New_York");
		//var losAngeles = date.clone().tz("America/Los_Angeles");
		var melbourne  = today.clone().tz("Australia/Melbourne");
		var paris      = today.clone().tz("Europe/Paris");
		var newYork    = today.clone().tz("America/New_York");
		var london     = today.clone().tz("Europe/London");

		melbourne.format();
		paris.format();
		london.format();
		newYork.format();

		document.write("Date Melbourne =" + melbourne + "<br />");
		document.write("Date Paris     =" + paris + "<br />");
		document.write("Date Londres   =" + london + "<br />");
		document.write("Date New-York  =" + newYork + "<br />");
*/

//		};
	</script>
-->

<!--
	<?php
	//include ("localTime.php");

//	echo "Nous sommes le " . message . "<br />";
	?>
-->

<!--
	<script>
		//var now = new Date();
		//console.log("date de maintenant = ",now);
		//alert('Hello toi!');
		//console.log("getTimezoneOffset", now.getTimezoneOffset());


		//var maintenant = moment();
		//console.log(maintenant);

	</script>
-->



</header>
