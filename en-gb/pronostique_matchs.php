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

                    echo (date('Y-m-d H:i:s')) . "<br /><br />";
                    //echo (date('Y-m-d G:H:s')) . "<br /><br />";

                    //echo "<br />";

                    $prognosisToDo = getPrognosisToDo();

                    $nbRow = $prognosisToDo->rowcount();

                    $matchASaisir = 460;

                    if ($nbRow > 0) {

                        ?>

                        <!-- ======================================================= -->
                        <!-- Début de la table pour l'affiche de la liste des macths -->
                        <!-- ======================================================= -->
                        <table>

                        <?php
                        //while ($donnees = $response->fetch())
                        while ($donnees = $prognosisToDo->fetch()) {
                        //$donnees = $reponse->fetchAll();

                        	   $matchASaisir = $donnees['RES_MATCH_ID'];

//-------------------------------------------------------------------------------------------------------------------------------------------------
                            //echo (date('Y-m-d G:i:s')) . "<br /><br />";
                            //echo time() . "<br /><br />";

                            //$remainingTime = strtotime($donnees['RES_MATCH_DAT']) - strtotime(date('Y-m-d G:i:s'));

                            //echo "Il vous reste " . $remainingTime . " pour faire votre pronostique.<br /><br />";

                            $dateMatchLocal = $donnees['RES_MATCH_DAT'];

                            ?>

                            <script scr='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.js'></script>
                            <script scr='https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.26/moment-timezone-with-data-10-year-range.js'></script>
                            <script>
                            var dateMatchLocal = <?php echo json_encode($dateMatchLocal); ?>;

                            //window.onload = moment;

                            //-----------------------------------------------
                            // Convertir date locale en date de l'ordinateur
                            //-----------------------------------------------
                            var mel = moment(dateMatchLocal).tz('Australia/Melbourne');
                            var local = mel.clone().tz();
                            local.format('YYYY-MM-DD HH:mm:ss');

                            //console.log("Date du match heure de chez vous = ", local.format('YYYY-MM-DD HH:mm:ss'))
                        		//---------------------------------------
                        		// Calculer une différence entre 2 dates
                        		//---------------------------------------
                        		var timeMatchLocal = new Date(dateMatchLocal);

                        		var timeNowHome = new Date();

                            remainingTime = timeMatchLocal.getTime() - timeNowHome.getTime();

                            //var remainingTimeHHMMSS = new Date();
                            //remainingTimeHHMMSS.setTime();
                            //new Date(remainingTime * 1000).toISOString().substr(11, 8);

                            console.log("remainingTime = ", remainingTime)
                            var sec_num = parseInt(remainingTime, 10); // don't forget the second param
                            console.log("sec_num = ", sec_num)
                            var hours   = Math.floor(sec_num / 3600000);
                            console.log("hours = ", hours)
                            var minutes = Math.floor((sec_num - (hours * 3600000)) / 60000);
                            console.log("minutes = ", minutes)
                            var seconds = ((sec_num - (hours * 3600000) - (minutes * 60000)) / 1000);
                            //var seconds2 = seconds.substring(0,2);
                            //console.log("seconds = ", seconds2)

                            if (hours   < 10) {hours   = "0"+hours;}
                            if (minutes < 10) {minutes = "0"+minutes;}
                            if (seconds < 10) {seconds = "0"+seconds;}

                            //  document.write((remainingTimeHHMMSS.getHours()-1)+":"+remainingTimeHHMMSS.getMinutes()+":"+remainingTimeHHMMSS.getSeconds());
                            //sec=remainingTime%1000;
                            //min=remainingTime%3600;
                            //hrs=(remainingTime-min) / 60;

                            //alert("debut script=" + debut + " fin script=" + fin);
                            console.log("Date du match à Melbourne = ", dateMatchLocal)
                        		console.log("Date courante chez vous =", timeNowHome)
                        		//console.log("Temps restant pour le prono =", hrs, "heures et ", min, "minutes")
                            console.log("Temps restant pour le prono =", hours, "heures, ", minutes, "minutes et ", seconds, "secondes")

                            </script>

                            <?php
//-------------------------------------------------------------------------------------------------------------------------------------------------

                            $matchDate = $donnees['RES_MATCH_DAT'];
                            $nowDate = date('Y-m-d H:i:s');

                            $start = new \DateTime("{$matchDate}");
                            $end = new \DateTime("{$nowDate}");

                            $diff = $start->diff($end);
                            $diffStr = $diff->format('%aj %Hh %Im %Ss');
                            //var_dump($diff);
                            //echo $diffStr;


                            //$remainingTime = strtotime($donnees['RES_MATCH_DAT']) - strtotime(date('Y-m-d H:i:s'));

                            //echo "Il vous reste " . $remainingTime . " pour faire votre pronostique.<br /><br />";

                            if (($donnees['RES_MATCH_JOU1'] != "Bye") AND ($donnees['RES_MATCH_JOU2'] != "Bye")) {

                              // change displqy for english version of the website
                              $outputRound = ConvertRound($donnees['RES_MATCH_TOUR']);

                              if (strtotime(date('Y-m-d H:i:s')) < strtotime($donnees['RES_MATCH_DAT'])) {
                                  //echo "Match à saisir = " . $matchASaisir . "<br />";

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
                                    <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                                    <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                                    <td width="100" align="center" valign="middle" class="cellule"><?php echo "<a href=pronostique_matchs.php?ResMatchId=".$matchASaisir."#FinListeMatchs class='button'>" . "Enter score</a><br />"; ?></td>
                                    <!-- <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Saisir le score" ></td> -->
                                    <td width="200" align="center" valign="middle" class="cellule">(<?php echo $diffStr; ?> left)</td>
                                  </tr>
                                  <?php
                              }
                              else {
                                ?>
                                <!-- ================================================== -->
                                <!-- Lines of the table to display matches to prognosis -->
                                <!-- ================================================== -->
                                <tr>
                                  <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
                                  <!-- <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td> -->
                                  <td width="150" align="center" valign="middle" class="cellule"><?php echo $outputRound; ?></td>
                                  <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                                  <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                                  <td width="100" align="center" valign="middle" class="cellule" style="color:red;"><i>Entry date exceeded</i></td>
                                  <!-- <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Saisir le score" ></td> -->
                                  <td width="200" align="center" valign="middle" class="cellule"></td>
                                </tr>
                                <?php
                                  // echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "Date de saisie dépassée<br />";
                              }
                            }
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

                                    include ("formulairePronostiqueMatchASaisir.php");
                                    }
                            }
                            else {
                                echo "<span class='warning'>TECHNICAL ISSUE - You score can't be updated. Please contact the website administrator</span><br />";
            	            }
                        }
                    }
                    else {
                        echo "You are up to date with your predictions.<br /><br />";
                        echo "However, you can change them if you want in the <a href='pagePerso.php'>Personal Page</a> section <br />";
                    }
                }
                else {

                    echo "Pour pronostiquer, vous devez vous connecter à votre compte : <br />";

                    // Affichage du formulaire de connexion
                    include("formulaireConnexion.php");

                    echo "Pas encore inscrit ? Faites partie de la communauté en cliquant <a href='formulaireInscription.php'>ICI</a><br />";
                }
          		?>

            </div>

        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
