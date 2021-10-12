<?php


//************************************************************************************************************************************************************
//****************************************************** Connexion à la base dedonnées ***********************************************************************
//************************************************************************************************************************************************************

require("model_dbConnect.php");

//************************************************************************************************************************************************************
//****************************************************** Fonctions de séléction ******************************************************************************
//************************************************************************************************************************************************************


function controlPseudo($postPseudo) {
	$bdd = dbConnect();
	//$req = $bdd->prepare('SELECT * FROM joueur WHERE JOU_PSE = :Pseudo LIMIT 1'); // Limitation à une réponse (si on trouve le pseudo pas la peine d'aller plus loin, il faut choisir un autre pseudo)
	//$req->execute(array(
	//   	'Pseudo' => $_POST['Pseudo']));

	$req = $bdd->prepare('SELECT * FROM joueur WHERE JOU_PSE = ? AND JOU_ACTIVE = "1" LIMIT 1'); // Limitation à une réponse (si on trouve le pseudo pas la peine d'aller plus loin, il faut choisir un autre pseudo)
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
	// $req = $bdd->prepare('SELECT * FROM joueur WHERE JOU_ADR_MAIL = ? and JOU_PSE <> "Admin" LIMIT 1'); // Limitation à une réponse (si on trouve le pseudo pas la peine d'aller plus loin, il faut choisir un autre pseudo)
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

function selectBonusToModify($postPlayerId) {
	// Selection du match à pronostiquer
	$bdd = dbConnect();

    $req = $bdd->prepare("SELECT *
                              FROM pronostique_bonus
                             WHERE PROB_JOU_ID = ?");
	$req->execute(array($postPlayerId));

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
	$response = $bdd->query('SELECT JOU_ID, JOU_PSE FROM joueur WHERE JOU_PSE != "Admin" AND JOU_PSE != "Test"');

	return $response;
}


function getPlayersTournament() {
	// Rechercher le nombre de joueurs engagés dans le tournoi
	$bdd = dbConnect();
	$response = $bdd->query('SELECT count(*) AS NbPlayersTournament FROM players');

	return $response;
}

function getPlayersContest() {
	// Rechercher le nombre de participants au concours de pronostiques
	$bdd = dbConnect();
	$response = $bdd->query('SELECT count(*) AS NbPlayersContest FROM joueur WHERE JOU_PSE != "Admin" AND JOU_PSE != "Test"');

	return $response;
}


// function getAllPlayersTournament() {
function getAllPlayersTournament($param) {
	// Rechercher l'id du joueur créé
	$bdd = dbConnect();
//	$response = $bdd->query('SELECT * FROM players');
	if ($param == "disp") {
		$response = $bdd->query('SELECT * FROM players WHERE PLA_DISP <> "N" ORDER BY PLA_SEED_STRENGHT, PLA_NOM');
	} else {
		$response = $bdd->query('SELECT * FROM players');
	}

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
									 WHERE  PRO_MATCH_ID = RES_MATCH_ID
									   AND  PRO_JOU_ID = JOU_ID
									   AND  PRO_RES_MATCH = " "
										 AND  RES_MATCH = " "
										 AND  RES_MATCH_JOU1 <> "Bye"
										 AND  RES_MATCH_JOU1 <> " "
										 AND  RES_MATCH_JOU2 <> "Bye"
										 AND  RES_MATCH_JOU2 <> " "
										 AND  JOU_PSE <> "Admin"
										 AND  JOU_PSE <> "Test"
								ORDER BY  PRO_JOU_ID, RES_MATCH_POIDS_TOUR desc, RES_MATCH_DAT, RES_MATCH_TOUR_SEQ');

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
	$response = $bdd->query('SELECT * FROM joueur WHERE JOU_PSE != "Admin" AND JOU_PSE != "Test" ORDER BY JOU_DAT_INS desc LIMIT 0,5');

	return $response;
}


function getLastCreatedMatch() {
// Rechercher liID du dernier match créé
// + nom des joueurs. Cela va nous servir à savoir si il faut créer un nouveau match ou si il faut ajouter un joueur au match
	$bdd = dbConnect();
//    $response = $bdd->query('SELECT max(RES_MATCH_ID) as idMax, RES_MATCH_JOU1, RES_MATCH_JOU2 FROM resultats
//														 ORDER BY RES_MATCH_ID desc');
		$response = $bdd->query('SELECT RES_MATCH_ID, RES_MATCH_JOU1, RES_MATCH_JOU2 FROM resultats
														 ORDER BY RES_MATCH_ID desc');

	return $response;
}


function getNbRegistered() {
// Comptage du nb d'inscrits
	$bdd = dbConnect();
	$response = $bdd->query('SELECT count(*) AS nbInscrits FROM joueur WHERE JOU_PSE != "Admin" AND JOU_PSE != "Test"');

	return $response;
}



function getTable() {
// Affiche le classement des joueurs
	$bdd = dbConnect();
	$response = $bdd->query('SELECT * FROM joueur WHERE JOU_PSE != "Admin" AND JOU_PSE != "Test" ORDER BY JOU_TOT_PTS DESC, JOU_PTS_PRONO DESC, JOU_NB_RES_OK DESC, JOU_BONUS_VQR DESC, JOU_BONUS_FINAL DESC, JOU_BONUS_DF DESC, JOU_DAT_INS');

	return $response;
}



function getAllPrognosis() {
	$bdd = dbConnect();
	// $response = $bdd->query('SELECT *
  //                         FROM pronostique p
  //                   INNER JOIN resultats r
  //                           ON p.PRO_MATCH_ID = r.RES_MATCH_ID
  //                   INNER JOIN joueur j
  //                           ON p.PRO_JOU_ID = j.JOU_ID
  //                        WHERE p.PRO_MATCH_ID = r.RES_MATCH_ID
  //                          AND r.RES_MATCH <> ""
  //                     ORDER BY r.RES_MATCH_POIDS_TOUR ASC, r.RES_MATCH_DAT DESC, r.RES_MATCH_ID DESC, j.JOU_PSE ASC');
	$response = $bdd->query('SELECT *
                          FROM pronostique p
                    INNER JOIN resultats r
                            ON p.PRO_MATCH_ID = r.RES_MATCH_ID
                    INNER JOIN joueur j
                            ON p.PRO_JOU_ID = j.JOU_ID
                         WHERE p.PRO_MATCH_ID = r.RES_MATCH_ID
												   AND j.JOU_PSE <> "Admin"
													 AND j.JOU_PSE <> "Test"
                           AND r.RES_MATCH <> ""
													 AND r.RES_MATCH_JOU1 <> "Bye"
													 AND r.RES_MATCH_JOU2 <> "Bye"
                      ORDER BY r.RES_MATCH_POIDS_TOUR ASC, r.RES_MATCH_TOUR_SEQ ASC, j.JOU_PSE ASC');

	return $response;
}


function getAllBonus() {
	$bdd = dbConnect();
	$response = $bdd->query('SELECT *
                          FROM pronostique_bonus b
                    INNER JOIN joueur j
                            ON b.PROB_JOU_ID = j.JOU_ID
												 WHERE j.JOU_PSE <> "Admin"
												   AND j.JOU_PSE <> "Test"
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

	return $response;
}

function getDailyMatchs() {
	$bdd = dbConnect();
    //$reponse = $bdd->query('SELECT * FROM résultats WHERE RES_MATCH_DAT = CURDATE()');
    $response = $bdd->query('SELECT * FROM resultats, settings_tournament
    						  WHERE SUBSTR(RES_MATCH_DAT,1,10) >= SUBSTR(CURDATE(),1,10)
									  AND RES_MATCH_JOU1 <> ""
										AND RES_MATCH_JOU2 <> ""
										AND RES_MATCH_JOU1 <> "Bye"
										AND RES_MATCH_JOU2 <> "Bye"
    						    AND RES_MATCH = ""
    					   ORDER BY RES_MATCH_POIDS_TOUR DESC, RES_MATCH_DAT ASC, RES_MATCH_TOUR_SEQ ASC');

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
                         ORDER BY r.RES_MATCH_POIDS_TOUR ASC, r.RES_MATCH_TOUR_SEQ');

	return $response;
}


function getPrognosisToDo() {
	$bdd = dbConnect();
    //$response = $bdd->query('SELECT * FROM resultats
    //                               WHERE RES_MATCH = "" AND RES_MATCH_JOU1 != "" AND RES_MATCH_JOU2 != ""
    //                             ORDER BY RES_MATCH_DAT ASC');
    // $response = $bdd->query('SELECT * FROM resultats r INNER JOIN pronostique p
    // 									ON r.RES_MATCH_ID = p.PRO_MATCH_ID
    //                                  WHERE p.PRO_JOU_ID = "'.$_SESSION['JOU_ID'].'"
    //                                    AND r.RES_MATCH = ""
    //                                    AND r.RES_MATCH_JOU1 != ""
    //                                    AND r.RES_MATCH_JOU2 != ""
    //                                    AND p.PRO_RES_MATCH = ""
    //                             	 ORDER BY r.RES_MATCH_TOUR desc, r.RES_MATCH_TOUR_SEQ asc');
		 $response = $bdd->query('SELECT * FROM resultats r INNER JOIN pronostique p
	   									ON r.RES_MATCH_ID = p.PRO_MATCH_ID
	                                    WHERE p.PRO_JOU_ID = "'.$_SESSION['JOU_ID'].'"
	                                      AND r.RES_MATCH = ""
	                                      AND r.RES_MATCH_JOU1 != ""
	                                      AND r.RES_MATCH_JOU2 != ""
																				AND r.RES_MATCH_JOU1 != "Bye"
	                                      AND r.RES_MATCH_JOU2 != "Bye"
	                                      AND p.PRO_RES_MATCH = ""
	                               	 ORDER BY r.RES_MATCH_DAT, r.RES_MATCH_POIDS_TOUR, r.RES_MATCH_TOUR_SEQ');
	return $response;
}


function getResultsToEnter() {
	$bdd = dbConnect();
    $response = $bdd->query('SELECT * FROM resultats
 	                                WHERE RES_MATCH = "" AND RES_MATCH_JOU1 != "" AND RES_MATCH_JOU2 != ""
																 ORDER BY RES_MATCH_POIDS_TOUR DESC, RES_MATCH_DAT ASC, RES_MATCH_TOUR_SEQ ASC');
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

function getAllPtsBonusPrognosisPlayer($postPlayerId) {
	$bdd = dbConnect();

	$pts = $bdd->prepare('SELECT PROB_DEMI1_PTS
		                         + PROB_DEMI2_PTS
														 + PROB_DEMI3_PTS
														 + PROB_DEMI4_PTS as total_demi
														 , PROB_FINAL1_PTS
														 + PROB_FINAL2_PTS as total_finalist
														 , PROB_VQR_PTS as total_vqr
											 		FROM pronostique_bonus
 	        			   WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$pts->execute(array($postPlayerId));

	return $pts;
}

function getKey($pseudoValid) {
	$bdd = dbConnect();

	$req = $bdd->prepare("SELECT JOU_KEY, JOU_ACTIVE
													FROM joueur
												 WHERE JOU_PSE = ?
												 LIMIT 1");

	$req->execute(array($pseudoValid));

return $req;
}

function searchIfMatchExists($newPoids, $newSeq) {
	$bdd = dbConnect();

	// echo "function searchIfMatchExists() - newPoids=" . $newPoids . ", newSeq=" . $newSeq . "<br />";

	$matchExists = $bdd->prepare('SELECT * FROM resultats
 	        	              		   WHERE RES_MATCH_POIDS_TOUR = ?
																   AND RES_MATCH_TOUR_SEQ = ?
																	 ');

    // $matchExists = $bdd->prepare('SELECT * FROM resultats
  	//         	              		   WHERE RES_MATCH_POIDS_TOUR = "'.$newPoids.'"
 		// 														   AND RES_MATCH_TOUR_SEQ = "'.$newSeq.'"
 		// 															 ');

	$matchExists->execute(array($newPoids, $newSeq));

	return $matchExists;

}

function getSemiFinalists() {

	$bdd = dbConnect();
	$response = $bdd->query('SELECT * FROM resultats
 	                                WHERE RES_MATCH_POIDS_TOUR = 2
																 ORDER BY RES_MATCH_TOUR_SEQ ASC');
	return $response;

}

function getLastEnteredMatch() {
	$bdd = dbConnect();
	$response = $bdd->query('SELECT * FROM resultats
 	                                WHERE RES_MATCH_TMSTP = (SELECT MAX(RES_MATCH_TMSTP) FROM resultats)
																	  AND RES_MATCH <> ""');
	return $response;

}

function getMatchToCorrect($level, $Player1, $Player2) {
	$bdd = dbConnect();

	$matchToCorrect = $bdd->prepare('SELECT * FROM resultats
 	        	              		      WHERE RES_MATCH_TOUR = ?
																		  AND RES_MATCH_JOU1 = ?
																      AND RES_MATCH_JOU2 = ?
																	 ');

	$matchToCorrect->execute(array($level, $Player1, $Player2));

	return $matchToCorrect;
}

//************************************************************************************************************************************************************
//****************************************************** Fonctions d'insertion *******************************************************************************
//************************************************************************************************************************************************************

function insertPlayer() {
	$bdd = dbConnect();

	global $MotDePasseHache;
	global $key;

	//Chargement du nouvel inscrit en table MySQL
	$req = $bdd->prepare('INSERT INTO joueur (JOU_NOM, JOU_PRE, JOU_PSE, JOU_ADR_MAIL, JOU_MDP, JOU_COUNT, JOU_TOKEN, JOU_DAT_INS, JOU_PTS_PRONO, JOU_NB_RES_OK, JOU_BONUS_DF, JOU_BONUS_VQR, JOU_BONUS_FR_NOM, JOU_BONUS_FR_NIV, JOU_TOT_PTS, JOU_KEY, JOU_ACTIVE) VALUES (:Nom, :Prenom, :Pseudo, :Email, :MotDePasse, :Count, :Token, NOW(), :PointsPronos, :NbPronoOK, :BonusDemiFinalistes, :BonusVainqueur, :BonusMeilleurFrancais, :BonusNiveauMeilleurFrancais, :TotalPoints, :Key, :Active)');
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
		'TotalPoints' => 0,
		'Key' => $key,
		'Active' => 0));

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



// function createMatch() {
// 	$bdd = dbConnect();
//
// 	global $poidsTour;
//
//     //Création du nouveau match à pronostiquer
//     $req = $bdd->prepare('INSERT INTO resultats (RES_TOURNOI, RES_TYP_TOURNOI, RES_MATCH_DAT, RES_MATCH_TOUR, RES_MATCH_POIDS_TOUR, RES_MATCH_TOUR_SEQ, RES_MATCH_JOU1, RES_MATCH, RES_MATCH_TYP, RES_MATCH_SCR_JOU1, RES_MATCH_SCR_JOU2, RES_MATCH_JOU2) VALUES (:Tournoi, :Categorie, :DateMatch, :Niveau, :PoidsTour, :Sequence, :Joueur1, :ResultatMatch, :TypeResultatMatch, :ScoreJoueur1, :ScoreJoueur2, :Joueur2)');
//     $req->execute(array(
//         'Tournoi' => $_POST['Tournoi'],
//         'Categorie' => $_POST['Categorie'],
//         'DateMatch' => $_POST['DateMatch'],
//         'Niveau' => $_POST['Niveau'],
//         'PoidsTour' => $poidsTour,
// 				'Sequence' => $seq,
//         'Joueur1' => $_POST['Joueur1'],
//         'ResultatMatch' => "",
//         'TypeResultatMatch' => "",
//         'ScoreJoueur1' => 0,
//         'ScoreJoueur2' => 0,
//         'Joueur2' => $_POST['Joueur2']));
//
//     return $req;
// }
function createNextMatch() {
	$bdd = dbConnect();

	global $tournoi, $categorie, $newDateStr, $niveau, $newPoids, $newSeq, $newJou1, $newJou2;

    //Création du nouveau match à pronostiquer
    $req = $bdd->prepare('INSERT INTO resultats (RES_TOURNOI, RES_TYP_TOURNOI, RES_MATCH_DAT, RES_MATCH_TOUR, RES_MATCH_POIDS_TOUR, RES_MATCH_TOUR_SEQ, RES_MATCH_JOU1, RES_MATCH_JOU2, RES_MATCH, RES_MATCH_TYP, RES_MATCH_SCR_JOU1, RES_MATCH_SCR_JOU2, RES_MATCH_TMSTP) VALUES (:Tournoi, :Categorie, :DateMatch, :Niveau, :PoidsTour, :Sequence, :Joueur1, :Joueur2, :ResultatMatch, :TypeResultatMatch, :ScoreJoueur1, :ScoreJoueur2, now())');
    $req->execute(array(
        'Tournoi' => $tournoi,
        'Categorie' => $categorie,
        'DateMatch' => $newDateStr,
        'Niveau' => $niveau,
        'PoidsTour' => $newPoids,
				'Sequence' => $newSeq,
        'Joueur1' => $newJou1,
				'Joueur2' => $newJou2,
        'ResultatMatch' => "",
        'TypeResultatMatch' => "",
        'ScoreJoueur1' => 0,
        'ScoreJoueur2' => 0));

    return $req;
}


function createMatchFirstRound() {
	$bdd = dbConnect();

	global $nomTournoi, $typTournoi, $datePremierMatch, $level, $poids, $seq, $playerFirstRound;

    //Création du nouveau match à pronostiquer
    $req = $bdd->prepare('INSERT INTO resultats (RES_TOURNOI, RES_TYP_TOURNOI, RES_MATCH_DAT, RES_MATCH_TOUR, RES_MATCH_POIDS_TOUR, RES_MATCH_TOUR_SEQ, RES_MATCH_JOU1, RES_MATCH, RES_MATCH_TYP, RES_MATCH_SCR_JOU1, RES_MATCH_SCR_JOU2, RES_MATCH_JOU2, RES_MATCH_TMSTP) VALUES (:Tournoi, :Categorie, :DateMatch, :Niveau, :PoidsTour, :Sequence, :Joueur1, :ResultatMatch, :TypeResultatMatch, :ScoreJoueur1, :ScoreJoueur2, :Joueur2, now())');
    $req->execute(array(
        'Tournoi' => $nomTournoi,
        'Categorie' => $typTournoi,
        'DateMatch' => $datePremierMatch,
        'Niveau' => $level,
        'PoidsTour' => $poids,
				'Sequence' => $seq,
        'Joueur1' => $playerFirstRound,
        'ResultatMatch' => "",
        'TypeResultatMatch' => "",
        'ScoreJoueur1' => 0,
        'ScoreJoueur2' => 0,
        'Joueur2' => ""));

    return $req;
}


function dropTablePlayers() {
	$bdd = dbConnect();

	$response = $bdd->query('DROP TABLE players');

	return $response;
}


function createTablePlayers() {
	$bdd = dbConnect();

	$response = $bdd->query('CREATE TABLE players (
			PLA_ID INT(4) NOT NULL AUTO_INCREMENT,
			PLA_NOM VARCHAR(255) NOT NULL,
			PLA_PAY CHAR(3) NOT NULL,
			PLA_DISP CHAR (1) NOT NULL,
			PLA_SEED CHAR (2) NOT NULL,
			PLA_SEED_STRENGHT INT (2) NOT NULL,
			PRIMARY KEY (PLA_ID)
	)
	ENGINE=INNODB');

	return $response;
}

function loadTournamentPlayers($player, $pays, $display, $seed, $seedStrenght) {
	$bdd = dbConnect();

		//delete all record before loading
		//$del = $bdd->query('DELETE FROM players');
		//return $del;

    //insertion du joueur et du pays
    $req = $bdd->prepare('INSERT INTO players (PLA_NOM, PLA_PAY, PLA_DISP, PLA_SEED, PLA_SEED_STRENGHT) VALUES (:Name, :Pays, :Disp, :Seed, :SeedStrenght)');
    $req->execute(array(
        'Name' => $player,
        'Pays' => $pays,
				'Disp' => $display,
				'Seed' => $seed,
				'SeedStrenght' => $seedStrenght));

    return $req;
}
//*
//*
//*
//*
//*
//************************************************************************************************************************************************************
//****************************************************** Fonctions de mise à jour ****************************************************************************
//************************************************************************************************************************************************************
//*
//*
//*
//*
//*





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


// function updatePrognosis($postPlayerId, $postMatchId) {
function updatePrognosis($postPlayerId, $postMatchId, $result, $scoreJ1, $scoreJ2, $typeMatch) {

	$bdd = dbConnect();

	//echo "fonction updatePrognosis() : paramètres=" . $postPlayerId . " / " . $postMatchId . "<br />";
	//echo "Saisie=" . $_POST['VouD'] . " " . $_POST['ScoreJ1'] . "/" . $_POST['ScoreJ2'] . " (" . $_POST['TypeMatch'] . ")<br />";

	$req = $bdd->prepare('UPDATE pronostique
							 SET PRO_RES_MATCH = :Resultat, PRO_SCORE_JOU1 = :ScoreJoueur1, PRO_SCORE_JOU2 = :ScoreJoueur2, PRO_TYP_MATCH = :TypeMatch
						   WHERE PRO_JOU_ID = "'.$postPlayerId.'"
						     AND PRO_MATCH_ID = "'.$postMatchId.'"');

	// $req->execute(array(
	// 	'Resultat' => $_POST['VouD'],
	// 	'ScoreJoueur1' => $_POST['ScoreJ1'],
	// 	'ScoreJoueur2' => $_POST['ScoreJ2'],
	// 	'TypeMatch' => $_POST['TypeMatch']));
	$req->execute(array(
		'Resultat' => $result,
		'ScoreJoueur1' => $scoreJ1,
		'ScoreJoueur2' => $scoreJ2,
		'TypeMatch' => $typeMatch));

    return $req;
}


function updateResult($postMatchId) {
	$bdd = dbConnect();

	//Chargement des scores en table MySQL des résultats
	$req = $bdd->prepare('UPDATE resultats
							 SET RES_MATCH = :Resultat, RES_MATCH_SCR_JOU1 = :ScoreJoueur1, RES_MATCH_SCR_JOU2 = :ScoreJoueur2, RES_MATCH_TYP = :TypeMatch, RES_MATCH_TMSTP = now()
							   WHERE RES_MATCH_ID = "'.$postMatchId.'"');

	$req->execute(array(
		'Resultat' => $_POST['VouD'],
		'ScoreJoueur1' => $_POST['ScoreJ1'],
		'ScoreJoueur2' => $_POST['ScoreJ2'],
		'TypeMatch' => $_POST['TypeMatch']));

    return $req;
}

function updateDate($postMatchId) {
	$bdd = dbConnect();

	//Chargement des scores en table MySQL des résultats
	$req = $bdd->prepare('UPDATE resultats
							 SET RES_MATCH_DAT = :NewDateMatch, RES_MATCH_TMSTP = now()
							   WHERE RES_MATCH_ID = "'.$postMatchId.'"');

	$req->execute(array(
		'NewDateMatch' => $_POST['NewDateMatch']));

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

	echo 'Mise à jour en table SQL: ' . $postPlayerId . ' marque ' . $postPtsPrognosis . ' (nb pronos exact=' . $postAddNbExactPrognosis . ') + ' . $postPtsWinner . ' + ' . $postPtsFinalist . ' + ' . $postPtsSemi . ' + ' . $postPtsFrenchName . ' + ' . $postPtsFrenchLevel . '.<br />';

	$req = $bdd->exec('UPDATE joueur
 			              SET JOU_PTS_PRONO = "'.$postPtsPrognosis.'",
 			              	  JOU_NB_RES_OK = "'.$postAddNbExactPrognosis.'",
												JOU_BONUS_VQR = "'.$postPtsWinner.'",
 			              	  JOU_BONUS_FINAL = "'.$postPtsFinalist.'",
 			              	  JOU_BONUS_DF = "'.$postPtsSemi.'",
 			              	  JOU_BONUS_FR_NOM = "'.$postPtsFrenchName.'",
 			              	  JOU_BONUS_FR_NIV = "'.$postPtsFrenchLevel.'",
 			              	  JOU_TOT_PTS = JOU_PTS_PRONO+JOU_BONUS_DF+JOU_BONUS_FINAL+JOU_BONUS_VQR+JOU_BONUS_FR_NOM+JOU_BONUS_FR_NIV
   						WHERE JOU_ID = "'.$postPlayerId.'"');

							// $req = $bdd->exec('UPDATE joueur
						 	// 		              SET JOU_PTS_PRONO = "'.$postPtsPrognosis.'",
						 	// 		              	  JOU_NB_RES_OK = "'.$postAddNbExactPrognosis.'",
							// 											JOU_BONUS_VQR = JOU_BONUS_VQR+"'.$postPtsWinner.'",
						 	// 		              	  JOU_BONUS_FINAL = JOU_BONUS_FINAL+"'.$postPtsFinalist.'",
						 	// 		              	  JOU_BONUS_DF = JOU_BONUS_DF+"'.$postPtsSemi.'",
						 	// 		              	  JOU_BONUS_FR_NOM = JOU_BONUS_FR_NOM+"'.$postPtsFrenchName.'",
						 	// 		              	  JOU_BONUS_FR_NIV = JOU_BONUS_FR_NIV+"'.$postPtsFrenchLevel.'",
						 	// 		              	  JOU_TOT_PTS = JOU_PTS_PRONO+JOU_BONUS_DF+JOU_BONUS_FINAL+JOU_BONUS_VQR+JOU_BONUS_FR_NOM+JOU_BONUS_FR_NIV
						  //  						WHERE JOU_ID = "'.$postPlayerId.'"');

	//$req = $bdd->exec('UPDATE joueur
 	//		              SET JOU_PTS_PRONO = :Points, JOU_NB_RES_OK = :NbResultsOk, JOU_TOT_PTS = JOU_PTS_PRONO+JOU_BONUS_DF+JOU_BONUS_VQR+JOU_BONUS_FR_NOM+JOU_BONUS_FR_NIV
   	//					WHERE JOU_ID = "'.$postPlayerId.'"');
	//$req->execute(array(
	//	'Points' => JOU_PTS_PRONO+$postPtsPrognosis,
	//	'NbResultsOk' => JOU_NB_RES_OK+$postAddNbExactPrognosis));

    //return $req;
}


function updateBonusPrognosisSemi1Pts($postPlayerId, $postPtsSemi) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
 	        			  SET PROB_DEMI1_PTS = :Points
   						WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Points' => $postPtsSemi));

    //return $req;
}

function updateBonusPrognosisSemi2Pts($postPlayerId, $postPtsSemi) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
 	        			  SET PROB_DEMI2_PTS = :Points
   						WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Points' => $postPtsSemi));

    //return $req;
}

function updateBonusPrognosisSemi3Pts($postPlayerId, $postPtsSemi) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
 	        			  SET PROB_DEMI3_PTS = :Points
   						WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Points' => $postPtsSemi));

    //return $req;
}

function updateBonusPrognosisSemi4Pts($postPlayerId, $postPtsSemi) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
 	        			  SET PROB_DEMI4_PTS = :Points
   						WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Points' => $postPtsSemi));

    //return $req;
}

function updateBonusPrognosisFinal1Pts($postPlayerId, $postPtsFinalist) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
 	        			  SET PROB_FINAL1_PTS = :Points
   						WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Points' => $postPtsFinalist));

    //return $req;
}

function updateBonusPrognosisFinal2Pts($postPlayerId, $postPtsFinalist) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
 	        			  SET PROB_FINAL2_PTS = :Points
   						WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Points' => $postPtsFinalist));

    //return $req;
}

function updateBonusPrognosisWinnerPts($postPlayerId, $postPtsWinner) {
	$bdd = dbConnect();

	$req = $bdd->prepare('UPDATE pronostique_bonus
 	        			  SET PROB_VQR_PTS = :Points
   						WHERE PROB_JOU_ID = "'.$postPlayerId.'"');

	$req->execute(array(
		'Points' => $postPtsWinner));

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

function updateActive($player, $activeValue) {
	$bdd = dbConnect();

	global $pseudoValid;

	$req = $bdd->prepare('UPDATE joueur
							 SET JOU_ACTIVE = :Value
						   WHERE JOU_PSE = "'.$pseudoValid.'"');

	$req->execute(array(
		'Value' => $activeValue));

    return $req;
}

function updateMatchFirstRound($maxID, $playerFirstRound) {
//function updateMatchFirstRound($maxID) {
	$bdd = dbConnect();

	global $maxID, $playerFirstRound;

    //Création du nouveau match à pronostiquer
    $req = $bdd->prepare('UPDATE resultats
													SET RES_MATCH_JOU2 = :joueur2
													WHERE RES_MATCH_ID = "'.$maxID.'"');
    $req->execute(array(
        'joueur2' => $playerFirstRound));

    return $req;
}

function updateNextMatchJou1($newPoids, $newSeq, $newJou1) {
	$bdd = dbConnect();

	global $newPoids, $newSeq, $newJou1;

	$req = $bdd->prepare('UPDATE resultats
												SET RES_MATCH_JOU1 = :newPlayer
												WHERE RES_MATCH_POIDS_TOUR = "'.$newPoids.'"
												  AND RES_MATCH_TOUR_SEQ = "'.$newSeq.'"');

	$req->execute(array(
			'newPlayer' => $newJou1));

	return $req;

}

function updateNextMatchJou2($newPoids, $newSeq, $newJou2) {
	$bdd = dbConnect();

	global $newPoids, $newSeq, $newJou2;

	$req = $bdd->prepare('UPDATE resultats
												SET RES_MATCH_JOU2 = :newPlayer
												WHERE RES_MATCH_POIDS_TOUR = "'.$newPoids.'"
												  AND RES_MATCH_TOUR_SEQ = "'.$newSeq.'"');

	$req->execute(array(
			'newPlayer' => $newJou2));

	return $req;

}

//*
//*
//*
//*
//*
//************************************************************************************************************************************************************
//********************************************************** fonctions drop ********************************************************************************
//************************************************************************************************************************************************************
//*
//*
//*
//*
//*
function resetListPlayers() {

	$bdd = dbConnect();
	$response = $bdd->query('DELETE FROM players');
	return $response;
}



//*
//*
//*
//*
//*
//************************************************************************************************************************************************************
//********************************************************** Autres fonctions ********************************************************************************
//************************************************************************************************************************************************************
//*
//*
//*
//*
//*

function dateNextMatch($oldDate,$nbDays){

	echo "FUNCTION dateNextMatch() --> date avant: " . $oldDate . "<br />";
	$newDate = strtotime($oldDate) + (3600 * 24) * $nbDays;
	echo "FUNCTION dateNextMatch() --> date après: " . $newDate . "<br />";

	return $newDate;

}
