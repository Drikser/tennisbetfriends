	<?php

//************************************************************************************************************************************************************
//** convert result french to english
//   --> To display on the english version of the website
//************************************************************************************************************************************************************

function ConvertResultFTE($inputResultF) {

switch ($inputResultF) {

	case 'V':
		$outputResultE = 'W';
		break;

	case 'D':
		$outputResultE = 'L';
		break;

	default:
		$outputResultE = '';
		break;
}

return $outputResultE;
}

//************************************************************************************************************************************************************
//** convert result from french to english
//   --> To update the database from the english version of the website
//************************************************************************************************************************************************************

function ConvertResultETF($inputResultE) {

	switch ($inputResultE) {

		case 'W':
			$outputResultF = 'V';
			break;

		case 'L':
			$outputResultF = 'D';
			break;

		default:
			$outputResultF = '';
			break;
	}

return $outputResultF;
}

//************************************************************************************************************************************************************
//** convert type result from french to english
//************************************************************************************************************************************************************

function ConvertTypeResultFTE($inputTypeResultF) {

	if ($inputTypeResultF == 'AB') {
		$outputTypeResultE = 'RET';
	} else {
		$outputTypeResultE = $inputTypeResultF;
	}

return $outputTypeResultE;
}


//************************************************************************************************************************************************************
//** convert type result from english to french
//************************************************************************************************************************************************************

function ConvertTypeResultETF($inputTypeResult) {

	if ($inputTypeResult == 'RET') {
		$outputTypeResult = 'AB';
	} else {
		$outputTypeResult = $inputTypeResult;
	}

return $outputTypeResult;
}


//************************************************************************************************************************************************************
//** convert round french to english
//************************************************************************************************************************************************************

function ConvertRoundFTE($inputRound) {

	switch ($inputRound) {

		case 'VAINQUEUR':
			$outputRound = 'WINNER';
			break;

		case 'FINALE':
			$outputRound = 'FINAL';
			break;

		case 'DEMI-FINALE':
			$outputRound = 'SEMI-FINAL';
			break;

		case 'QUART DE FINALE':
			$outputRound = 'QUARTER FINAL';
			break;

		case 'HUITIEME DE FINALE':
			$outputRound = 'ROUND OF 16';
			break;

		case '3EME TOUR':
			$outputRound = '3RD ROUND';
			break;

		case '2EME TOUR':
			$outputRound = '2ND ROUND';
			break;

		case '1ER TOUR':
			$outputRound = '1ST ROUND';
			break;

		default:
			$outputRound = '';
			break;
	}

	return $outputRound;
}


// //************************************************************************************************************************************************************
// //Fonction afficher date
// //************************************************************************************************************************************************************
//
// 	function dateFr()
// 	{
// 	  // les noms de jours / mois
// 	  var day = new Array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
// 	  var month = new Array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");
// 	  // on recupere la date
// 	//			function refreshDate()
// 	//			{
// 	    var date = new Date();
// 	    // on construit le message
// 	    var message = day[date.getDay()] + " ";   // nom du jour
// 	    message += date.getDate() + " ";   // numero du jour
// 	    message += month[date.getMonth()] + " ";   // mois
// 	    message += date.getFullYear();
// 	    return message;
// 	//			}
// 	//			refreshDate();
// 	//			setInterval(refreshDate,1);
// 	}
//
// 	// console.log("nous sommes le", dateFr());
//
//
//
// //************************************************************************************************************************************************************
// // Fonction afficher heure
// //************************************************************************************************************************************************************
// 	function heure()
// 	{
// 	//			function refreshTime()
// 	//			{
// 	     var date = new Date();
// 	     var hours = date.getHours();
// 	     var minutes = date.getMinutes();
// 	     if(minutes < 10)
// 	          minutes = "0" + minutes;
// 	     var seconds = date.getSeconds();
// 	     if (seconds < 10)
// 	          seconds = "0" + seconds;
//
// 	     return hours + ":" + minutes + ":" + seconds;
// 	//			 }
// 	 			refreshTime();
// 	 			setInterval(refreshTime,1000);
// 	}
//
// 	console.log("il est exactement", heure());
