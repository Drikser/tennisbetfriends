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
	            Merci de vous inscrire au concours de pronostiques.<br />
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
	        		echo "<span class='warning'>Adresse " . $_POST['Email'] . " invalide, veuillez saisir une adresse valide !</span><br />";
	    		}

				// Contrôle si le mot de passe est valide
				//--------------------------------------------
				if ($validPassword == false) {
	        		echo "<span class='warning'>Le mot de passe saisit ne répond pas aux critères, merci d'en saisir un nouveau</span><br />";
	    		}

				// Si le pseudo existe, on demande d'en choisir un autre
				//-------------------------------------------------------
				if ($pseudo == true) {
					echo "<span class='warning'>Pseudo déjà existant, merci de choisir un autre pseudo</span><br />";
				}

				// Si le nom et le prénom existent, message d'erreur
				//----------------------------------------------------
				if ($name == true) {
					echo "<span class='warning'>Nom et prénom déjà existants ==> pas possible d'avoir plusieurs comptes</span><br />";
				}

				// Si le mail existe, on demande d'en choisir un autre
				//------------------------------------------------------
				if ($email == true) {
					echo "<span class='warning'>Adresse mail déjà existante ==> pas possible d'avoir plusieurs comptes</span><br />";
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
						echo "<span class='warning'>Les 2 mots de passe ne sont pas identiques. Merci de refaire la saisie</span><br />";
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

            $local = $_SERVER['REMOTE_ADDR']=='127.0.0.1' ? 1 : 0;
            if ($local = 1) {
              // Send message with localhost link (http://localhost/pronos/xxxxxxxxxx.php)
              include("inscriptionMailValidation_localhost.php");
            } else {
              // Send message with website link (http://www.tennisbetfriends.com/xxxxxxxxxx.php)
              include("inscriptionMailValidation.php");
            }

            // Message to refer player to their email address
						$pseudo = htmlspecialchars($_POST['Pseudo']);
            echo "<span class=info>Merci </span><b>" . $prenomValid . "</b><span class=info> pour ton inscrition.</span><br />";
            echo "<span class=info>Afin de finaliser ton inscription, un email t'as été envoyé. Merci de te rendre sur </span><b>" . htmlspecialchars($_POST['Email']) . "</b><span class=info> et de cliquer sur le lien d'activation reçu.</span><br />";

            //echo 'Bravo ' . htmlspecialchars($_POST['Prenom']) . ', ton inscrition a bien été prise en compte avec le pseudo suivant : ' . htmlspecialchars($_POST['Pseudo']) . '.<br />';
						//echo 'Bravo ' . htmlspecialchars($_POST['Prenom']) . ', ton inscrition a bien été prise en compte avec le pseudo suivant : ' . htmlspecialchars($_POST['Pseudo']) . ' (et le mot de passe suivant : ' . $_POST['MotDePasse'] . ') ... mais chuuuuuut faut pas le dire ... <br />';
						//echo 'Vérifie ton adresse mail ' . htmlspecialchars($_POST['Email']) . ', tu as dû recevoir un message de confirmation !<br />';


						//include ('creationEntreesTablePronostique2.php');

						//echo 'Tu peux maintenant te connecter : <a href="connexion.php">' . 'Connexion' . '</a><br/>';
					}
						//else
						//{
						//	echo "Nous n'avons pas pu t'inscrire pour une raison inconnue ... le webmaster a été informé et est en train de regarder le problème";
						//}
				}

			} else {
        ?>
        <!--
 	 		  //*************************************************************************************************************************************************
 			  //*                                         AFFICHAGE DU FORMAULAIRE D'INSCRIPTION
 			  //*************************************************************************************************************************************************
 			  -->
 			  <p>
 				Pour cela, veuillez renseigner les infos suivantes :
 			  </p>

 			  <form id="registration_form" action="inscription.php" method="post" enctype="multipart/form-data">
 			  <p>
          <label>Prénom : </label><input type="text" name="Prenom" label="Prenom" required="required"/><br />
 				  <label>Nom : </label><input type="text" name="Nom" label="Nom" required="required"/><br />
 				  <label>Pseudo : </label><input type="text" name="Pseudo" label="Pseudo" required="required"/> <b>(ATTENTION : Une fois inscrit, vous ne pourrez plus changer votre pseudo)</b><br />
 				  <label>Adresse mail : </label><input type="email" name="Email" label="Email" required="required"/><br />
 				  <label>Mot de passe : </label><input type="password" name="MotDePasse" required="required"/><br />
 				  <label>Confirmez mot de passe : </label><input type="password" name="MotDePasseConfirme" required="required"/><br />
          <b>NOTE : Le mot de passe doit faire au moins 8 caratères, avec une majuscule, une minuscule, un chiffre et un caractère spécial.</b>
 			  </p>

 			  <p>
 				  <input type="submit" value="Valider" />
 			  </p>
 			  </form>
        <?php
      }

			//*************************************************************************************************************************************************
			//*                                         AFFICHAGE DES DERNIERS INSCRITS + DU NB TOTAL D'INSCRITS
			//*************************************************************************************************************************************************
			echo '<br><br>Liste des 5 derniers pseudo inscrits : <br />' ;

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

			echo '<br />' . 'Nombre de personnes inscrites = ' . $donnees['nbInscrits'] . '<br />';
			if ($donnees['nbInscrits'] == 0) {
				echo 'Soyez la première personne à vous inscrire !<br />';
			}

			$sql_count->closeCursor(); // Termine le traitement de la requête
			?>


	    </div>

	</div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
