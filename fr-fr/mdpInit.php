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
                Merci de renseigner votre nouveau mot de passe ci-dessous : <br />
            </p>

            <?php
                //echo "variable = " . $_GET['var'];

                $token = $_GET['var'];

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

                        echo "<span class='info'>Votre mot de passe a été mis à jour. Vous pouvez maintenant vous connecter en utilisant la page de connexion : </span> <a href='connexion.php'>" . "Connexion" . "</a><br/>";
                    }
                    else {
                        echo "<span class='warning'>Le lien utilisé n'est plus valide. Pour mettre à jour votre mot de passe, utilisez l'option 'Mot de passe oublié'.</span><br />";
                    }
                }
            } else {
              ?>
              <!--
       		    //*************************************************************************************************************************************************
      		    //*                                         AFFICHAGE DU FORMULAIRE POUR RENSEIGNER L'ADRESSE EMAIL
      		    //*************************************************************************************************************************************************
      		    -->
              <p>
                <form id="resetPassword_form" action="mdpInit.php?var=<?php echo $token ?>" method="post" enctype="multipart/form-data">
                  <p>
                    <label>Nouveau mot de passe  : </label><input type="password" name="MotDePasse" required="required"/><br />
                    <label>Confirmer : </label><input type="password" name="MotDePasseConfirme" required="required"/><br />
                    <b>NOTE : Le mot de passe doit faire au moins 8 caratères, avec une majuscule, une minuscule, un chiffre et un caractère spécial.</b><br />
                    <input type="submit" value="Valider" />
                  </p>
        	       </form>
                </p>
            <?php
            }
            ?>
        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
