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
                Pour vous connecter, merci de renseigner vos identifiants.<br />
            </p>

            <?php
    		//*************************************************************************************************************************************************
    		//*                                         TRAITEMENT DE VERIFICATION DES DONNEES SAISIES
    		//*************************************************************************************************************************************************
            if (isset($_POST['PseudoConnexion'])) {

            	// Controle existance pseudo en base de donnée
        			$pseudo = controlPseudo($_POST['PseudoConnexion']);

        			if ($pseudo == false) {
        				echo "<span class='warning'>Pseudo non présent en base ou compte non activé.</span><br />";
                echo "<span class='warning'>Inscrivez-vous en suivant ce lien: <a href='inscription.php'>Inscription</a>, ou vérifiez votre adresse email pour trouver votre email d'activation.</span><br />";
        			}
        			else {
        				// Si pseudo existe, contrôle du mot de passe
        				if (password_verify($_POST['MotDePasseConnexion'], $pseudo['JOU_MDP'])) {
        			    //echo 'Le mot de passe est valide !<br />';

        					$_SESSION['JOU_ID'] = $pseudo['JOU_ID'];
        					$_SESSION['JOU_PSE'] = $_POST['PseudoConnexion'];
        					//echo 'Bienvenue ' . $_POST['PseudoConnexion'] . ', vous êtes maintenant connecté !<br />';
        					//echo 'Bienvenue ' . $_SESSION['JOU_PSE'] . ', vous êtes maintenant connecté !<br />';
        					header('Location: ../fr-fr/index.php');
                  //exit();
        				}
        				else
        				{
        		    		echo "<span class='warning'>Le mot de passe entré est invalide.</span><br />";
        				}
        			}
            }
            ?>

        <!--
     		//*************************************************************************************************************************************************
    		//*                                         AFFICHAGE DU FORMULAIRE DE CONNEXION
    		//*************************************************************************************************************************************************
    		-->
    		    <p>
                <form id="connection_form" action="connexion.php" method="post">
                <p>
                	<label>Pseudo : </label><input type="text" name="PseudoConnexion" required="required"/><br />
                	<label>Mot de passe : </label><input type="password" name="MotDePasseConnexion" required="required" /><br />
                	<input type="submit" value="Valider" />
                </p>
    	        </form>

                <p>
                    Vous avez oublié votre mot de passe ? Cliquez sur ce lien pour le changer : <a href="mdpOublie.php">Mot de passe oublié</a>
                </p>
            </p>
        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
