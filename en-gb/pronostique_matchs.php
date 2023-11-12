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
                    date_default_timezone_set('America/New_York');
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


                    // 06/07/2020: ajout cible ici pour essayer d'afficher le message sur la même page
                    // include ("formulairePronostiqueUnitaireCible.php");
                    //****************************************************************************
                    // debut copy formulairePronostiqueUnitaireCible.php
                    //****************************************************************************
                    if (isset($_POST['TypeMatch'])
                    and isset($_POST['ScoreJ1'])
                    and isset($_POST['ScoreJ2']))
                    {

                      $typeMatch = $_POST['TypeMatch'];

                      if (isset($_POST['VouD'])) {
                        // echo "VouD reçu = " . $_POST['VouD'] . "<br />";
                        $result = $_POST['VouD'];
                      } else {
                        // echo "VouD pas reçu - initialisé à blanc<br />";
                        $result = "";
                      }

                      $scoreJ1 = $_POST['ScoreJ1'];
                      $scoreJ2 = $_POST['ScoreJ2'];

                      if (isset($_POST['Joker'])) {
                        $joker = $_POST['Joker'];
                      } else {
                        $joker = " ";
                      }

                      // echo "Before conversion ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

                      //if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
                			// if ($_POST['VouD']=="" OR $_POST['ScoreJ1']=="" OR $_POST['ScoreJ2']=="")
                      if ($result=="" OR ($scoreJ1=="0" and $scoreJ2=="0" and $typeMatch==""))
                			{
                				echo "<span class='warning'>You must fill out all the fields. You entered: </span><br />";
                        echo "<span class='warning'>Result=" . $result . ", Score=" . $scoreJ1 . "/" . $scoreJ2 .  " " . $typeMatch . "</span><br />";
                				// echo "<span class='warning'>Go back to the form: </span>" . '<a href="pronostique.php">Cliquer ici</a>';
                        echo "<span class='warning'>Go back to the form: </span>";
                        ?>
                        <input type="button" value="OK" onclick="history.go(-1)">
                        <?php
                			}
                			else
                			{
                				//echo "Le match saisit est le match n°" . $_POST['idMatch'] . '<br />'; //idMAtch est la valeur du champs caché du formulaire de saisie de score
                				// echo "The player ID is " . $_SESSION['JOU_ID'] . '<br />';

                        echo "Joker = " . $_POST['Joker'] . "<br />";
                        // if ($_POST['Joker'] == "yes") {
                        if ($joker == "on") {
                          $doublePoints = 2;
                        } else {
                          $doublePoints = 1;
                        }

                				//Contrôles avant chargement :
                				$pronoOK = 'OK';

                        // echo "After conversion  ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

                				switch ($typeMatch) {
                					case 'RET':
                						if ($_POST['TypeTournoi'] != 'GC') {

                	          //echo "type de tournoi différent de GC : <" . $_POST['TypeTournoi'] . "><br />";
                               if ($scoreJ1 == 2 OR $scoreJ2 == 2) {
                		               echo "<span class='warning'>Wrong score: If a player won 2 sets he can't retire.</span><br />";
                		               $pronoOK = 'KO';
                               }
                	          } else {
                            	if ($scoreJ1 == 3 OR $scoreJ2 == 3) {
                          		//echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 3 sets !!! Type Tournoi = " . $_POST['TypeTournoi'] . "</span><br />";
                	         		  echo "<span class='warning'>Wrong score: If a player won 3 sets he can't retire.</span><br />";
                	           	  $pronoOK = 'KO';
                	           	}
                	          }

                            if ($_POST['TypeTournoi'] != 'GC') {

                              if ($scoreJ1 == 2) {
                  							echo "<span class='warning'>Warning : the loser can't retire if the opponent already won 2 sets.</span><br />";
                  							$pronoOK = 'KO';
                              }

                            } else {
                              if ($scoreJ1 == 3) {
                  							echo "<span class='warning'>Warning : the loser can't retire if the opponent already won 3 sets.</span><br />";
                  							$pronoOK = 'KO';
                              }
                            }

                						break;

                					case 'WO':
                						if ($scoreJ1 != 0 OR $scoreJ2 != 0) {
                							echo "<span class='warning'>Warning : in the event of a walk over, score must be 0-0</span><br />";
                							$pronoOK = 'KO';
                						}

                						break;

                					default:
                	                    if ($scoreJ1 == 0) {
                	                        echo "<span class='warning'>Wrong score: the winner can't win with 0 set</span><br />";
                	                        $pronoOK = 'KO';
                	                    }

                	                    if ($_POST['TypeTournoi'] != 'GC') {

                	                    	//echo "type de tournoi différent de GC : <" . $_POST['TypeTournoi'] . "><br />";

                		                    if ($scoreJ1 != 2) {
                		                        //echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 2 sets !!! Type Tournoi <" . $_POST['TypeTournoi'] . "></span><br />";
                		                        echo "<span class='warning'>Wrong score: the winner has to win 2 sets</span><br />";
                		                        $pronoOK = 'KO';
                		                    }
                	                    }
                	                    else {

                	                    	if ($scoreJ1 != 3) {
                	                    		//echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 3 sets !!! Type Tournoi = " . $_POST['TypeTournoi'] . "</span><br />";
                	                    		echo "<span class='warning'>Wrong score: the winner has to win 3 sets</span><br />";
                	                        $pronoOK = 'KO';
                	                    	}
                	                    }

                	                    if ($scoreJ2 >= $scoreJ1) {
                	                        echo "<span class='warning'>Wrong score: winner's number of sets must be greater than loser's number of sets</span><br />";
                	                        $pronoOK = 'KO';
                	                    }

                						break;
                				}

                				//Chargement des scores en table MySQL des pronostiques
                				$nbRow = 0;

                				if ($pronoOK == 'OK') {
                          // convert result from english to french for process, if english version
                          // W --> V
                          // L --> D
                          // echo "result avant conversion=" . $result . "<br :>";
                          $outputResultF = "";
                          if ($result == 'W' or $result == 'L') {
                            $result = ConvertResultETF($result);
                          }
                          // echo "result après conversion=" . $result . "<br :>";
                          // convert match type from english to french for process, if english version
                          // RET --> AB
                          // echo "type result avant conversion=" . $typeMatch . "<br :>";
                          if ($typeMatch == 'RET') {
                            $typeMatch = ConvertTypeResultETF($typeMatch);
                          }
                          // echo "type result après conversion=" . $typeMatch . "<br :>";

                					// $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch']);
                          // $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch);
                          $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch, $doublePoints);

                					$nbRow = $req->rowcount();
                				}
                				else {
                          ConvertResultFTE($result);
                          $result = $outputResultE;
                          echo "<span class='warning'>Your prediction: result=" . $result . ", score=" . $scoreJ1 . "/" . $scoreJ2 . "</span><br />";
                          echo "<span class='warning'>Go back to the form: </span>";
                          ?>
                          <input type="button" value="OK" onclick="history.go(-1)">
                          <?php
                          echo "<br />";
                					// echo "<span class='warning'>Please try again " . '<a href="pronostique_matchs.php">HERE</a>' . ". If the error persists, please contact the webadmin.</span><br />";
                				}


                				if ($nbRow > 0)
                				{
                					// echo 'Congrats! Prediction done!<br />';

                					// if ($_POST['VouD'] == 'V') {
                          if ($result == 'V') {
                					 	switch ($typeMatch) {
                					 	 	case 'AB':
                					 	 		echo '<span class="info">Your prediction: </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class="info"> defeated </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class="info"> by withdrawal: ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . ' before ' . htmlspecialchars($_POST['Player2']) . ' withdrawal. </span><br />';
                					 	 		break;

                					 	 	case 'WO':
                				 	 			echo '<span class="info">Your prediction: </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class="info"> defeated </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class="info"> by W.O. </span><br />';
                				 	 			break;

                					 	 	default:
                				 	 			echo '<span class="info">Your prediction: </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class="info"> defeated </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class="info">: ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . '</span><br />';
                				 	 			break;
                					 	 }
                					 }
                					 else {
                					 	switch ($typeMatch) {
                					 	 	case 'AB':
                					 	 		echo '<span class="info">Your prediction: </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class="info"> defeated </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class="info"> by withdrawal: ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . ' before ' . htmlspecialchars($_POST['Player1']) . ' withdrawal. </span><br />';
                					 	 		break;

                					 	 	case 'WO':
                					 	 		echo '<span class="info">Your prediction: </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class="info"> defeated </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class="info"> by W.O. </span><br />';
                					 	 		break;

                					 	 	default:
                					 	 		echo '<span class="info">Your prediction: </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class="info"> defeated </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class="info">: ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . '</span><br />';
                					 	 		break;
                					 	}
                					}

                					echo '<span class=info>You can change your prediction in your <a href="pagePerso.php">' . 'Personal page' . '</a> </span>';
                					// echo '<br />To make a new prediction, click <a href="pronostique_matchs.php">' . 'HERE' . '</a><br/>';
                          // echo '<br /><a href="pronostique_matchs.php" class="button">' . 'New prediction' . '</a><br/>';
                          ?>
                          <input type="button" value="OK" onclick="window.location.href='pronostique_matchs.php'"><br />
                          <?php

                				} else {
                          // echo "<br />Update did nothing";
                        }
                			}
                    }
                    //****************************************************************************
                    // fin copy formulairePronostiqueUnitaireCible.php
                    //****************************************************************************

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

                            // change displqy for english version of the website
                            $outputRound = ConvertRoundFTE($donnees['RES_MATCH_TOUR']);

                            //Get New-York date and time.
                            $Heure_match_NY = new \DateTime("{$donnees['RES_MATCH_DAT']}");
                            // echo "* Date et heure du match à New-York = " . $Heure_match_NY . "<br />";
                            //Number of hours to add has already been calculated = $Heure_diffStr

                            //Add the hours by using the DateTime::add method in
                            //conjunction with the DateInterval object.
                            $Heure_match_NY->add(new DateInterval("PT{$Heure_diffStr}H"));
                            // $Heure_match_NY->add(new DateInterval("PT5H"));
                            // echo "* Date et heure du match à New-York (+jetlag) = " . $Heure_match_NY_mod . "<br />";

                            //Format the new time into a more human-friendly format
                            //and print it out.
                            // setlocale(LC_TIME, 'fr_FR', 'French');
                            // setlocale(LC_TIME, 'fr_FR.utf8','fra');
                            // $Heure_match_YourTime = $Heure_match_NY->format('Y-m-d, H:i');
                            $Heure_match_YourTime = $Heure_match_NY->format('l d F, H:i');


                            // Nouvelle table avec titre si le tour est différent
                            if ($niveauPrecedent != $outputRound) {
                              ?>
                              </table>
                              <?php
                              // echo "<br /><span class='info'>" . $outputRound . "</span><br />";
                              echo "<br />" . $outputRound . "<br />";
                              echo "Enter your prediction before " . $Heure_match_YourTime . " (your time)<br />";
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
                                echo "Enter your prediction before " . $Heure_match_YourTime . " (your time)<br />";
                                ?>
                                <table>
                                <?php
                              }
                            }


                            if (($donnees['RES_MATCH_JOU1'] != "Bye") AND ($donnees['RES_MATCH_JOU2'] != "Bye")) {


                              if (strtotime(date('Y-m-d H:i:s')) < strtotime($donnees['RES_MATCH_DAT'])) {
                                  // echo "Match à saisir = " . $matchASaisir . "<br />";

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
                                    include ("formulairePronostiqueMatchASaisir.php");
                                    }
                            }
                            else {
                                echo "<span class='warning'>TECHNICAL ISSUE - You score can't be updated. Please contact the website administrator</span><br />";
            	            }
                        }
                    }
                    else {
                        echo "<span class='congrats'>You are up to date with your predictions.</span><br /><br />";
                        echo "However, you can change them if you want in the <a href='pagePerso.php'>Personal Page</a> section <br />";
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
