<?php

//if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
//if ($_POST['VouD'] == "" OR $_POST['ScoreJ1'] == "" OR $_POST['ScoreJ2'] == "") {
//if (isset($_POST['VouD']) OR isset($_POST['ScoreJ1']) OR isset($_POST['ScoreJ2'])) {
if (!empty($_POST['VouD']) AND !empty($_POST['ScoreJ1']) AND !empty($_POST['ScoreJ2'])) {

	echo "Le match saisit est le match n°" . $_POST['idMatch'] . '<br />'; //idMAtch est la valeur du champs caché du formulaire de saisie de score
	echo "Le joueur est l'ID n°" . $_SESSION['JOU_ID'] . '<br />';

	$typeMatch = $_POST['TypeMatch'];

	//Contrôles avant chargement :
	$pronoOK = 'OK';

	switch ($typeMatch) {
		case 'AB':
			if ($_POST['ScoreJ1'] == 2) {
				echo "<span class='warning'>!!! Attention : Le perdant ne peut pas abandonner si le gagnant a déjà 2 sets !!!</span><br />";
				$pronoOK = 'KO';
			}
			break;
		case 'WO':
			if ($_POST['ScoreJ1'] == 2) {
				echo "<span class='warning'>!!! Attention : si il y a forfait, le score doit être 0-0 !!!</span><br />";
				$pronoOK = 'KO';
			}
			break;

		default:
			if ($_POST['ScoreJ1'] == 0) {
				echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur ne peut pas gagner avec 0 set !!!</span><br />";
				$pronoOK = 'KO';
			}

			if ($_POST['ScoreJ1'] != 2) {
				echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 2 sets !!!</span><br />";
				$pronoOK = 'KO';
			}

			if ($_POST['ScoreJ2'] >= $_POST['ScoreJ1']) {
				echo "<span class='warning'>!!! Mauvais score renseigné : Le nombre de sets du perdant doit être inférieur au vainqueur !!!</span><br />";
				$pronoOK = 'KO';
			}

			break;
	}

	//Chargement des scores en table MySQL des pronostiques
	$nbRow = 0;

	if ($pronoOK == 'OK') {

		$req = updatePrognosis($_POST['idMatch'], $_SESSION['JOU_ID']);

		$nbRow = $req->rowcount();
	}


	if ($nbRow > 0)
	{
		echo 'Bravo ! Pronostique fait !<br />';

		if ($_POST['VouD'] == 'V') {
		 	switch ($typeMatch) {
		 	 	case 'AB':
		 	 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' par abandon *** ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player2']) . '<br />';
		 	 		break;

		 	 	case 'WO':
	 	 			echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player']) . ' par forfait. <br />';
	 	 			break;

		 	 	default:
	 	 			echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' *** ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . '<br />';
	 	 			break;
		 	 }
		 }
		 else {
		 	switch ($typeMatch) {
		 	 	case 'AB':
		 	 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' par abandon *** ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player1']) . '<br />';
		 	 		break;

		 	 	case 'WO':
		 	 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' par forfait. <br />';
		 	 		break;

		 	 	default:
		 	 		echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' *** ' . htmlspecialchars($_POST['ScoreJ1']) . ' sets à ' . htmlspecialchars($_POST['ScoreJ2']) . '<br />';
		 	 		break;
		 	}
		}

		echo 'Pour faire un nouveau pronostique, clique <a href="pronostique.php">' . 'ICI' . '</a><br/>';

	}
	else
	{
		echo "Merci de re-saisir votre pronostique " . '<a href="pronostique	.php">ici</a>';
	}
}
