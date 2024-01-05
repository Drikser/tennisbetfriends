<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <div id="HautDePage"></div>

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

            <a href="#chargementJoueursAvantTournoi">Télécharger joueurs avant le tournoi</a>
            <br /><a href="#telechargerTousLesJoueurs">Télécharger tous les joueurs</a>
            <br /><a href="#creationMatchsPremierTour">Création des matchs du premier tour</a>
            <br /><a href="#saisieResultat">Saisie du résultat des matchs</a>
            <br /><a href="#correctionResultat">Correction d'un résultat</a>
            <!--
            //*************************************************************************************************************************************************
        		//*                                         CHARGEMENT TABLE DES JOUEURS
        		//*************************************************************************************************************************************************
            -->

            <!-- <p>
                Chargement avant tournoi :<br />
            </p> -->
            <div id="chargementJoueursAvantTournoi"></div>
            <h2>Chargement initial des joueurs avant tournoi (les 8 meilleurs):</h2>

            <p>
              <form action="loadPlayersListInitial.php" method="post" enctype="multipart/form-data">
                <input type="submit" value="Télécharger 8 premères têtes de série" />
                <!-- <input type="submit" value="Reset liste des joueurs" /> -->
              </form>

              <form action="gestionMatchs.php" method="post" enctype="multipart/form-data">
                <input type="text" name="Reset" label="Reset" required="required" /><br />
                <input type="submit" value="Reset liste des joueurs" /> (entrer "Reset" dans la ligne de saisie ci-dessus)
              </form>
            </p>

            <?php
            if (isset($_POST['Reset']) AND ($_POST['Reset'] == 'Reset')) {
              resetListPlayers();
              echo '<br />Liste des joueurs éffacée. Table vide.<br />';
            }
            ?>



            <!-- <p>
                Télécharger tous les joueurs :<br />
            </p> -->
            <div id="telechargerTousLesJoueurs"></div>
            <h2>Télécharger tous les joueurs :</h2>

            <p>
              <span class='warning'>Vérifier si Christopher O'Connell est dans le tableau (ou nom avec apostrophe) !!!</span><br />
              <span class='warning'>Si OUI, modifier loadPlayerList.php avant de charger tous les joueurs ! </span><br />
              <span class='warning'>Si NON, ok pour télécharger les joueurs </span>
            </p>

            <p>
              <form action="loadPlayersList.php" method="post" enctype="multipart/form-data">
                <input type="submit" value="Télécharger joueurs" />
                <!-- <input type="submit" value="Reset liste des joueurs" /> -->
              </form>

              <form action="gestionMatchs.php" method="post" enctype="multipart/form-data">
                <input type="text" name="Reset" label="Reset" required="required" /><br />
                <input type="submit" value="Reset liste des joueurs" /> (entrer "Reset" dans la ligne de saisie ci-dessus)
              </form>
            </p>

            <?php
            if (isset($_POST['Reset']) AND ($_POST['Reset'] == 'Reset')) {
              resetListPlayers();
              echo '<br />Liste des joueurs éffacée. Table vide.<br />';
            }
            ?>

            <!--
            //*************************************************************************************************************************************************
            //*                                         CREATION DES MATCHS DU PREMIER TOUR
            //*************************************************************************************************************************************************
            -->
            <!-- <p>
              Création des matchs du premier tour :<br />
            </p> -->
            <div id="creationMatchsPremierTour"></div>
            <h2>Création des matchs du premier tour :</h2>

            <p>
              <form action="creatFirstRoundMatches.php" method="post" enctype="multipart/form-data">
                <input type="submit" value="Créer" />
              </form>
            </p>

            <!--
            //*************************************************************************************************************************************************
            //*                                         SUIVI DES PRONOSTIQUES DES JOUEURS
            //*************************************************************************************************************************************************
            -->
            <!-- <p>
              Création des matchs du premier tour :<br />
            </p> -->
            <div id="suiviPronostiquesJoueurs"></div>
            <h2>Suivi pronostique des joueurs :</h2>

            <?php include ("suiviPronostiquesJoueurs.php"); ?>

            (<a href="#HautDePage">Haut</a>)
            <!--
            //*************************************************************************************************************************************************
            //*                                         SAISIE DES RESULTATS DES MATCHS
            //*************************************************************************************************************************************************
            -->
            <!-- <p>
              Création des matchs du premier tour :<br />
            </p> -->
            <div id="saisieResultat"></div>
            <h2>Saisie du résultat des matchs :</h2>

        		<?php
            if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']) AND $_SESSION['JOU_PSE']=="Admin") {

                $response = getResultsToEnter();
                $niveauPrecedent = "";

                while ($donnees = $response->fetch()) {

                  $idSessionJoueur = $_SESSION['JOU_ID'];
                  //echo "Id du pseudo=" . $idSessionJoueur . " (" . $_SESSION['JOU_PSE'] . ")<br />";

                  $matchASaisir = $donnees['RES_MATCH_ID'];
                  //echo "Match à saisir = " . $matchASaisir . "<br />";
                  if ($niveauPrecedent != $donnees['RES_MATCH_TOUR']) {
                    echo "<br />" . $donnees['RES_MATCH_TOUR'] . "<br />";
                  };

                  if ($_SESSION['JOU_PSE'] == "Admin") {

                      // Si on clique sur "saisie du résultat", renvoi vers ancre "FinListeMatchs"
                      // echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=saisieResultat.php?ResMatchId=" . $matchASaisir . "#FinListeMatchs>" . " Saisir le score" . "</a><br />";
                      // echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " (" . $donnees['RES_MATCH_TOUR_SEQ'] . ") : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=gestionMatchs.php?ResMatchId=" . $matchASaisir . "#FinListeMatchs>" . " Saisir le score" . "</a><br />";
                    echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " (" . $donnees['RES_MATCH_TOUR_SEQ'] . ") : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=gestionMatchs.php?ResMatchId=" . $matchASaisir . "&Action=Score#FinListeMatchs>" . " Saisir le score" . "</a>" . " / " . "<a href=gestionMatchs.php?ResMatchId=" . $matchASaisir . "&Action=Date#FinListeMatchs>" . " Modifier la date" . "</a><br />";

                    $niveauPrecedent = $donnees['RES_MATCH_TOUR'];
                  }
                  else {
                      echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=pronostique.php?ResMatchId=" . $matchASaisir . ">" . " Saisir le score" . "</a><br />";

                      $niveauPrecedent = $donnees['RES_MATCH_TOUR'];
                  }
                }

                ?>

                <!-- creation nouvelle div pour créer une ancre et renvoyer vers cette ancre lors de la saisie d'un résultat -->
                <!-- ancre renvoi vers la fin de la liste des matchs pour pouvoir tomber directement sur la saisie -->
                <div id="FinListeMatchs"></div>

                <?php

                if (isset($_GET['ResMatchId'])) {

                  $idSessionJoueur = $_SESSION['JOU_ID'];
                  echo "<br />";
                  echo "pseudo = " . $idSessionJoueur . "<br />";
                  echo "Id du match à saisir = " . $_GET['ResMatchId'] . "<br />";
                  echo "Action = " . $_GET['Action'] . "<br />";

                  if ($_GET['Action'] == 'Score') {

                    echo "<br /> SAISIE RESULTAT A FAIRE :<br />";

                    $matchChoisi = getResultToEnter($_GET['ResMatchId']);

                    while ($donnees = $matchChoisi->fetch()) {
                      //	echo $donnees['RES_MATCH_ID'] . " - " . $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_TOURNOI'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs " . $donnees['RES_MATCH_JOU2'] . "<br />";
                      $GLOBALS['pageOrigine'] = 'gestionMatchs_saisie';
                        // include ("formulairePronostiqueMatchASaisir.php");
                        include ("formulairePronostiqueMatchASaisirNoJoker.php");
                    }

                  } else {

                    echo "<br /> NOUVELLE DATE DU MATCH :<br />";

                    $matchChoisi = getResultToEnter($_GET['ResMatchId']);

                    while ($donnees = $matchChoisi->fetch()) {
                      //	echo $donnees['RES_MATCH_ID'] . " - " . $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_TOURNOI'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs " . $donnees['RES_MATCH_JOU2'] . "<br />";
                      $GLOBALS['pageOrigine'] = 'gestionMatchs_saisie';
                      include ("formulairePronostiqueDateAChanger.php");
                    }
                  }


                }

            }
            ?>

            (<a href="#HautDePage">Haut</a>)

            <!--
            //*************************************************************************************************************************************************
            //*                                         RECHERCHE DU RESULTAT A CORRIGER
            //*************************************************************************************************************************************************
            -->
            <!-- <p>
              Création des matchs du premier tour :<br />
            </p> -->
            <div id="correctionResultat"></div>
            <h2>Correction d'un résultat :</h2>

            <!--
            //*** BOUT DE CODE AVEC TEST SI ON A CLIQUE SUR DERNIER MATCH Saisie
            //*** DOIT AVOIR LE FORMULAIRE DU MATCH A CORRIGER AU LIEU DU FORMULAIRE DE CHOIX DU MATCH A CORRIGER
            -->
            <div id="MatchACorriger"></div>


            <?php
            if (isset($_POST['TypeCorrection'])) {

              switch ($_POST['TypeCorrection']) {
                case 'LastMatch':
                  echo 'TypeCorrection avant init =' .  $_POST['TypeCorrection'] . '<br />';
                  $_POST['TypeCorrection']  = "";
                  echo 'TypeCorrection après init =' .  $_POST['TypeCorrection'] . '<br />';

                  echo "<br />Match à corriger :<br />";

                  //$matchToModify = selectMatchToModify($_SESSION['JOU_ID'], $_GET['ResMatchId']);
                  $lastMatchSaisi = getLastEnteredMatch();

                  while ($donnees = $lastMatchSaisi->fetch()) {

                      $IdLastEnteredMatch = $donnees['RES_MATCH_ID'];
                      echo "ID du dernier match saisi=" . $IdLastEnteredMatch;

                      $GLOBALS['pageOrigine'] = 'gestionMatchs_correction';
                      // include ("formulairePronostiqueMatchASaisir.php");
                      include ("formulairePronostiqueMatchASaisirNoJoker.php");
                  }
                  break;

                case 'SelectedMatch':
                    echo 'TypeCorrection avant init =' .  $_POST['TypeCorrection'] . '<br />';
                    $_POST['TypeCorrection']  = "";
                    echo 'TypeCorrection après init =' .  $_POST['TypeCorrection'] . '<br />';

                    echo "Données de la requête:<br />";
                    echo "Niveau = " . $_POST['Niveau'] . "<br />";
                    echo "Joueur1 = " . $_POST['Joueur1'] . "<br />";
                    echo "Joueur2 = " . $_POST['Joueur2'] . "<br />";

                    echo "<br />Match à corriger :<br />";

                    //$matchToModify = selectMatchToModify($_SESSION['JOU_ID'], $_GET['ResMatchId']);
                    $selectedMatch = getMatchToCorrect($_POST['Niveau'], $_POST['Joueur1'], $_POST['Joueur2']);

                    while ($donnees = $selectedMatch->fetch()) {

                        $IdSelectedMatch = $donnees['RES_MATCH_ID'];
                        echo "ID du match à corriger = " . $IdSelectedMatch;

                        $GLOBALS['pageOrigine'] = 'gestionMatchs_correction';
                        // include ("formulairePronostiqueMatchASaisir.php");
                        include ("formulairePronostiqueMatchASaisirNoJoker.php");
                    }
                    break;

                default:
                    echo "Valeur inconnue de TypeCorrection = " . $_POST['TypeCorrection'] . "<br />";
                    break;

                }

              } else {
                ?>
                  <fieldset>
                  <legend>Dernier résultat rentré</legend>

                  <form action="gestionMatchs.php#MatchACorriger" method="post" enctype="multipart/form-data">

                      Rechercher dernier résultat saisi: <input type="hidden" name="TypeCorrection" required="required" value="LastMatch"/>
                      <input type="submit" value="OK" />
                  </form>
                  </fieldset>

                  <fieldset>
                  <legend>Ou recherche d'un match spécifique</legend>

                  <form action="gestionMatchs.php#MatchACorriger" method="post" enctype="multipart/form-data">
                  <p>
                      <?php
                      $listLevel = getAllLevel();
                      ?>
                      <input type="hidden" name="TypeCorrection" required="required" value="SelectedMatch"/>
                      Niveau de la compétition : <select name="Niveau" id="Niveau" required="required"/>
                      <option value="" selected></option>
                      <?php
                      while ($donnees = $listLevel->fetch())
                      {
                      ?>
                          <option value="<?php echo $donnees['SET_LVL_LIBELLE']; ?>"><?php echo $donnees['SET_LVL_LIBELLE']; ?></option>
                      <?php
                      }
                      ?>
                      </select>
                      <br />

                      <?php
                      $listPlayersTournament = getAllPlayersTournament('disp');
                      ?>
                      Joueur 1 : <select name="Joueur1" id="Joueur1" required="required"/>
                      <option value="" selected></option>
                      <?php
                      while ($donnees = $listPlayersTournament->fetch())
                      {
                        if (!empty($donnees['PLA_SEED'])) {
                          ?>
                          <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                          <?php
                        } else {
                          ?>
                          <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>
                      <br />

                      <?php
                      $listPlayersTournament = getAllPlayersTournament('disp');
                      ?>
                      Joueur 2 : <select name="Joueur2" id="Joueur2" required="required"/><br />
                      <option value="" selected></option>
                      <?php
                      while ($donnees = $listPlayersTournament->fetch())
                      {
                        if (!empty($donnees['PLA_SEED'])) {
                          ?>
                          <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                          <?php
                        } else {
                          ?>
                          <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                          <?php
                        }
                      }
                      ?>
                      </select>

                  </p>
                  <p>
                      <input type="submit" value="Valider" />
                  </p>
                  </form>
                  </fieldset>
                  <?php
              }

            // if (isset($_POST['LastEnteredMatch']) and $_POST['LastEnteredMatch'] == "OK") {
            //
            //     echo 'topLastEnteredMatch avant init =' .  $_POST['LastEnteredMatch'] . '<br />';
            //     $_POST['LastEnteredMatch']  = "";
            //     echo 'topLastEnteredMatch après init =' .  $_POST['LastEnteredMatch'] . '<br />';
            //
            //     echo "<br />Match à corriger :<br />";
            //
            //     //$matchToModify = selectMatchToModify($_SESSION['JOU_ID'], $_GET['ResMatchId']);
            //     $lastMatchSaisi = getLastEnteredMatch();
            //
            //     //$matchChoisi = $_GET['ResMatchId'];
            //
            //     //$reponse = $bdd->query("SELECT *
            //     //                         FROM pronostique p INNER JOIN resultats r
            //     //                           ON p.PRO_MATCH_ID = r.RES_MATCH_ID
            //     //                        WHERE p.PRO_JOU_ID = '$idSessionJoueur'
            //     //                          AND r.RES_MATCH_ID = '$matchChoisi'
            //     //                     ORDER BY r.RES_MATCH_DAT DESC");
            //
            //     while ($donnees = $lastMatchSaisi->fetch()) {
            //
            //         $IdLastEnteredMatch = $donnees['RES_MATCH_ID'];
            //         echo "ID du dernier match saisi=" . $IdLastEnteredMatch;
            //
            //         $GLOBALS['pageOrigine'] = 'gestionMatchs_correction';
            //         include ("formulairePronostiqueMatchASaisir.php");
            //     }
            //
            //     //$reponse->closeCursor();
            // } else {
              ?>
              <!--
              //*** FIN DE BOUT DE CODE AVEC TEST SI ON A CLIQUE SUR DERNIER MATCH Saisie
              -->

              <!-- <fieldset>
              <legend>Dernier résultat rentré</legend>

              <form action="gestionMatchs.php#MatchACorriger" method="post" enctype="multipart/form-data">

                  Rechercher dernier résultat saisi: <input type="hidden" name="TypeCorrection" required="required" value="LastMatch"/>
                  <input type="submit" value="OK" />
              </form>
              </fieldset>

              <fieldset>
              <legend>Ou recherche d'un match spécifique</legend>

              <form action="gestionMatchs.php#MatchACorriger" method="post" enctype="multipart/form-data">
              <p>
                  <?php
                  $listLevel = getAllLevel();
                  ?>
                  <input type="hidden" name="TypeCorrection" required="required" value="SelectedMatch"/>
                  Niveau de la compétition : <select name="Niveau" id="Niveau" required="required"/>
                  <option value="" selected></option>
                  <?php
                  while ($donnees = $listLevel->fetch())
                  {
                  ?>
                      <option value="<?php echo $donnees['SET_LVL_LIBELLE']; ?>"><?php echo $donnees['SET_LVL_LIBELLE']; ?></option>
                  <?php
                  }
                  ?>
                  </select>
                  <br />

                  <?php
                  $listPlayersTournament = getAllPlayersTournament('disp');
                  ?>
                  Joueur 1 : <select name="Joueur1" id="Joueur1" required="required"/>
                  <option value="" selected></option>
                  <?php
                  while ($donnees = $listPlayersTournament->fetch())
                  {
                  ?>
                      <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                  <?php
                  }
                  ?>
                  </select>
                  <br />

                  <?php
                  $listPlayersTournament = getAllPlayersTournament('disp');
                  ?>
                  Joueur 2 : <select name="Joueur2" id="Joueur2" required="required"/><br />
                  <option value="" selected></option>
                  <?php
                  while ($donnees = $listPlayersTournament->fetch())
                  {
                  ?>
                      <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                  <?php
                  }
                  ?>
                  </select>

              </p>
              <p>
                  <input type="submit" value="Valider" />
              </p>
              </form>
              </fieldset> -->

            <?php
            // }
            ?>
            (<a href="#HautDePage">Haut</a>)


            <!--      FIN DES OPTIONS GESTION DES MATCHS        -->


        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
