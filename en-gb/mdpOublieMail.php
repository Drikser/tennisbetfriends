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
// Pour le test, l'addresse du lien commence par http://localhost/pronos/en-gb/xxxxxxxxxx.php
// En production, l'addresse du lien commence par http://www.tennisbetfriends.com/xxxxxxxxxx.php
//
//----------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------



$message_txt = "Hello <var>$firstName</var>, ";
$message_html = "
<html><head></head><body>Hello <var>$firstName</var>,<br />
<br />
We received a request to change the password registered to your Tennisbetfriends account. <br />
If you are not the source of the password change, please contact the site of this site immediately. <br />
<p>
If you are the source of this change, please here is he link to reset your password: <a href=http://www.tennisbetfriends.com/en-gb/mdpInit.php?var=$token>http://www.tennisbetfriends.com/en-gb/mdpInit.php?var=$token</a>
</p>
Thank you for being registered on <i>www.tennisbetfriends.com</i>. <br />
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
$sujet = "Tennis Bet Friends, reset your password";
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
