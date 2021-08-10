<?php
//$mail = htmlspecialchars($_POST['Email']); // Déclaration de l'adresse de destination.
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $emailValid)) // On filtre les serveurs qui rencontrent des bogues.
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
// Pour le test, l'addresse du lien commence par http://localhost/tennisbetfriends/www/en-gb/xxxxxxxxxx.php
// En production, l'addresse du lien commence par http://www.tennisbetfriends.com/xxxxxxxxxx.php
//
//----------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------



$message_txt = "Welcome to Tennis Bet Friends !";
$message_html = "
<html><head></head><body>Dear <var>$prenomValid</var>,<br />
<p>
Welcome to <i><a href='http://localhost/tennisbetfriends/www/en-gb/index.php'>www.tennisbetfriends.com</a></i>. Thanks for registering.
</p>
<p>
Your Username is: <b><var>$pseudoValid</var></b>.
</p>
<p>
To activate your account, please click on the link below
or copy and paste it into your browser.

<a href='http://localhost/tennisbetfriends/www/en-gb/inscriptionActivation.php?pseudo=$pseudoValid&key=$key'>http://localhost/tennisbetfriends/www/en-gb/inscriptionActivation.php?pseudo=$pseudoValid&key=$key</a>
</p>
<p>
<br />
--------------------------------------------------<br />
This is an automatic e-mail, please do not answer.<br />
--------------------------------------------------<br />
</p>
<br />
<i>Tennis Bet Friends</i>
</body></html>
";
//==========

//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========

//=====Définition du sujet.
$sujet = "Validate your registration on Tennis Bet Friends !";
//=========

//=====Création du header de l'e-mail.
$header = "From: \"Tennis Bet Friends\"<tennisbetfriends@gmail.com>".$passage_ligne;
$header.= "Reply-to: \"Tennis Bet Friends\" <tennisbetfriends@gmail.com>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========

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
//mail($mail,$sujet,$message,$header);
mail($emailValid,$sujet,$message,$header);
//==========
?>
