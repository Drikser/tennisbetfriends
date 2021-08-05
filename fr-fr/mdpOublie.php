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
                Vous avez oublié votre mot de passe ?<br />
                Pas d'inquiétudes, renseignez votre adresse email et il vous sera envoyé un lien pour pouvoir le changer. <br />
            </p>

            <?php
            //*************************************************************************************************************************************************
            //*                                         TRAITEMENT DE VERIFICATION DES DONNEES SAISIES
            //*************************************************************************************************************************************************
            if (isset($_POST['Email'])) {

                // Contrôle si adresse mail est une adresse valide
                //--------------------------------------------------
                $validEmail = preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['Email']);

                if ($validEmail == false) {
                    echo "<span class='warning'>Adresse " . $_POST['Email'] . " invalide, veuillez saisir une adresse valide !</span><br />";
                }
                else {
                    // Contrôle que l'email saisit existe bien en table
                    //------------------------------------------------------
                    $email = controlMail($_POST['Email']);

                    if ($email == true) {

                        $token = sha1($_POST['Email']+time());

                        //echo "token généré=" . $token . "<br />";

                        $firstName = $email['JOU_PRE'];
                        updateToken($_POST['Email'],$token);

                        include("mdpOublieMail.php");

                        echo "<span class='info'>Un email vous a été envoyé avec un lien pour réinitialiser votre mot de passe. Merci de vérifier vos emails.</span>";
                    }
                    else {
                        echo "<span class='warning'>Adresse email saisie " .  $_POST['Email'] . " n'est pas reconnue. Merci d'entrer l'adresse email avec laquelle vous vous êtes inscrit.</span><br />";
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
                <form id="registration_form" action="mdpOublie.php" method="post" enctype="multipart/form-data">
                  <p>
                    Adresse email : <input type="text" name="Email" required="required"/><br />
                    <input type="submit" value="Envoi lien" />
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
