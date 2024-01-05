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

        <div class="element_corps">

            <div id="corps">

        		<?php
                //include("connexionSGBD.php");
                // insertion page qui contient toutes les requêtes
                //include("../commun/model.php");


                if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE'])) {
                    //$reponse = $bdd->query('SELECT * FROM résultats WHERE RES_MATCH_DAT = CURDATE()');
                    //$reponse = $bdd->query('SELECT * FROM resultats WHERE RES_MATCH_DAT = CURDATE() AND RES_MATCH = ""');


                    //*************************************************************************************************************
                    //*                                       PRONOSTIQUES DES MATCHS
                    //*************************************************************************************************************
                    echo "<br /><h1>Matches predictions</h1><br />";

                    setlocale(LC_TIME, "fr_FR", "French");
                    //---
                    //echo "Nous sommes le " . strftime('%A %d %B %Y, il est %H:%M:%S') . "<br />";
                    //---
                    //echo (date('l jS \of F Y\, \i\l \e\s\t H:i:s')) . "<br />";
                    //echo (date('l jS \of F Y\, \i\l \e\s\t H:i:s \à \M\a\d\r\i\d')) . "<br />";
                    //echo (date('Y-m-d \i\l \e\s\t H:i:s \à \M\a\d\r\i\d')) . "<br />";
                    //echo date(DATE_RFC2822) . "<br />";
                    //echo date('l jS \of F Y h:i:s A') . "<br />";

                    // echo (date('Y-m-d H:i:s')) . " <i>(local time)</i><br /><br />";
                    //echo (date('Y-m-d G:H:s')) . "<br /><br />";

                    // Calcul difference dates
                    $H_here = date('Y-m-d H:i:s');
                    // echo "H1 = " . $H_here . "<br />";
                    // date_default_timezone_set('Australia/Melbourne');
                    // date_default_timezone_set('Europe/Paris');
                    // date_default_timezone_set('Europe/London');
                    // date_default_timezone_set('America/New_York');
                    $tournament= getTournament();
                    while ($donnees = $tournament->fetch()) {
                        switch ($donnees['SET_LIB_TOURNAMENT']) {
                          case 'Australian Open':
                            date_default_timezone_set('Australia/Melbourne');
                          break;

                          case 'Roland Garros':
                            date_default_timezone_set('Europe/Paris');
                          break;

                          case 'Wimbledon':
                            date_default_timezone_set('Europe/London');
                          break;

                          case 'US Open':
                            date_default_timezone_set('America/New_York');
                          break;
                        }
                    }

          					$H_Nyk = date('Y-m-d H:i:s');
          					// echo "H2 = " . $H_Nyk . "<br />";
                    $jetlag = $H_Nyk - $H_here;
                    // echo "H3 = " . $jetlag . "<br />";
                    //echo "<br />";
                    $Heure_NY = new \DateTime("{$H_Nyk}");
                    $Heure_Here = new \DateTime("{$H_here}");

                    $Heure_diff = $Heure_NY->diff($Heure_Here);
                    $Heure_diffStr = $Heure_diff->format('%aj %Hh %Im %Ss');
                    // echo "Diff = " . $Heure_diffStr . "<br />";
                    $Heure_diffStr = $Heure_diff->format('%h');
                    // echo "Diff = " . $Heure_diffStr . "<br />";


                    // Les contrôles sont différents selon le tour du Tournoi
                    // - Deux 1er tours, pas de score (juste choix du vainqueur)
                    // - A partir du 3ème tour, scores
                    // - A partir des 1/8ème de finale, introduction du joker pour doubles ses Points
                    $GLOBALS['pageOrigine'] = 'pronostique_matchs';
                    include ("controleSaisie.php");

                    $prognosisToDo = getPrognosisToDo();

                    $nbRow = $prognosisToDo->rowcount();

                    $matchASaisir = 0;

                    if ($nbRow > 0) {

                        ?>

                        <!-- ======================================================= -->
                        <!-- Début de la table pour l'affiche de la liste des macths -->
                        <!-- ======================================================= -->
                        <table>

                        <?php
                        $niveauPrecedent = "";
                        $datePrecedente = "";
                        //while ($donnees = $response->fetch())
                        while ($donnees = $prognosisToDo->fetch()) {
                        //$donnees = $reponse->fetchAll();

                        	  $matchASaisir = $donnees['RES_MATCH_ID'];

                            $matchDate = $donnees['RES_MATCH_DAT'];
                            $nowDate = date('Y-m-d H:i:s');

                            $start = new \DateTime("{$matchDate}");
                            $end = new \DateTime("{$nowDate}");

                            $diff = $start->diff($end);
                            $diffStr = $diff->format('%ad %Hh %Im %Ss');
                            //var_dump($diff);
                            //echo $diffStr;

                            // change display for english version of the website
                            $outputRound = ConvertRoundFTE($donnees['RES_MATCH_TOUR']);

                            //Get New-York date and time.
                            $Heure_match_local = new \DateTime("{$donnees['RES_MATCH_DAT']}");
                            // echo "Match date and time match (locale time) = " . $Heure_match_local . "<br />";
                            //Number of hours to add has already been calculated = $Heure_diffStr

                            //Add the hours by using the DateTime::add method in
                            //conjunction with the DateInterval object.
                            $Heure_match_local->add(new DateInterval("PT{$Heure_diffStr}H"));
                            // $Heure_match_local->add(new DateInterval("PT5H"));
                            // echo "* Date et heure du match à New-York (+jetlag) = " . $Heure_match_local_mod . "<br />";

                            //Format the new time into a more human-friendly format
                            //and print it out.
                            // setlocale(LC_TIME, 'fr_FR', 'French');
                            // setlocale(LC_TIME, 'fr_FR.utf8','fra');
                            // $Heure_match_YourTime = $Heure_match_local->format('Y-m-d, H:i');
                            $Heure_match_YourTime = $Heure_match_local->format('l d F, H:i');
                            // echo "Match date and time match (your time) = " . $Heure_match_local . "<br />";


                            // Nouvelle table avec titre si le tour est différent
                            if ($niveauPrecedent != $outputRound) {
                              ?>
                              </table>
                              <?php
                              // echo "<br /><span class='info'>" . $outputRound . "</span><br />";
                              echo "<br />" . $outputRound . "<br />";
                              // echo "Enter your prediction before " . $Heure_match_YourTime . " (your time)<br />";
                              echo "Enter your prediction before: ";
                              ?>
                              <table>
                              <?php
                            } else {
                              // Séparation si la date est différente
                              if ($datePrecedente != $donnees['RES_MATCH_DAT']) {
                                ?>
                                </table>
                                <br />
                                <?php
                                // echo "Enter your prediction before " . $Heure_match_YourTime . " (your time)<br />";
                                echo "Enter your prediction before: ";
                                ?>
                                <table>
                                <?php
                              }
                            }


                            if (($donnees['RES_MATCH_JOU1'] != "Bye") AND ($donnees['RES_MATCH_JOU2'] != "Bye")) {


                              if (strtotime(date('Y-m-d H:i:s')) < strtotime($donnees['RES_MATCH_DAT'])) {
                                  // echo "Match à saisir = " . $matchASaisir . "<br />";

                                  // Si 1er tour ou 2ème tour, on affiche seulement le formulaire avec choix du vainqueur
                                  // A partir du 3ème tour, retour au système classique: selection du match à saisir et affichage du formulaire de saisie
                                  if (($donnees['RES_MATCH_POIDS_TOUR'] == 64) or ($donnees['RES_MATCH_POIDS_TOUR'] == 32)) {
                                    $GLOBALS['pageOrigine'] = 'pronostique_matchs';
                                    include ("formulairePronostiqueMatchASaisir2_entete.php");
                                  } else {
                                  // Si on clique sur "saisie du résultat", renvoi vers ancre "FinListeMatchs"
                                  //echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=pronostique_matchs.php?ResMatchId=".$matchASaisir."#FinListeMatchs>" . " Saisir le score</a> (" . $diffStr . " restants)<br />";
                                  ?>
                                  <!-- ================================================== -->
                                  <!-- Lines of the table to display matches to prognosis -->
                                  <!-- ================================================== -->
                                  <tr>
                                    <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
                                    <!-- <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td> -->
                                    <td width="150" align="center" valign="middle" class="cellule"><?php echo $outputRound; ?></td>
                                    <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                                    <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                                    <td width="100" align="center" valign="middle" class="cellule"><?php echo "<a href=pronostique_matchs.php?ResMatchId=".$matchASaisir."#FinListeMatchs class='button'>" . "<b>Enter score</b></a><br />"; ?></td>
                                    <!-- <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Saisir le score" ></td> -->
                                    <td width="200" align="center" valign="middle" class="cellule">(<?php echo $diffStr; ?> left)</td>
                                  </tr>
                                  <?php
                                }
                              }
                              else {
                                // echo "Trop tard pour match = " . $matchASaisir . "<br />";
                                ?>
                                <!-- ================================================== -->
                                <!-- Lines of the table to display matches to prognosis -->
                                <!-- ================================================== -->
                                <tr>
                                  <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
                                  <!-- <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td> -->
                                  <td width="150" align="center" valign="middle" class="cellule"><?php echo $outputRound; ?></td>
                                  <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                                  <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                                  <td width="250" align="center" valign="middle" class="cellule" style="color:red;"><i>Entry date exceeded</i></td>
                                  <!-- <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Saisir le score" ></td> -->
                                  <!-- <td width="200" align="center" valign="middle" class="cellule"></td> -->
                                </tr>
                                <?php
                                  // echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "Date de saisie dépassée<br />";
                              }
                            }
                            $datePrecedente = $donnees['RES_MATCH_DAT'];
                            $niveauPrecedent = $outputRound;
                        }

                        ?>

                        <!-- ===================================================== -->
                        <!-- Fin de la table pour l'affiche de la liste des macths -->
                        <!-- ===================================================== -->
                        </table>

                        <!-- creation nouvelle div pour créer une ancre et renvoyer vers cette ancre lors de la saisie d'un résultat -->
                        <!-- ancre renvoi vers la fin de la liste des matchs pour pouvoir tomber directement sur la saisie -->
                        <div id="FinListeMatchs"></div>

                        <?php

                        if (isset($_GET['ResMatchId'])) {

                            $idSessionJoueur = $_SESSION['JOU_ID'];
            	            //echo "pseudo=" . $idSessionJoueur . "<br />";
            	            //echo "Id du match à saisir" . $_GET['ResMatchId'] . "<br />";

            	            //$matchChoisi = $_GET['ResMatchId'];

                            $req = selectMatch($_SESSION['JOU_ID'], $_GET['ResMatchId']);
                            //$donnees = $req->fetch();

                            $nbRow = $req->rowcount();

                            if ($nbRow > 0) {
                                while ($donnees = $req->fetch()) {
                                    //echo $donnees['RES_MATCH_ID'] . " - " . $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_TOURNOI'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs " . $donnees['RES_MATCH_JOU2'] . "<br />";

                                    echo "<br />Please make your prediction for this match:<br /><br />";

                                    $GLOBALS['pageOrigine'] = 'pronostique_matchs';
                                    if ($donnees['RES_MATCH_POIDS_TOUR'] == 16) {
                                      include ("formulairePronostiqueMatchASaisirNoJoker.php");
                                    } else {
                                      include ("formulairePronostiqueMatchASaisir.php");
                                    }
                                }
                            }
                            else {
                                echo "<span class='warning'>TECHNICAL ISSUE - You score can't be updated. Please contact the website administrator</span><br />";
            	            }
                        }
                    }
                    else {
                      // Is there any matches in "resultats" table?
                      $isresultatstableempty = getResultatsTableNbRows();
                      $nbRow = $isresultatstableempty->rowcount();

                      if ($nbRow == 0) {
                        // Le tournament hasn't started yet
                        echo "<span class='congrats'>The tournament hasn't started yet. 1st round matches will be online soon.<br /></span><br />";
                      }
                      else {
                        // Le joueur est à jour de ses pronostiques
                        echo "<span class='congrats'>You are up to date with your predictions.</span><br /><br />";
                        echo "However, you can change them if you want in the <a href='pagePerso.php'>Personal Page</a> section <br />";
                      }
                    }
                }
                else {

                    echo "To make a prediction, please sign in. <br />";

                    // Affichage du formulaire de connexion
                    // include("formulaireConnexion.php");

                    echo "Not registered yet ? Visit the registration page <a href='formulaireInscription.php'>HERE</a> and be part of the game!<br />";
                }
          		?>

            </div>

        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
