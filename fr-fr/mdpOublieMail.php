<?php
$mail = htmlspecialchars($_POST['Email']); // Déclaration de l'adresse de destination.
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
	$passage_ligne = "\r\n";
}
else
{
	$passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.

//----------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------
//
// REMARQUE :
// Pour le test, l'addresse du lien commence par http://localhost/tennisbetfriends/www/fr-fr/xxxxxxxxxx.php
// En production, l'addresse du lien commence par http://www.tennisbetfriends.com/xxxxxxxxxx.php
//
//----------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------



$message_txt = "Bonjour <var>$firstName</var>, ";
$message_html = "
<html><head></head><body>Bonjour <var>$firstName</var>,<br />
<br />
Nous avons reçu une demande pour réinitialiser votre mot de passe de votre compte Tennisbetfriends. <br />
Si vous n'êtes pas à l'origine de ce changement, merci de contacter immédiatement l'administrateur de ce site.<br />
<p>
Si vous êtes à l'origine de cette demande, voici le lien pour définir un nouveau mot de passe : <a href=http://localhost/tennisbetfriends/www/fr-fr/mdpInit.php?var=$token>http://localhost/tennisbetfriends/www/fr-fr/mdpInit.php?var=$token</a><br />
</p>
Merci d'être inscrit sur <i>www.tennisbetfriends.com</i>. <br />
<br />
<br />
Tennis Bet Friends
</body></html>
";
//==========

//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========

//=====Définition du sujet.
$sujet = "Tennis Bet Friends, réinitialisation de mot de passe";
//=========

//=====Création du header de l'e-mail.
$header = "From: \"Tennis Bet Friends\"<tennisbetfriends@gmail.com>".$passage_ligne;
$header.= "Reply-to: \"Tennis Bet Friends\" <tennisbetfriends@gmail.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;//==========

//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
//$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
//$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========

//=====Envoi de l'e-mail.
mail($mail,$sujet,$message,$header);
//==========
?>
