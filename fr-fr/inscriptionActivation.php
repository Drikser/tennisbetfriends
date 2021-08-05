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
                echo "<span class='info'>Votre compte est déjà activé. Vous devriez pouvoir vous connecter dès maintenant.</span><br />";
              } else {
                if ($donnees['JOU_KEY'] == $key) {
                  updateActive($pseudoValid, '1');
                  echo "<span class='info'>Félicitations ! Votre compte est désormais activé ! </span><br />";
                  echo "<span class='info'>Rendez vous dès à présent sur la page de connection pour commencer vos pronostiques. </span><br />";
                } else {
                  echo "<span class='warning'>Erreur ! Votre compte ne peut être activé. Merci de contacter l'administrateur.</span><br />";
                  echo "<span class='warning'>Nous vous prions de nous excuser pour la gêne occasionnée.</span><br />";
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
