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
            //*************************************************************************************************************************************************
            //*                                         TRAITEMENT DE VERIFICATION DES DONNEES SAISIES
            //*************************************************************************************************************************************************
            if (isset($_POST['Email'])) {

                // Contrôle si adresse mail est une adresse valide
                //--------------------------------------------------
                $validEmail = preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['Email']);

                if ($validEmail == false) {
                    echo "<span class='warning'>The e-mail address " . $_POST['Email'] . " is not valid. Please enter a valid email address</span><br />";
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

                        echo "<span class='info'>You have been sent an e-mail to reset your password. Please check your mailbox.</span>";
                    }
                    else {
                        echo "<span class='warning'>The entered e-mail address " . $_POST['Email'] . " is not registered for this competition. Please enter the e-mail address your registered with.</span><br />";
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
                  You have forgotten your password?<br />
                  No worries, fill in your e-mail address and you will be sent a link to change it. <br />
              </p>
              <p>
                <form id="registration_form" action="mdpOublie.php" method="post" enctype="multipart/form-data">
                  <p>
                    E-email address: <input type="text" name="Email" required="required"/><br />
                    <input type="submit" value="Send link" />
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
