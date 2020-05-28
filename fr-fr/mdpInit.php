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
                Merci de renseigner votre nouveau mot de passe ci-dessous : <br />
            </p>

            <?php
                //echo "variable = " . $_GET['var'];

                $token = $_GET['var'];
            ?>

            <!--
     		//*************************************************************************************************************************************************
    		//*                                         AFFICHAGE DU FORMULAIRE POUR RENSEIGNER L'ADRESSE EMAIL
    		//*************************************************************************************************************************************************
    		-->
    		<p>
                <form id="registration_form" action="mdpInit.php?var=<?php echo $token ?>" method="post" enctype="multipart/form-data">
                <p>
                    Nouveau mot de passe  : <input type="password" name="MotDePasse" required="required"/><br />
                    Confirmer le nouveau mot de passe : <input type="password" name="MotDePasseConfirme" required="required"/><br />
                    Note : Le mot de passe doit faire au moins 8 caratères, avec une majuscule, une minuscule, un chiffre et un caractère spécial<br />
                	<input type="submit" value="Valider" />
                </p>
    	        </form>

            </p>

            <?php
            //*************************************************************************************************************************************************
            //*                                         TRAITEMENT DE VERIFICATION DES DONNEES SAISIES
            //*************************************************************************************************************************************************
            // Vérification que les 2 mots de passe rentrés sont bien identiques

            if (isset($_POST['MotDePasse'])) {

                if ($_POST['MotDePasse'] != $_POST['MotDePasseConfirme']) {

                    echo "<span class='warning'>Les 2 mots de passe ne sont pas identiques. Merci de refaire la saisie</span><br />";
                }
                else {

                    // Contrôle que le token existe bien en table
                    //------------------------------------------------------
                    $ctrlToken = controlToken($token);

                    if ($ctrlToken == true) {

                        $MotDePasseHache = password_hash($_POST['MotDePasse'], PASSWORD_DEFAULT);

                        updatePwd($token);

                        echo "Votre mot de passe a été mis à jour. Vous pouvez maintenant vous connecter en utilisant la page de connexion : . <a href='connexion.php'>" . "Connexion" . "</a><br/>";
                    }
                    else {
                        echo "<span class='warning'>Le lien utilisé n'est plus valide. Pour mettre à jour votre mot de passe, utilisez l'option 'Mot de passe oublié'.</span><br />";
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
