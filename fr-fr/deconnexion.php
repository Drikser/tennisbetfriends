<?php
session_start(); // On démarre la session AVANT toute chose
unset($_SESSION['JOU_ID']);
unset($_SESSION['JOU_PSE']);
?>


<!DOCTYPE html>
<html>

    <?php require("../commun/header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php include("entete.php"); ?>

    <!-- Le menu -->

    <?php include("menu.php"); ?>

    <!-- Le corps -->

    <?php
    header('Location: ../fr-fr/index.php');
    ?>

    <div id="corps">
        <h1>tennisbetfriends.com</h1>

        <p>
            Bienvenue sur tennisbetfriends.com !<br />
            Vous avez fini votre session. Merci et à bientôt ! <br />
        </p>

        <?php

            //if isset($_SESSION['JOU_ID'])
            //{
                // Si tu es connecté on te déconnecte.

                // Supression des variables de session et de la session
                $_SESSION = array();
                session_destroy();

                // Supression des cookies de connexion automatique --> Pas encore de cookies donc en commentaire
                //setcookie('login', '');
                //setcookie('pass_hache', '');

                // No need
                //echo "Alleeeez, tchuuuuuussssssss !!!";


                //$nbfois == 1;
                //while ($nbfois <= 1)
                //{
                //    header('Location: index.php');
                //    $nbfois ++;
                //}
            //}
            //else
            //{ // Dans le cas contraire on t'empêche d'accéder à cette page en te redirigeant vers la page que tu veux.
            //    echo "Tu n'étais même pas connecté, ça sert à rien de se déconnecter ;-)<br />";
            //}

        ?>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
