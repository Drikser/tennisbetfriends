<?php
//Recherche des ID tous les pseudos crée
$reponse = $bdd->query('SELECT RES_MATCH_ID FROM resultats');

$nbRow = $reponse->rowcount();

if ($nbRow > 0)
{
while ($donnees = $reponse->fetch())
    {

		//Création du match à saisir pour tous les joueurs enregistrés
		$req = $bdd->prepare('INSERT INTO pronostique (PRO_JOU_ID, PRO_MATCH_ID, PRO_RES_MATCH, PRO_SCORE_JOU1, PRO_SCORE_JOU2, PRO_TYP_MATCH) VALUES (:IdJoueur, :IdMatch, :ResMatch, :ScoreJou1, :ScoreJou2, :TypMatch) WHERE PRO_JOU_ID != "Admin"');
		$req->execute(array(
			'IdJoueur' => $idjoueur,
			'IdMatch' => $donnees['RES_MATCH_ID'],
			'ResMatch' => "",
			'ScoreJou1' => 0,
			'ScoreJou2' => 0,
			'TypMatch' => ""));

		echo "joueur " . $idjoueur . " ajouté pour le match " . $donnees['RES_MATCH_ID'] . '<br />';

    }
}
else
{
    echo "Aucun match n'a encore été créé, vous ne pouvez pas pronostiquer tout de suite ... <br />";
}

?>
