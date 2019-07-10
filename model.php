	<?php

//************************************************************************************************************************************************************
//****************************************************** Fonctions de séléction ******************************************************************************
//************************************************************************************************************************************************************


function controlPseudo($postPseudo) {
	$bdd = dbConnect();
	//$req = $bdd->prepare('SELECT * FROM joueur WHERE JOU_PSE = :Pseudo LIMIT 1'); // Limitation à une réponse (si on trouve le pseudo pas la peine d'aller plus loin, il faut choisir un autre pseudo)
	//$req->execute(array(
	//   	'Pseudo' => $_POST['Pseudo']));

	$req = $bdd->prepare('SELECT * FROM joueur WHERE JOU_PSE = ? LIMIT 1'); // Limitation à une réponse (si on trouve le pseudo pas la peine d'aller plus loin, il faut choisir un autre pseudo)
	$req->execute(array($postPseudo));

	$pseudo = $req->fetch(); // Pas besoin de faire un "while" car une seule ligne de résultat

	return $pseudo;
}


function controlName($postNom, $postPrenom) {
	$bdd = dbConnect();
	$req = $bdd->prepare('SELECT * FROM joueur WHERE JOU_NOM = ? AND JOU_PRE = ? LIMIT 1'); // Limitation à une réponse (si on trouve le pseudo pas la peine d'aller plus loin, il faut choisir un autre pseudo)
	$req->execute(array($postNom, $postPrenom));

	$name = $req->fetch(); // Pas besoin de faire un "while" car une seule ligne de résultat

	return $name;
}


function controlMail($postMail) {
	$bdd = dbConnect();
	$req = $bdd->prepare('SELECT * FROM joueur WHERE JOU_ADR_MAIL = ? LIMIT 1'); // Limitation à une réponse (si on trouve le pseudo pas la peine d'aller plus loin, il faut choisir un autre pseudo)
	$req->execute(array($postMail));

	$email = $req->fetch(); // Pas besoin de faire un "while" car une seule ligne de résultat

	return $email;
}


function controlToken($postToken) {
	$bdd = dbConnect();
	$req = $bdd->prepare('SELECT * FROM joueur WHERE JOU_TOKEN = ? AND JOU_COUNT = 1 LIMIT 1'); // Limitation à une réponse (JOU_COUNT = 1, pour vérifier que le mot de passe n'a pas déjà été mis à jour)
	$req->execute(array($postToken));

	$ctrlToken = $req->fetch(); // Pas besoin de faire un "while" car une seule ligne de résultat

	return $ctrlToken;
}


function getPlayerId($postId) {
	// Rechercher l'id du joueur créé
	$bdd = dbConnect();
	$req = $bdd->prepare('SELECT JOU_ID FROM joueur WHERE JOU_PSE = ?');
	$req->execute(array($postId));

	$donnees = $req->fetch();
	$playerId = $donnees['JOU_ID'];

	return $playerId;
}


function selectMatch($postPlayerId, $postMatchId) {
	// Selection du match à pronostiquer
	$bdd = dbConnect();
	$req = $bdd->prepare("SELECT *
	                        FROM pronostique p INNER JOIN resultats r
	                          ON p.PRO_MATCH_ID = r.RES_MATCH_ID
	                       WHERE p.PRO_JOU_ID = ?
	                         AND r.RES_MATCH_ID = ?
	                         AND p.PRO_RES_MATCH = ''
	                         AND r.RES_MATCH = ''
	                    ORDER BY r.RES_MATCH_DAT DESC");
	$req->execute(array($postPlayerId, $postMatchId));

	//$donnees = $req->fetch();
	//$matchSelected = $donnees['RES_MATCH_ID'];

	return $req;

}


function selectMatchToModify($postPlayerId, $postMatchId) {
	// Selection du match à pronostiquer
	$bdd = dbConnect();

    //$matchChoisi = $_GET['ResMatchId'];

    $req = $bdd->prepare("SELECT *
                              FROM pronostique p INNER JOIN resultats r
                                ON p.PRO_MATCH_ID = r.RES_MATCH_ID
                             WHERE p.PRO_JOU_ID = ?
                               AND r.RES_MATCH_ID = ?");
//                          ORDER BY r.RES_MATCH_DAT DESC");
	$req->execute(array($postPlayerId, $postMatchId));

	//$donnees = $req->fetch();
	//$matchSelected = $donnees['RES_MATCH_ID'];

	return $req;

}



function getPronostique_Bonus($postPlayerId) {
	// Selection du match à pronostiquer
	$bdd = dbConnect();

	$req = $bdd->prepare('SELECT *
                	  	    FROM pronostique_bonus
                	 	   WHERE PROB_JOU_ID = ?');
	$req->execute(array($postPlayerId));

	return $req;

}

function getBonusPrognosis($postId) {
	$bdd = dbConnect();
    $req = $bdd->prepare('SELECT * FROM pronostique_bonus
 	                              WHERE PROB_JOU_ID = ?');
   	$req->execute(array($postId));

	$bonus = $req->fetch(); // Pas besoin de faire un "while" car une seule ligne de résultat

	return $bonus;
}

function getAllPrognosisForAMatch($postMatchId) {
	// Selection du match à pronostiquer
	$bdd = dbConnect();

	$req = $bdd->prepare('SELECT *
                	  	    FROM pronostique
                	 	   WHERE PRO_MATCH_ID = ?');
	$req->execute(array($postMatchId));

	return $req;

}


function getTournament() {
	$bdd = dbConnect();

	$response = $bdd->query('SELECT * FROM settings_tournament LIMIT 1');

	return $response;
}


function getAllPlayers() {
	// Rechercher l'id du joueur créé
	$bdd = dbConnect();
	$response = $bdd->query('SELECT JOU_ID, JOU_PSE FROM joueur WHERE JOU_PSE != "Admin"');

	return $response;
}


function getPlayersTournament() {
	// Rechercher l'id du joueur créé
	$bdd = dbConnect();
	$response = $bdd->query('SELECT count(*) AS NbPlayersTournament FROM players');

	return $response;
}


function getAllPlayersTournament() {
	// Rechercher l'id du joueur créé
	$bdd = dbConnect();
	$response = $bdd->query('SELECT * FROM players');

	return $response;
}


function getAllFrenchTournament() {
	// Rechercher l'id du joueur créé
	$bdd = dbConnect();
	$response = $bdd->query('SELECT * FROM players WHERE PLA_PAY = "fra"');

	return $response;
}

function getAllLevel() {
	// Rechercher l'id du joueur créé
	$bdd = dbConnect();
	$response = $bdd->query('SELECT * FROM settings_level');

	return $response;
}



function getIncompletePrognosis() {
// Rechercher les pronostiques pas saisis pour relancer les joueurs
	$bdd = dbConnect();
	$response = $bdd->query('SELECT * FROM pronostique, resultats, joueur
									 WHERE PRO_MATCH_ID = RES_MATCH_ID
									   AND PRO_JOU_ID = JOU_ID
									   AND PRO_RES_MATCH = " " ORDER BY PRO_JOU_ID, PRO_MATCH_ID');

	return $response;
}


function getAllCreatedMatchsId() {
// Rechercher les 5 derniers inscrits
	$bdd = dbConnect();
	$response = $bdd->query('SELECT RES_MATCH_ID FROM resultats');

	return $response;
}


function getLastPseudo() {
// Rechercher les 5 derniers inscrits
	$bdd = dbConnect();
	$response = $bdd->query('SELECT * FROM joueur WHERE JOU_PSE != "Admin" ORDER BY JOU_DAT_INS desc LIMIT 0,5');

	return $response;
}


function getLastCreatedMatch() {
// Rechercher les 5 derniers inscrits
	$bdd = dbConnect();
    $response = $bdd->query('SELECT Max(RES_MATCH_ID) as idMax FROM resultats');

	return $response;
}


function getNbRegistered() {
// Comptage du nb d'inscrits
	$bdd = dbConnect();
	$response = $bdd->query('SELECT count(*) AS nbInscrits FROM joueur WHERE JOU_PSE != "Admin"');

	return $response;
}



function getTable() {
// Affiche le classement des joueurs
	$bdd = dbConnect();
	$response = $bdd->query('SELECT * FROM joueur WHERE JOU_PSE != "Admin" ORDER BY JOU_TOT_PTS DESC, JOU_PTS_PRONO DESC, JOU_NB_RES_OK DESC, JOU_BONUS_VQR DESC, JOU_BONUS_FINAL DESC, JOU_BONUS_DF DESC, JOU_DAT_INS');

	return $response;
}



function getAllPrognosis() {
	$bdd = dbConnect();
	$response = $bdd->query('SELECT *
                          FROM pronostique p
                    INNER JOIN resultats r
                            ON p.PRO_MATCH_ID = r.RES_MATCH_ID
                    INNER JOIN joueur j
                            ON p.PRO_JOU_ID = j.JOU_ID
                         WHERE p.PRO_MATCH_ID = r.RES_MATCH_ID
                           AND r.RES_MATCH <> ""
                      ORDER BY r.RES_MATCH_POIDS_TOUR ASC, r.RES_MATCH_DAT DESC, r.RES_MATCH_ID DESC, j.JOU_PSE ASC');

	return $response;
}


function getAllBonus() {
	$bdd = dbConnect();
	$response = $bdd->query('SELECT *
                          FROM pronostique_bonus b
                    INNER JOIN joueur j
                            ON b.PROB_JOU_ID = j.JOU_ID
												 WHERE b.PROB_JOU_ID <> 1
                      ORDER BY j.JOU_PSE ASC');
	return $response;
}


function getSemisAndFinalists() {
	//Recherche des résultats des demi-finales (poids 2)
	$bdd = dbConnect();
	$response = $bdd->query('SELECT *
                          FROM resultats
													WHERE (RES_MATCH_POIDS_TOUR = 1 OR RES_MATCH_POIDS_TOUR = 2)');

	return $response;
}


function getFinalists() {
	//Recherche des résultats de la finale (poids 1)
	$bdd = dbConnect();
	$response = $bdd->query('SELECT *
                          FROM resultats
													WHERE RES_MATCH_POIDS_TOUR = 1');

	return $responseFinalists;
}

function getDailyMatchs() {
	$bdd = dbConnect();
    //$reponse = $bdd->query('SELECT * FROM résultats WHERE RES_MATCH_DAT = CURDATE()');
    $response = $bdd->query('SELECT * FROM resultats
    						  WHERE SUBSTR(RES_MATCH_DAT,1,10) >= SUBSTR(CURDATE(),1,10)
    						    AND RES_MATCH = ""
    					   ORDER BY RES_MATCH_DAT ASC');

	return $response;
}


function getNextMatchs() {
	$bdd = dbConnect();
	//$reponse = $bdd->query('SELECT * FROM résultats WHERE RES_MATCH_DAT = CURDATE()');
	$response = $bdd->query('SELECT * FROM resultats WHERE RES_MATCH_DAT >= CURDATE() AND RES_MATCH = ""');

	return $response;
}



function getYourPrognosis() {
	$bdd = dbConnect();
	//Sélection des pronostiques effectués par le joueur :
	$response = $bdd->query('SELECT *
                              FROM pronostique p INNER JOIN resultats r
                               ON p.PRO_MATCH_ID = r.RES_MATCH_ID
                            WHERE p.PRO_JOU_ID = "'.$_SESSION['JOU_ID'].'"
                              AND p.PRO_RES_MATCH <> ""
                         ORDER BY r.RES_MATCH_POIDS_TOUR ASC, r.RES_MATCH_DAT DESC');

	return $response;
}



function getPrognosisToDo() {
	$bdd = dbConnect();
    //$response = $bdd->query('SELECT * FROM resultats
    //                               WHERE RES_MATCH = "" AND RES_MATCH_JOU1 != "" AND RES_MATCH_JOU2 != ""
    //                             ORDER BY RES_MATCH_DAT ASC');
    $response = $bdd->query('SELECT * FROM resultats r INNER JOIN pronostique p
    									ON r.RES_MATCH_ID = p.PRO_MATCH_ID
                                     WHERE p.PRO_JOU_ID = "'.$_SESSION['JOU_ID'].'"
                                       AND r.RES_MATCH = ""
                                       AND r.RES_MATCH_JOU1 != ""
                                       AND r.RES_MATCH_JOU2 != ""
                                       AND p.PRO_RES_MATCH = ""
                                  ORDER BY r.RES_MATCH_DAT ASC');
	return $response;
}


function getResultsToEnter() {
	$bdd = dbConnect();
    $response = $bdd->query('SELECT * FROM resultats
 	                                WHERE RES_MATCH = "" AND RES_MATCH_JOU1 != "" AND RES_MATCH_JOU2 != ""
                                 ORDER BY RES_MATCH_DAT ASC');
	return $response;
}


function getResultToEnter($postMatchId) {
	$bdd = dbConnect();

    $req = $bdd->prepare("SELECT *
        	                  FROM resultats
                    	     WHERE RES_MATCH = ''
                               AND RES_MATCH_ID = ?
                	      ORDER BY RES_MATCH_DAT DESC");
	$req->execute(array($postMatchId));

	return $req;
}

function getResultLevel($postLevel) {
	$bdd = dbConnect();

    $request = $bdd->prepare("SELECT *
        	                  FROM resultats
                    	     WHERE RES_MATCH = ''
                               AND RES_MATCH_TOUR = ?");
	$request->execute(array($postLevel));

	return $request;
}

function getFrenchLeft($postLevel) {
	$bdd = dbConnect();

    $req = $bdd->prepare("SELECT *
        	                  FROM resultats
                    	     WHERE (RES_MATCH_JOU1 LIKE '%(fra)'
                    	        OR  RES_MATCH_JOU2 LIKE '%(fra)')
                               AND RES_MATCH_TOUR = ?");
	$req->execute(array($postLevel));

	return $req;
}

function getAllPtsPrognosisPlayer($postPlayerId) {
	$bdd = dbConnect();

	$pts = $bdd->prepare('SELECT * FROM pronostique INNER JOIN resultats ON pronostique.PRO_MATCH_ID = resultats.RES_MATCH_ID
 	        			   WHERE PRO_JOU_ID = "'.$postPlayerId.'"');

	$pts->execute(array($postPlayerId));

	return $pts;
}


//************************************************************************************************************************************************************
//****************************************************** Fonctions d'insertion *******************************************************************************
//************************************************************************************************************************************************************

function insertPlayer() {
	$bdd = dbConnect();

	global $MotDePasseHache;

	//Chargement du nouvel inscrit en table MySQL
	$req = $bdd->prepare('INSERT INTO joueur (JOU_NOM, JOU_PRE, JOU_PSE, JOU_ADR_MAIL, JOU_MDP, JOU_COUNT, JOU_TOKEN, JOU_DAT_INS, JOU_PTS_PRONO, JOU_NB_RES_OK, JOU_BONUS_DF, JOU_BONUS_VQR, JOU_BONUS_FR_NOM, JOU_BONUS_FR_NIV, JOU_TOT_PTS) VALUES (:Nom, :Prenom, :Pseudo, :Email, :MotDePasse, :Count, :Token, NOW(), :PointsPronos, :NbPronoOK, :BonusDemiFinalistes, :BonusVainqueur, :BonusMeilleurFrancais, :BonusNiveauMeilleurFrancais, :TotalPoints)');
	$req->execute(array(
		'Nom' => $_POST['Nom'],
		'Prenom' => $_POST['Prenom'],
		'Pseudo' => $_POST['Pseudo'],
		'Email' => $_POST['Email'],
		'MotDePasse' => $MotDePasseHache,
		'Count' => 0,
		'Token' => "",
		'PointsPronos' => 0,
		'NbPronoOK' => 0,
		'BonusDemiFinalistes' => 0,
		'BonusVainqueur' => 0,
		'BonusMeilleurFrancais' => 0,
		'BonusNiveauMeilleurFrancais' => 0,
		'TotalPoints' => 0));

	return $req;
}


function insertTournamentToPrognosis($postPlayerId) {
	$bdd = dbConnect();

	//Création du match à saisir pour tous les joueurs enregistrés
	$req = $bdd->prepare('INSERT INTO pronostique_bonus (PROB_JOU_ID, PROB_VQR, PROB_DEMI1, PROB_DEMI2, PROB_DEMI3, PROB_DEMI4, PROB_FR_NOM, PROB_FR_NIV) VALUES (:IdJoueur, :Winner, :Semi1, :Semi2, :Semi3, :Semi4, :FrenchName, :FrenchLevel)');
	$req->execute(array(
		'IdJoueur' => $postPlayerId,
		'Winner' => "",
		'Semi1' => "",
		'Semi2' => "",
		'Semi3' => "",
		'Semi4' => "",
		'FrenchName' => "",
		'FrenchLevel' => ""));
}



function createMatchToPrognosis($postPlayerId, $postMatchId) {
	$bdd = dbConnect();

	//echo "Dans la fonction createMatchToPrognosis() : joueur=" . $postPlayerId . " / match=" . $postMatchId . "<br />";

	//Création du match à saisir pour tous les joueurs enregistrés
	$req = $bdd->prepare('INSERT INTO pronostique (PRO_JOU_ID, PRO_MATCH_ID, PRO_RES_MATCH, PRO_SCORE_JOU1, PRO_SCORE_JOU2, PRO_TYP_MATCH, PRO_PTS_JOU) VALUES (:IdJoueur, :IdMatch, :ResMatch, :ScoreJou1, :ScoreJou2, :TypMatch, :PointsPronostique)');
	$req->execute(array(
		'IdJoueur' => $postPlayerId,
		'IdMatch' => $postMatchId,
		'ResMatch' => "",
		'ScoreJou1' => 0,
		'ScoreJou2' => 0,
		'TypMatch' => "",
        'PointsPronostique' => 0));
}



function createMatch() {
	$bdd = dbConnect();

	global $poidsTour;

    //Création du nouveau match à pronostiquer
    $req = $bdd->prepare('INSERT INTO resultats (RES_TOURNOI, RES_TYP_TOURNOI, RES_MATCH_DAT, RES_MATCH_TOUR, RES_MATCH_POIDS_TOUR, RES_MATCH_JOU1, RES_MATCH, RES_MATCH_TYP, RES_MATCH_SCR_JOU1, RES_MATCH_SCR_JOU2, RES_MATCH_JOU2) VALUES (:Tournoi, :Categorie, :DateMatch, :Niveau, :PoidsTour, :Joueur1, :ResultatMatch, :TypeResultatMatch, :ScoreJoueur1, :ScoreJoueur2, :Joueur2)');
    $req->execute(array(
        'Tournoi' => $_POST['Tournoi'],
        'Categorie' => $_POST['Categorie'],
        'DateMatch' => $_POST['DateMatch'],
        'Niveau' => $_POST['Niveau'],
        'PoidsTour' => $poidsTour,
        'Joueur1' => $_POST['Joueur1'],
        'ResultatMatch' => "",
        'TypeResultatMatch' => "",
        'ScoreJoueur1' => 0,
        'ScoreJoueur2' => 0,
        'Joueur2' => $_POST['Joueur2']));

    return $req;
}


// REPRENDRE ICI //
function loadTournamentPlayers($player, $pays) {
	$bdd = dbConnect();

    //insertion du joueur et du pays
    $req = $bdd->prepare('INSERT INTO players (PLA_NOM, PLA_PAY) VALUES (:Name, :Pays)');
    $req->execute(array(
        'Name' => $player,
        'Pays' => $pays));

    return $req;
}




//************************************************************************************************************************************************************
//****************************************************** Fonctions de mise à jour ****************************************************************************
//************************************************************************************************************************************************************


function updateWinner($postPlayerId) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
							 SET PROB_VQR = :Winner
						   WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Winner' => $_POST['Winner']));

    return $req;
}


function updateFinal($postPlayerId) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
							 SET PROB_FINAL1 = :Final1, PROB_FINAL2 = :Final2
						   WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Final1' => $_POST['Final1'],
		'Final2' => $_POST['Final2']));

    return $req;
}


function updateSemi($postPlayerId) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
							 SET PROB_DEMI1 = :Semi1, PROB_DEMI2 = :Semi2, PROB_DEMI3 = :Semi3, PROB_DEMI4 = :Semi4
						   WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Semi1' => $_POST['Semi1'],
		'Semi2' => $_POST['Semi2'],
		'Semi3' => $_POST['Semi3'],
		'Semi4' => $_POST['Semi4']));

    return $req;
}


function updateBestFrench($postPlayerId) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
							 SET PROB_FR_NOM = :BestFrench
						   WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'BestFrench' => $_POST['BestFrench']));

    return $req;
}


function updateLevelFrench($postPlayerId) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
							 SET PROB_FR_NIV = :LevelFrench
						   WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'LevelFrench' => $_POST['LevelFrench']));

    return $req;
}


function updatePrognosis($postPlayerId, $postMatchId) {
	$bdd = dbConnect();

	//echo "fonction updatePrognosis() : paramètres=" . $postPlayerId . " / " . $postMatchId . "<br />";
	//echo "Saisie=" . $_POST['VouD'] . " " . $_POST['ScoreJ1'] . "/" . $_POST['ScoreJ2'] . " (" . $_POST['TypeMatch'] . ")<br />";

	$req = $bdd->prepare('UPDATE pronostique
							 SET PRO_RES_MATCH = :Resultat, PRO_SCORE_JOU1 = :ScoreJoueur1, PRO_SCORE_JOU2 = :ScoreJoueur2, PRO_TYP_MATCH = :TypeMatch
						   WHERE PRO_JOU_ID = "'.$postPlayerId.'"
						     AND PRO_MATCH_ID = "'.$postMatchId.'"');

	$req->execute(array(
		'Resultat' => $_POST['VouD'],
		'ScoreJoueur1' => $_POST['ScoreJ1'],
		'ScoreJoueur2' => $_POST['ScoreJ2'],
		'TypeMatch' => $_POST['TypeMatch']));

    return $req;
}


function updateResult($postMatchId) {
	$bdd = dbConnect();

	//Chargement des scores en table MySQL des résultats
	$req = $bdd->prepare('UPDATE resultats
							 SET RES_MATCH = :Resultat, RES_MATCH_SCR_JOU1 = :ScoreJoueur1, RES_MATCH_SCR_JOU2 = :ScoreJoueur2, RES_MATCH_TYP = :TypeMatch
							   WHERE RES_MATCH_ID = "'.$postMatchId.'"');

	$req->execute(array(
		'Resultat' => $_POST['VouD'],
		'ScoreJoueur1' => $_POST['ScoreJ1'],
		'ScoreJoueur2' => $_POST['ScoreJ2'],
		'TypeMatch' => $_POST['TypeMatch']));

    return $req;
}


function updateScorePronostique($postPlayerId, $postMatchId, $postPtsPrognosis) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique
 	        			  SET PRO_PTS_JOU = :Points
   						WHERE PRO_JOU_ID = "'.$postPlayerId.'"
   						  AND PRO_MATCH_ID = "'.$postMatchId.'"');

	$req->execute(array(
		'Points' => $postPtsPrognosis));

    //return $req;
}


function updateScoreJoueur($postPlayerId, $postPtsPrognosis, $postAddNbExactPrognosis, $postPtsWinner, $postPtsFinalist, $postPtsSemi, $postPtsFrenchName, $postPtsFrenchLevel) {
	$bdd = dbConnect();

	echo 'Mise à jour en table SQL: ' . $postPlayerId . ' marque ' . $postPtsPrognosis . ' + ' . $postAddNbExactPrognosis . ' + ' . $postPtsWinner . ' + ' . $postPtsSemi . ' + ' . $postPtsFrenchName . ' + ' . $postPtsFrenchLevel . '.<br />';

	$req = $bdd->exec('UPDATE joueur
 			              SET JOU_PTS_PRONO = "'.$postPtsPrognosis.'",
 			              	  JOU_NB_RES_OK = "'.$postAddNbExactPrognosis.'",
 			              	  JOU_BONUS_VQR = JOU_BONUS_VQR+"'.$postPtsWinner.'",
 			              	  JOU_BONUS_FINAL = JOU_BONUS_FINAL+"'.$postPtsFinalist.'",
 			              	  JOU_BONUS_DF = JOU_BONUS_DF+"'.$postPtsSemi.'",
 			              	  JOU_BONUS_FR_NOM = JOU_BONUS_FR_NOM+"'.$postPtsFrenchName.'",
 			              	  JOU_BONUS_FR_NIV = JOU_BONUS_FR_NIV+"'.$postPtsFrenchLevel.'",
 			              	  JOU_TOT_PTS = JOU_PTS_PRONO+JOU_BONUS_DF+JOU_BONUS_FINAL+JOU_BONUS_VQR+JOU_BONUS_FR_NOM+JOU_BONUS_FR_NIV
   						WHERE JOU_ID = "'.$postPlayerId.'"');
	//$req = $bdd->exec('UPDATE joueur
 	//		              SET JOU_PTS_PRONO = :Points, JOU_NB_RES_OK = :NbResultsOk, JOU_TOT_PTS = JOU_PTS_PRONO+JOU_BONUS_DF+JOU_BONUS_VQR+JOU_BONUS_FR_NOM+JOU_BONUS_FR_NIV
   	//					WHERE JOU_ID = "'.$postPlayerId.'"');
	//$req->execute(array(
	//	'Points' => JOU_PTS_PRONO+$postPtsPrognosis,
	//	'NbResultsOk' => JOU_NB_RES_OK+$postAddNbExactPrognosis));

    //return $req;
}


function updateToken($postEmail, $postToken) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE joueur
							 SET JOU_TOKEN = :Token,
							 	 JOU_COUNT = 1
						   WHERE JOU_ADR_MAIL = "'.$postEmail.'"');

	$req->execute(array(
		'Token' => $postToken));

    return $req;
}

function updatePwd($postToken) {
	$bdd = dbConnect();

	global $MotDePasseHache;

	$req = $bdd->prepare('UPDATE joueur
							 SET JOU_MDP = :NewPwd,
							     JOU_COUNT = 0
						   WHERE JOU_TOKEN = "'.$postToken.'"');

	$req->execute(array(
		'NewPwd' => $MotDePasseHache));

    return $req;
}

//************************************************************************************************************************************************************
//****************************************************** Connexion à la base dedonnées ***********************************************************************
//************************************************************************************************************************************************************


function dbConnect(){
	try
	{
		// On va se connecter à la base de données
		//$bdd = new PDO('mysql:host=tennisbefubddtbf.mysql.db;dbname=tennisbefubddtbf;charset=utf8', 'tennisbefubddtbf', 'nediamBDDTBF1975', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$bdd = new PDO('mysql:host=localhost;dbname=tennisbefubddtbf;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		return $bdd;
	}
		catch(Exception $e)
	{
		// En cas d'erreur, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
}
