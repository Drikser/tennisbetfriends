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
                Please enter your username and password to sign in.<br />
            </p>

            <?php
    		//*************************************************************************************************************************************************
    		//*                                         TRAITEMENT DE VERIFICATION DES DONNEES SAISIES
    		//*************************************************************************************************************************************************
            if (isset($_POST['PseudoConnexion'])) {

            	// Controle existance pseudo en base de donnée
        			$pseudo = controlPseudo($_POST['PseudoConnexion']);

        			if ($pseudo == false) {
                ob_start();
        				echo "<span class='warning'>Username not registered or account not activated.</span><br />";
                echo "<span class='warning'>Please register visiting the following page: <a href='inscription.php'>Register</a>, or check your email address and find your activation e-mail.</span><br />";
                ob_end_flush();
              }
        			else {
        				// Si pseudo existe, contrôle du mot de passe
        				if (password_verify($_POST['MotDePasseConnexion'], $pseudo['JOU_MDP'])) {
        			    //echo 'Le mot de passe est valide !<br />';

        					$_SESSION['JOU_ID'] = $pseudo['JOU_ID'];
        					$_SESSION['JOU_PSE'] = $_POST['PseudoConnexion'];
        					//echo 'Bienvenue ' . $_POST['PseudoConnexion'] . ', vous êtes maintenant connecté !<br />';
        					//echo 'Bienvenue ' . $_SESSION['JOU_PSE'] . ', vous êtes maintenant connecté !<br />';

        					header('Location: ../en-gb/index.php');
                  //exit();
        				}
        				else
        				{
        		    		echo "<span class='warning'>The password you entered is not valid.</span><br />";
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
                	<label>Username: </label><input type="text" name="PseudoConnexion" required="required"/><br />
                	<label>Password: </label><input type="password" name="MotDePasseConnexion" required="required" /><br />
                	<input type="submit" value="Valider" />
                </p>
    	        </form>

                <p>
                    Forgotten your password ? Click on this link to change it: <a href="mdpOublie.php">Forgotten password</a>
                </p>
            </p>

        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
