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

function ConvertRound($inputRound) {

	switch ($inputRound) {

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
			$outputRound = 'ROUND';
			break;
	}

	return $outputRound;
}
