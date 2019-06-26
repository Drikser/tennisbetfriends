<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <?php require("header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php include("entete.php"); ?>


    <div id="conteneur">


        <!-- Le menu -->

        <?php include("menu.php"); ?>

        <!-- Le corps -->

        <div class="element_corps" id="corps">

            <p>
                Bienvenue sur tennisbetfriends.com !<br />
                Ici c'est la page de connexion. Après vous êtes connecté, vous allez pouvoir faire vos pronostiques !!! <br />
            </p>

    		<!-- Connexion base de données -->

    		<?php
            //*************************************************************************************************************************************************
    		//*                                         APPEL PAGE CONNEXION BDD + FONCTIONS
    		//*************************************************************************************************************************************************
            //include("model.php");
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

            <?php
    		//*************************************************************************************************************************************************
    		//*                                         TRAITEMENT DE VERIFICATION DES DONNEES SAISIES
    		//*************************************************************************************************************************************************
            if (isset($_POST['PseudoConnexion'])) {

            	// Controle existance pseudo en base de donnée
    			$pseudo = controlPseudo($_POST['PseudoConnexion']);

    			if ($pseudo == false) {
    				echo "<span class='warning'>Pseudo non présent en base, vous devez vous inscrire avant de vous connecter ==> <a href='inscription.php'>Inscription</a></span><br />";
    			}
    			else {
    				// Si pseudo existe, contrôle du mot de passe
    				if (password_verify($_POST['MotDePasseConnexion'], $pseudo['JOU_MDP'])) {
    			    	echo 'Le mot de passe est valide !<br />';

    					$_SESSION['JOU_ID'] = $pseudo['JOU_ID'];
    					$_SESSION['JOU_PSE'] = $_POST['PseudoConnexion'];
    					//echo 'Bienvenue ' . $_POST['PseudoConnexion'] . ', vous êtes maintenant connecté !<br />';
    					echo 'Bienvenue ' . $_SESSION['JOU_PSE'] . ', vous êtes maintenant connecté !<br />';

    					header('Location: index.php');
    				}
    				else
    				{
    		    		echo "<span class='warning'>Le mot de passe est invalide.</span><br />";
    				}
    			}
            }
            ?>


        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("piedDePage.php"); ?>

    </body>
</html>
