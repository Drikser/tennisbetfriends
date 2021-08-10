<?php
// echo "préparation envoi mail pour " . $prenomValid . " à l'adresse " . $emailValid . "<br />";
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
// REMARQUE :
// Pour le test, l'addresse du lien commence par http://localhost/tennisbetfriends/www/fr-fr/xxxxxxxxxx.php
// En production, l'addresse du lien commence par http://www.tennisbetfriends.com/xxxxxxxxxx.php


$message_txt = "Bonjour, bienvenue sur Tennis Bet Friends !";
// echo "message txt = " . $message_txt . "<br />";

$message_html = "
<html><head></head><body>Cher <var>$prenomValid</var>, <br />
<p>
Bienvenue sur <i><a href='http://localhost/tennisbetfriends/www/fr-fr/index.php'>www.tennisbetfriends.com</a></i>. Merci de votre inscription.
</p>
<p>
Votre pseudo est : <b><var>$pseudoValid</var></b>.
</p>
<p>
Pour activer votre compte, veuillez cliquer sur le lien ci dessous
ou le copier/coller dans votre navigateur internet.

<a href='http://localhost/tennisbetfriends/www/fr-fr/inscriptionActivation.php?pseudo=$pseudoValid&key=$key'>http://localhost/tennisbetfriends/www/fr-fr/inscriptionActivation.php?pseudo=$pseudoValid&key=$key</a>
</p>
<p>
<br />
---------------------------------------------------------<br />
Ceci est un mail automatique, Merci de ne pas y répondre.<br />
---------------------------------------------------------<br />
</p>
<br />
<i>Tennis Bet Friends</i>
</body></html>
";
// echo "message html = " . $message_html . "<br />";
//==========

//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========

//=====Définition du sujet.
$sujet = "Validez votre inscription sur Tennis Bet Friends !";
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
// echo 'envoi email à ' . $emailValid . '<br />';
mail($emailValid,$sujet,$message,$header);
// var_dump(mail($emailValid,$sujet,$message,$header));
//==========
?>
