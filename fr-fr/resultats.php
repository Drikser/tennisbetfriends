<?php
session_start(); // On démarre la session AVANT toute chose
?>

<!DOCTYPE html>
<html>

    <?php require("../commun/header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php require("entete.php"); ?>

    <!-- Le menu -->

    <div id="conteneur">

        <?php require("menu.php"); ?>

        <!-- Le corps -->

        <div class="element_corps" id="corps">

    		<p>
        		<!-- Affichage du classement des joueurs -->
    	       	<?php include ("classementJoueurs.php"); ?>
    		</p>

            <p>
                <!-- Affichage des pronostiques bonus des joueurs -->
                <!-- Cette page contiend tous les résultats des pronostiques bonus de tous les joueurs -->
                <?php include ("affichageResultatsPronosBonus.php"); ?>
            </p>

            <p>
                <!-- Affichage des pronostiques des joueurs -->
                <!-- Cette page contiend tous les résultats des pronostiques de tous les joueurs, avec les points correspondant obtenus -->
                <?php include ("affichageResultatsPronosMatchs.php"); ?>
            </p>

        </div>
    </div>

    <!-- Le pied de page -->

    <?php require("../commun/piedDePAge.php"); ?>

    </body>
</html>
