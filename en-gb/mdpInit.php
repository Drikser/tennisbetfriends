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

            <?php
                //echo "variable = " . $_GET['var'];

            $token = $_GET['var'];

            //*************************************************************************************************************************************************
            //*                                         TRAITEMENT DE VERIFICATION DES DONNEES SAISIES
            //*************************************************************************************************************************************************
            // Vérification que les 2 mots de passe rentrés sont bien identiques

            if (isset($_POST['MotDePasse'])) {

                if ($_POST['MotDePasse'] != $_POST['MotDePasseConfirme']) {

                    echo "<span class='warning'>Your passwords don't match ==> Please enter your new password again</span><br />";
                }
                else {

                    // Contrôle que le token existe bien en table
                    //------------------------------------------------------
                    $ctrlToken = controlToken($token);

                    if ($ctrlToken == true) {

                        $MotDePasseHache = password_hash($_POST['MotDePasse'], PASSWORD_DEFAULT);

                        updatePwd($token);

                        echo "<span class='info'>Your password has been updated. You can now sign in visiting the page: </span><a href='connexion.php'>" . "Sign In" . "</a><br/>";
                    }
                    else {
                        echo "<span class='warning'>This link is not valid anymore. To reset your password, please use the 'Forgotten password' option on the Sign In page.</span><br />";
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
                  Please enter your new password: <br />
              </p>
              <p>
                <form id="resetPassword_form" action="mdpInit.php?var=<?php echo $token ?>" method="post" enctype="multipart/form-data">
                  <p>
                    <label>New password: </label><input type="password" name="MotDePasse" required="required"/><br />
                    <label>Confirm new password: </label><input type="password" name="MotDePasseConfirme" required="required"/><br />
                    <b>N.B.: The password must be at least 8 characters long, with an upper-case letter, a lower-case letter, a number and a special character.</b><br />
                    <input type="submit" value="Submit" />
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
