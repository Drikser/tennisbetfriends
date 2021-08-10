<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <?php require("../commun/header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php include("entete.php"); ?>


    <div id="conteneur">

	    <!-- Le menu -->

	    <?php include("menu.php"); ?>

	    <!-- Le corps -->

	    <div class="element_corps" id="corps">

	        <p>
	            Do you want to register for the predictions competition?<br />
	        </p>

			<?php
			//*************************************************************************************************************************************************
			//*                                         TRAITEMENT DE VERIFICATION DES DONNEES SAISIES
			//*************************************************************************************************************************************************

			if (isset($_POST['Nom']) OR isset($_POST['Prenom']) OR isset($_POST['Pseudo']) OR isset($_POST['Email'])) {
				// On vérifie la validité des champs saisit
				//$validNom = preg_match('#^[[:alpha:] \']+$#',$_POST['Nom']);
				//$validPrenom = preg_match('#^[[:alpha:] \']+$#',$_POST['Prenom']);
				$validEmail = preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['Email']);
				$validPassword = preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$#', $_POST['MotDePasse']);

				// On vérifie que le pseudo, nom, prénom, et mail n'existent pas déjà en table
				$pseudo = controlPseudo($_POST['Pseudo']);
				$name = controlName($_POST['Nom'], $_POST['Prenom']);
				$email = controlMail($_POST['Email']);

				// Contrôle si adresse mail est une adresse valide
				//--------------------------------------------------
				if ($validEmail == false) {
	        		echo "<span class='warning'>Invalid e-mail address ("  . $_POST['Email'] . ") ==> Please enter a valid e-mail address!</span><br />";
	    		}

				// Contrôle si le mot de passe est valide
				//--------------------------------------------
				if ($validPassword == false) {
	        		echo "<span class='warning'>Your password does not meet the security criteria ==> Please enter a new password</span><br />";
	    		}

				// Si le pseudo existe, on demande d'en choisir un autre
				//-------------------------------------------------------
				if ($pseudo == true) {
					echo "<span class='warning'>Existing username ==> Please chose another one</span><br />";
				}

				// Si le nom et le prénom existent, message d'erreur
				//----------------------------------------------------
				if ($name == true) {
					echo "<span class='warning'>Existing surname and first name ==> You cannot create more than one account</span><br />";
				}

				// Si le mail existe, on demande d'en choisir un autre
				//------------------------------------------------------
				if ($email == true) {
					echo "<span class='warning'>Existing e-mail address ==> You cannot create more than one account</span><br />";
				}


				if ($pseudo != true
				AND $name != true
				AND $email != true
				AND $validEmail != false
				AND $validPassword != false
				) {
					// 2°) Si le pseudo n'existe pas, création de l'enregistrement avec hachage du mot de passe

					// Vérification que les 2 mots de passe rentrés sont bien identiques
					if ($_POST['MotDePasse'] != $_POST['MotDePasseConfirme'])
					{
						echo "<span class='warning'>Your passwords don't match ==> Please enter your credential again</span><br />";
					}
					else {

						//Hachage du mot de passe
						$MotDePasseHache = password_hash($_POST['MotDePasse'], PASSWORD_DEFAULT);

						//***********************************************************************************
						//*            Insertion du joueur dans la table des joueurs
						//***********************************************************************************
            // Create a random key for the confirmation Email
            $key = md5(microtime(TRUE)*100000);

            // SQL statement
						insertPlayer();

						//***********************************************************************************
						//*                   Création des matchs à pronostiquer
						//***********************************************************************************
						//Si on a insérer le joueur en table joueur, on va lui créer ses matchs à pronostiquer si des matchs existent
						$playerId = getPlayerId($_POST['Pseudo']);
						//echo "Ton ID est le " . $playerId . '<br />';

						$allCreatedMatchsId = getAllCreatedMatchsId();

						while ($donnees = $allCreatedMatchsId->fetch()) {
							//echo "Avant appel fonction : joueur=" . $playerId . " / match=" . $donnees['RES_MATCH_ID'] . "<br />";
							createMatchToPrognosis($playerId, $donnees['RES_MATCH_ID']);
						}


						//***********************************************************************************
						//*              Création d'une ligne dans la table pronostique_bonus
						//***********************************************************************************
            if ($_POST['Pseudo'] != "Admin") {
              insertTournamentToPrognosis($playerId);
            }

            //***********************************************************************************
						//*            Send an email with link to validate the registration
						//***********************************************************************************
            // get variable for confirmation Email
            $emailValid = $_POST['Email'];
            $pseudoValid = $_POST['Pseudo'];
            $prenomValid = htmlspecialchars($_POST['Prenom']);

            // $local = $_SERVER['REMOTE_ADDR']=='127.0.0.1' ? 1 : 0;
            // if ($local = 1) {
            // echo 'HTTP HOST=' . $_SERVER['HTTP_HOST'] . '<br />';
            if ($_SERVER['HTTP_HOST'] == 'localhost') {
              // Send message with localhost link (http://localhost/pronos/xxxxxxxxxx.php)
              include("inscriptionMailValidation_localhost.php");
            } else {
              // Send message with website link (http://www.tennisbetfriends.com/xxxxxxxxxx.php)
              include("inscriptionMailValidation.php");
            }

            // Message to refer player to their email address
						$pseudo = htmlspecialchars($_POST['Pseudo']);
            echo "<span class='info'>Thank you </span><b>" . $prenomValid . "</b><span class='info'> for your registration.</span><br />";
            // echo "<span class='info'>Thank you </span>" . htmlspecialchars($_POST['Prenom']) . "<span class='info'> for your registration.</span><br />";
            echo "<span class='info'>To complete your registration, an e-mail has been sent to you. Please go to your e-mail address </span><b>" . htmlspecialchars($_POST['Email']) . "</b><span class='info'> and click on the activation link.</span><br />";

            //echo 'Bravo ' . htmlspecialchars($_POST['Prenom']) . ', ton inscrition a bien été prise en compte avec le pseudo suivant : ' . htmlspecialchars($_POST['Pseudo']) . '.<br />';
						//echo 'Bravo ' . htmlspecialchars($_POST['Prenom']) . ', ton inscrition a bien été prise en compte avec le pseudo suivant : ' . htmlspecialchars($_POST['Pseudo']) . ' (et le mot de passe suivant : ' . $_POST['MotDePasse'] . ') ... mais chuuuuuut faut pas le dire ... <br />';
						//echo 'Vérifie ton adresse mail ' . htmlspecialchars($_POST['Email']) . ', tu as dû recevoir un message de confirmation !<br />';


						//include ('creationEntreesTablePronostique2.php');

						//echo 'Tu peux maintenant te connecter : <a href="connexion.php">' . 'Connexion' . '</a><br/>';
					}
						//else
						//{
						//	echo "Nous n'avons pas pu t'inscrire pour une raison inconnue ... le webmaster a été informé et est en train de regarder le problème";
						//}1
				}

			} else {
        ?>
        <!--
 	 		//*************************************************************************************************************************************************
 			//*                                         AFFICHAGE DU FORMAULAIRE D'INSCRIPTION
 			//*************************************************************************************************************************************************
 			-->
 			  <p>
 				If yes, please provide the following information:
 			  </p>

 			  <form id="registration_form" action="inscription.php" method="post" enctype="multipart/form-data">
 			  <p>
          <label>First name: </label><input type="text" name="Prenom" label="Prenom" required="required"/><br />
 				  <label>Surname: </label><input type="text" name="Nom" label="Nom" required="required"/><br />
 				  <label>Username: </label><input type="text" name="Pseudo" label="Pseudo" required="required"/> <b>(Please note that once you have registered you will no longer be able to change your username)</b><br />
 				  <label>E-mail Address: </label><input type="email" name="Email" label="Email" required="required"/><br />
 				  <label>Password: </label><input type="password" name="MotDePasse" required="required"/><br />
 				  <label>Confirm your password: </label><input type="password" name="MotDePasseConfirme" required="required"/><br />
 				  <b>N.B: The password must be at least 8 characters long, with an upper-case letter, a lower-case letter, a number and a special character.</b>
 			  </p>

 			  <p>
 				<input type="submit" value="Submit" />
 			  </p>
 			  </form>
        <?php
      }

			//*************************************************************************************************************************************************
			//*                                         AFFICHAGE DES DERNIERS INSCRITS + DU NB TOTAL D'INSCRITS
			//*************************************************************************************************************************************************
			echo '<br><br>Last 5 registered usernames: <br />' ;

			$lastPseudo = getLastPseudo();

			while ($donnees = $lastPseudo->fetch())
			{
			?>
				<strong>Pseudo</strong> : <?php echo $donnees['JOU_PSE'] . ' (' . $donnees['JOU_DAT_INS'] . ')'; ?><br />
			<?php
			}

			//$response->closeCursor(); // Termine le traitement de la requête

			// affichier le nb de personnes inscrites au concours :
			$sql_count = getNbRegistered();

			$donnees = $sql_count->fetch();
			//$nbInscrits = $donnees['nbInscrits'];

			echo '<br />' . 'Number of registered users = ' . $donnees['nbInscrits'] . '<br />';
			if ($donnees['nbInscrits'] == 0) {
				echo 'Be the first to register!<br />';
			}

			$sql_count->closeCursor(); // Termine le traitement de la requête
			?>


	    </div>

	</div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
