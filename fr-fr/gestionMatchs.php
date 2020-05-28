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
            <h1>Le coin de l'Admin</h1>

            <!--
            //*************************************************************************************************************************************************
        		//*                                         CHARGEMENT TABLE DES JOUEURS
        		//*************************************************************************************************************************************************
            -->

            <!-- <p>
                Télécharger tous les joueurs :<br />
            </p> -->
            <h2>Télécharger tous les joueurs :</h2>

            <p>
              <form action="loadPlayersList.php" method="post" enctype="multipart/form-data">
                <input type="submit" value="Télécharger" />
              </form>
            </p>

            <!--
            //*************************************************************************************************************************************************
            //*                                         CREATION DES MATCHS DU PREMIER TOUR
            //*************************************************************************************************************************************************
            -->
            <!-- <p>
              Création des matchs du premier tour :<br />
            </p> -->
            <h2>Création des matchs du premier tour :</h2>

            <p>
              <form action="creatFirstRoundMatches.php" method="post" enctype="multipart/form-data">
                <input type="submit" value="Créer" />
              </form>
            </p>

            <!--
            //*************************************************************************************************************************************************
            //*                                         SAISIE DES RESULTATS DES MATCHS
            //*************************************************************************************************************************************************
            -->
            <!-- <p>
              Création des matchs du premier tour :<br />
            </p> -->
            <h2>Saisie du résultat des matchs :</h2>

        		<?php
            if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']) AND $_SESSION['JOU_PSE']=="Admin") {

                $hrefParametre = "";
                echo "Paramètre pour GET avant test = " . $hrefParametre . "<br />";

                if ($_SESSION['JOU_PSE'] == "Admin") {
                  // $hrefParametre = "saisieResultat.php?ResMatchId=";
                  $hrefParametre = "gestionMatchs.php?ResMatchId=";
                }
                else {
                  $hrefParametre = "pronostique.php?ResMatchId=";
                }

                echo "Paramètre pour GET après test = " . $hrefParametre . "<br />";

                echo "<br />Le(s) prochain(s) match(s) est(sont) :<br />";

                //$reponse = $bdd->query('SELECT * FROM résultats WHERE RES_MATCH_DAT = CURDATE()');
                //$reponse = $bdd->query('SELECT * FROM résultats WHERE RES_MATCH_DAT >= CURDATE() AND RES_MATCH = ""'); //en commentaire le temps des tests

                $response = getResultsToEnter();

                while ($donnees = $response->fetch()) {

                  $idSessionJoueur = $_SESSION['JOU_ID'];
                  //echo "Id du pseudo=" . $idSessionJoueur . " (" . $_SESSION['JOU_PSE'] . ")<br />";

                  $matchASaisir = $donnees['RES_MATCH_ID'];
                  //echo "Match à saisir = " . $matchASaisir . "<br />";

                  if ($_SESSION['JOU_PSE'] == "Admin") {

                        // Si on clique sur "saisie du résultat", renvoi vers ancre "FinListeMatchs"
                      // echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=saisieResultat.php?ResMatchId=" . $matchASaisir . "#FinListeMatchs>" . " Saisir le score" . "</a><br />";
                      // echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " (" . $donnees['RES_MATCH_TOUR_SEQ'] . ") : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=gestionMatchs.php?ResMatchId=" . $matchASaisir . "#FinListeMatchs>" . " Saisir le score" . "</a><br />";
                    echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " (" . $donnees['RES_MATCH_TOUR_SEQ'] . ") : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=gestionMatchs.php?ResMatchId=" . $matchASaisir . "#FinListeMatchs>" . " Saisir le score" . "</a>" . " / " . "<a href=gestionMatchs.php?ResMatchId=" . $matchASaisir . "#FinListeMatchs>" . " Modifier la date" . "</a><br />";
                  }
                  else {
                      echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=pronostique.php?ResMatchId=" . $matchASaisir . ">" . " Saisir le score" . "</a><br />";
                  }
                }

                ?>

                <!-- creation nouvelle div pour créer une ancre et renvoyer vers cette ancre lors de la saisie d'un résultat -->
                <!-- ancre renvoi vers la fin de la liste des matchs pour pouvoir tomber directement sur la saisie -->
                <div id="FinListeMatchs"></div>

                <?php


                if (isset($_GET['ResMatchId'])) {

                  echo "<br /> SAISIE RESULTAT A FAIRE :<br />";

                  $idSessionJoueur = $_SESSION['JOU_ID'];
                  echo "pseudo=" . $idSessionJoueur . "<br />";
                  echo "Id du match à saisir: " . $_GET['ResMatchId'] . "<br />";

                  $matchChoisi = getResultToEnter($_GET['ResMatchId']);

                  while ($donnees = $matchChoisi->fetch()) {
                    //	echo $donnees['RES_MATCH_ID'] . " - " . $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_TOURNOI'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs " . $donnees['RES_MATCH_JOU2'] . "<br />";

                    include ("formulairePronostiqueMatchASaisir.php");
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
