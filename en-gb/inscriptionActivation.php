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
            // Get the variables needed for activation
            $pseudoValid = $_GET['pseudo'];
            $key = $_GET['key'];

            // Read the key in the Database
            $activation=getKey($pseudoValid);

            while ($donnees = $activation->fetch()) {
            //echo "Key=" . $donnees['JOU_KEY'] . " / Active=" . $donnees['JOU_ACTIVE'] . "<br />";

              if ($donnees['JOU_ACTIVE'] == '1') {
                echo "<span class='info'>Your account is already active. You should now be able to Log in.</span><br />";
              } else {
                if ($donnees['JOU_KEY'] == $key) {
                  updateActive($pseudoValid, '1');
                  echo "<span class='info'>Congratulations! Your account has been activated!</span><br />";
                } else {
                  echo "<span class='warning'>Error ! Your account cannot be activated, please contact the administrator ... </span><br />";
                  echo "<span class='warning'>We are sorry for the inconvenience caused.</span><br />";
                }
              }
            }
            ?>
        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
