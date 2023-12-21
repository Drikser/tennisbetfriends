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
                    echo "<br /><h1>Pronostiques matchs</h1><br />";

                    setlocale(LC_TIME, "fr_FR", "French");
                    //---
                    //echo "Nous sommes le " . strftime('%A %d %B %Y, il est %H:%M:%S') . "<br />";
                    //---
                    //echo (date('l jS \of F Y\, \i\l \e\s\t H:i:s')) . "<br />";
                    //echo (date('l jS \of F Y\, \i\l \e\s\t H:i:s \à \M\a\d\r\i\d')) . "<br />";
                    //echo (date('Y-m-d \i\l \e\s\t H:i:s \à \M\a\d\r\i\d')) . "<br />";
                    //echo date(DATE_RFC2822) . "<br />";
                    //echo date('l jS \of F Y h:i:s A') . "<br />";

                    // echo (date('Y-m-d H:i:s')) . " <i>(heure locale)</i><br /><br />";
                    //echo (date('Y-m-d G:H:s')) . "<br /><br />";

                    // Calcul difference dates
                    $H_here = date('Y-m-d H:i:s');
                    // echo "Your time (H1) = " . $H_here . "<br />";
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

          					$Loc_Time = date('Y-m-d H:i:s');
          					// echo "Local time (H2) = " . $Loc_Time . "<br />";
                    $jetlag = $Loc_Time - $H_here;
                    // echo "Jetlag (H2-H1=H3) = " . $jetlag . "<br />";
                    //echo "<br />";
                    $Heure_NY = new \DateTime("{$Loc_Time}");
                    $Heure_Here = new \DateTime("{$H_here}");

                    $Heure_diff = $Heure_NY->diff($Heure_Here);
                    $Heure_diffStr = $Heure_diff->format('%aj %Hh %Im %Ss');
                    // echo "Difference = " . $Heure_diffStr . "<br />";
                    $Heure_diffStr = $Heure_diff->format('%h');
                    // echo "Difference (formatted) = " . $Heure_diffStr . "<br />";

                    // 06/07/2020: ajout cible ici pour essayer d'afficher le message sur la même page
                    // include ("formulairePronostiqueUnitaireCible.php");
                    //****************************************************************************
                    // debut copy formulairePronostiqueUnitaireCible.php
                    //****************************************************************************
                    // echo "VouD=" . $_POST['VouD'] . " - " . $_POST['ScoreJ1'] . "/" . $_POST['ScoreJ2'] . "(" . $_POST['TypeMatch'] . ")<br />";

                    if (isset($_POST['TypeMatch'])
                    and isset($_POST['ScoreJ1'])
                    and isset($_POST['ScoreJ2']))
                    // and ($_POST['VouD'] == "V" or $_POST['VouD'] == "D" or $_POST['VouD'] == ""))
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

                        // echo "Before conversion ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

                        //if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
                        // if ($_POST['VouD']=="" OR $_POST['ScoreJ1']=="" OR $_POST['ScoreJ2']=="")
                        if ($result=="")
                        {
                          echo "<span class='warning'>Vous devez choisir un vainqueur</span>";
                          ?>
                          <input type="button" value="OK" onclick="history.go(-1)">
                          <?php
                        }
                        else
                        {
                          //Contrôles avant chargement :
                          $pronoOK = 'OK';

                          // echo "After conversion  ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

                          if ($result !== "V" and $result !== "D") {
                            echo "<span class='warning'>Mauvaise valeur pour le résultat: " . $result . " (Doit être 'V' ou 'D')</span><br />";
                            $pronoOK = 'KO';
                          }

                          //Chargement des scores en table MySQL des pronostiques
                          $nbRow = 0;

                          if ($pronoOK == 'OK') {

                            // Correction Type Match to avoid "Data too long for column 'PRO_TYP_MATCH'"
                            if ($typeMatch !== "") {
                              $typeMatch = "";
                              //echo 'Type Match initialized<br />';
                            }

                            // Last argument = joker = 1 for the first 2 rounds
                            $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch, 1);

                            $nbRow = $req->rowcount();
                          }
                          else {

                            echo "<span class='warning'>Votre pronostique: " . $result . " " . $scoreJ1 . "/" . $scoreJ2 . "</span><br />";
                            echo "<span class='warning'>Refaire la saisie: </span>";
                            ?>
                            <input type="button" value="OK" onclick="history.go(-1)">
                            <?php

                            echo "<br />";
                            // echo "<span class='warning'>Merci de ré-essayer " . '<a href="pronostique_matchs.php">ICI</a>' . ". Si l'erreur persiste, veuillez contacter l'admninistrateur du site.</span><br />";
                          }


                          if ($nbRow > 0)
                          {
                            // echo 'Bravo ! Pronostique fait !<br />';

                            // if ($_POST['VouD'] == 'V') {
                            if ($result == 'V') {
                              echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><br />';
                            }
                           else {
                              echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><br />';
                            }

                            echo '<span class=info>Vous pouvez modifier ce pronostique dans la section <a href="pagePerso.php">' . 'Page perso' . '</a> </span>';
                            // echo '<br />Pour faire un nouveau pronostique, clique <a href="pronostique_matchs.php">' . 'ICI' . '</a><br/>';
                            // echo '<br /><a href="pronostique_matchs.php" class="button">' . 'Nouveau pronostique' . '</a><br/>';
                            ?>
                            <input type="button" value="OK" onclick="window.location.href='pronostique_matchs2.php'"><br />
                            <?php

                          } else {
                            // echo "<br />Update n'a rien fait";
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
                        $datePrecedente ="";

                        //while ($donnees = $response->fetch())
                        while ($donnees = $prognosisToDo->fetch()) {
                        //$donnees = $reponse->fetchAll();

                        	  $matchASaisir = $donnees['RES_MATCH_ID'];

                            $matchDate = $donnees['RES_MATCH_DAT'];
                            $nowDate = date('Y-m-d H:i:s');

                            $start = new \DateTime("{$matchDate}");
                            $end = new \DateTime("{$nowDate}");

                            $diff = $start->diff($end);
                            $diffStr = $diff->format('%aj %Hh %Im %Ss');
                            // var_dump($diff);
                            // echo $diffStr . "<br />";

                            // $remainingTime = strtotime($donnees['RES_MATCH_DAT']) - strtotime(date('Y-m-d H:i:s'));

                            // echo "Il vous reste " . $remainingTime . " pour faire votre pronostique.<br /><br />";
                            // echo "Il vous reste " . $diffStr . " pour faire votre pronostique.<br /><br />";

                            if (($donnees['RES_MATCH_JOU1'] != "Bye") AND ($donnees['RES_MATCH_JOU2'] != "Bye")) {


                              // Nouvelle table avec titre si le tour est différent
                              if ($niveauPrecedent != $donnees['RES_MATCH_TOUR']) {
                                ?>
                                </table>
                                <?php
                                // echo "<br /><span class='info'>" . $donnees['RES_MATCH_TOUR'] . "</span><br />";
                                echo "<br />" . $donnees['RES_MATCH_TOUR'] . "<br />";
                                // echo "<span class='info'>Saisie à faire avant " . date_format($donnees['RES_MATCH_DAT'], "d-m") . " à " . date_format($donnees['RES_MATCH_DAT'], "H-i") . "</span><br />";
                                // setlocale(LC_TIME, 'fr_FR');
                                // $deadline_matches = date('l H', strtotime($donnees['RES_MATCH_DAT']));
                                // echo "Saisie à faire avant " . $deadline_matches . " heures<br />";
                                // echo "Saisie à faire avant " . utf8_encode(strftime('%A %d %B %Y, %Hh%M')) . "<br />";
                                // echo "Saisie à faire avant " . utf8_encode(datefmt_format($donnees['RES_MATCH_DAT'], 0)) . "<br />";

                                //Get New-York date and time.
                                // $Heure_match_NY = new \DateTime("{$donnees['RES_MATCH_DAT']}");
                                // echo "* Date et heure du match à New-York = " . $Heure_match_NY . "<br />";
                                //Number of hours to add has already been calculated = $Heure_diffStr

                                //Add the hours by using the DateTime::add method in
                                //conjunction with the DateInterval object.
                                // $Heure_match_NY->add(new DateInterval("PT{$Heure_diffStr}H"));
                                // $Heure_match_NY->add(new DateInterval("PT5H"));
                                // echo "* Date et heure du match à New-York (+jetlag) = " . $Heure_match_NY_mod . "<br />";

                                //Format the new time into a more human-friendly format
                                //and print it out.
                                // setlocale(LC_TIME, 'fr_FR', 'French');
                                // setlocale(LC_TIME, 'fr_FR.utf8','fra');
                                // $Heure_match_YourTime = $Heure_match_NY->format('Y-m-d, H:i');
                                // $Heure_match_YourTime = $Heure_match_NY->format('l d F, H:i');
                                // echo "Saisie à faire avant " . $Heure_match_YourTime . " (chez vous)<br />";
                                // $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
                                // echo "Saisie à faire avant " . $formatter->format($Heure_match_NY) . " (chez vous)<br />";
                                // echo "Saisie à faire avant " . $formatter->format($donnees['RES_MATCH_DAT']) . " (chez vous)<br />";
                                echo "Saisie à faire avant: ";
                                ?>
                                <table>
                                  <tr>
                                    <th width="150" align="center" valign="middle" class="cellule">Date</th>
                                    <th width="150" align="center" valign="middle" class="cellule">Niveau</th>
                                    <th width="150" align="center" valign="middle" class="cellule">Joueur 1</th>
                                    <th width="50" align="center" valign="middle" class="cellule">Choisir vainqueur</th>
                                    <th width="150" align="center" valign="middle" class="cellule">Joueur 2</th>
                                    <!-- <th width="150" align="center" valign="middle" class="cellule">Score Vainqueur (nb sets)</th>
                                    <th width="150" align="center" valign="middle" class="cellule">Score Perdant (nb sets)</th>
                                    <th width="100" align="center" valign="middle" class="cellule">Type Match</th> -->
                            <!-- Rows to not display, but which still need to send through the form -->
                                    <!-- <th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Date du match (à transmettre)</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Tournoi</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Categorie</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Poids</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Sequence</th> -->
                                  </tr>
                                <?php
                              } else {
                                // Séparation si la date est différente
                                if ($datePrecedente != $donnees['RES_MATCH_DAT']) {
                                  ?>
                                  <!-- <table style="Table-Layout:fixed"> -->
                                  <table>
                                  <br />
                                  <?php
                                  // echo "Saisie à faire avant " . $donnees['RES_MATCH_DAT'] . "<br />";
                                  $Heure_match_NY = new \DateTime("{$donnees['RES_MATCH_DAT']}");
                                  $Heure_match_NY->add(new DateInterval("PT{$Heure_diffStr}H"));
                                  setlocale(LC_TIME, 'fr_FR.utf8','fra');
                                  $Heure_match_YourTime = $Heure_match_NY->format('l d F, H:i');
                                  $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
                                  // echo "Saisie à faire avant " . $formatter->format($Heure_match_NY) . " (chez vous)<br />";
                                  echo "Saisie à faire avant: ";
                                  ?>
                                  <tr>
                                    <th width="150" align="center" valign="middle" class="cellule">Date</th>
                                    <th width="150" align="center" valign="middle" class="cellule">Niveau</th>
                                    <th width="150" align="center" valign="middle" class="cellule">Joueur 1</th>
                                    <th width="50" align="center" valign="middle" class="cellule">Choisir vainqueur</th>
                                    <th width="150" align="center" valign="middle" class="cellule">Joueur 2</th>
                                    <!-- <th width="150" align="center" valign="middle" class="cellule">Score Vainqueur (nb sets)</th>
                                    <th width="150" align="center" valign="middle" class="cellule">Score Perdant (nb sets)</th>
                                    <th width="100" align="center" valign="middle" class="cellule">Type Match</th> -->
                            <!-- Rows to not display, but which still need to send through the form -->
                                    <!-- <th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Date du match (à transmettre)</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Tournoi</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Categorie</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Poids</th>
                                    <th width="150" align="center" valign="middle" class="cellule" style="display:none">Sequence</th> -->
                                  </tr>

                                  <!-- </table> -->
                                  <?php
                                }
                              }

                              if (strtotime(date('Y-m-d H:i:s')) < strtotime($donnees['RES_MATCH_DAT'])) {
                                  //echo "Match à saisir = " . $matchASaisir . "<br />";

                                  // Si on clique sur "saisie du résultat", renvoi vers ancre "FinListeMatchs"
                                  //echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "<a href=pronostique_matchs.php?ResMatchId=".$matchASaisir."#FinListeMatchs>" . " Saisir le score</a> (" . $diffStr . " restants)<br />";
                                  $GLOBALS['pageOrigine'] = 'pronostique_matchs2';
                                  // include ("formulairePronostiqueMatchASaisir.php");
                                  // include ("formulairePronostiqueMatchASaisir2.php");

                                  //==================================================
                                  //Lines of the table to display matches to prognosis
                                  //==================================================
                                  //Redirection du formulaire selon si on fait une saisie de résultat (Admin) ou un pronostique (Autre)
                                    if ($_SESSION['JOU_PSE'] == "Admin") {
                                      // echo "Formulaire - pageOrigine = " . $pageOrigine . "<br />";
                                      if ($pageOrigine == 'gestionMatchs_correction') {
                                      ?>
                                      <!-- <form action="formulairePronostiqueUnitaireCible.php" method="post" enctype="multipart/form-data"> -->
                                        <form action="formulaireSaisieResultatCible2.php" method="post" enctype="multipart/form-data">
                                      <?php
                                      } else {
                                        ?>
                                        <form action="formulaireSaisieResultatCible2.php" method="post" enctype="multipart/form-data">
                                        <?php
                                      }
                                    }
                                    else {
                                      // echo "Formulaire - pageOrigine = " . $pageOrigine . "<br />";
                                      if ($pageOrigine == 'pronostique_matchs2') {
                                      ?>
                                        <form action="pronostique_matchs2.php" method="post" enctype="multipart/form-data">
                                        <!-- <form action="pronostique_matchs2.php" method="post" enctype="multipart/form-data"> -->
                                      <?php
                                      } else {
                                        ?>
                                        <form action="pagePerso.php" method="post" enctype="multipart/form-data">
                                        <?php
                                      }
                                    }

                                    $GLOBALS['pageOrigine'] = 'pronostique_matchs2';
                                    include ("formulairePronostiqueMatchASaisir2_table.php");
                                  ?>
                                  </form>

                                  <!-- <form id="pronostique_match_form" action="formulaireSaisieResultatCible2.php" method="post">
                                  <tr>
                                    <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
                                    <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
                                    <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                                    <td align="center" valign="middle" class="cellule">
                                        <input type="radio" id="V" name="VouD" value="V">
                                        <input type="radio" id="D" name="VouD" value="D">
                                    </select></td>
                                    <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td> -->
                                    <!-- <td width="150" align="center" valign="middle" class="cellule"><?php echo "<a href=pronostique_matchs.php?ResMatchId=".$matchASaisir."#FinListeMatchs class='button'>" . "<b>Saisir le score</b></a><br />"; ?></td> -->
                                    <!-- <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Valider"></td>
                                    <td width="200" align="center" valign="middle" class="cellule">(reste <?php echo $diffStr; ?> )</td>
                                  </tr>
                                  </form> -->

                                  <?php
                              }
                              else {
                                ?>
                                <!-- ================================================== -->
                                <!-- Lines of the table to display matches to prognosis -->
                                <!-- ================================================== -->
                                <tr>
                                  <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
                                  <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
                                  <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                                  <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                                  <td width="250" align="center" valign="middle" class="cellule" style="color:red;"><i>Date de saisie dépassée</i></td>
                                  <!-- <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Saisir le score" ></td> -->
                                  <!-- <td width="200" align="center" valign="middle" class="cellule"></td> -->
                                </tr>
                                <?php
                                  // echo $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs. " . $donnees['RES_MATCH_JOU2'] . " --> " . "Date de saisie dépassée<br />";
                              }
                              ?>
                              <?php
                            }
                            $datePrecedente = $donnees['RES_MATCH_DAT'];
                            $niveauPrecedent = $donnees['RES_MATCH_TOUR'];
                        }

                        ?>
                        </table>

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

                                    echo "<br />Pronostiquez votre score pour ce match :<br /><br />";

                                    $GLOBALS['pageOrigine'] = 'pronostique_matchs';
                                    // include ("formulairePronostiqueMatchASaisir.php");
                                    include ("formulairePronostiqueMatchASaisir2.php");
                                    // if (isset($_POST['TypeMatch'])
                                    // or  isset($_POST['VouD'])
                                    // or  isset($_POST['ScoreJ1'])
                                    // or  isset($_POST['ScoreJ2']))
                                    //   // $session_jou_id = $_SESSION['JOU_ID'];
                                    //   include ("pronostique_matchs_controles.php");
                                    // }
                                 }
                            }
                          //   else {
                          //       echo "<span class='warning'>ERREUR TECHNIQUE - Vous ne pouvez pas enregistrer votre score. Contacter l'administrateur du site</span><br />";
            	            // }
                        }
                    }
                    else {
                      // Y a-t-il des matchs dans la table "resultats" ?
                      $isresultatstableempty = getResultatsTableNbRows();
                      $nbRow = $isresultatstableempty->rowcount();

                      if ($nbRow == 0) {
                        // Le tournoi n'a pas encore commencé
                        echo "<span class='congrats'>Le tournoi n'a pas encore commencé. Les matchs du 1er tour seront en ligne bientôt<br /></span><br />";
                      }
                      else {
                        // Le joueur est à jour de ses pronostiques
                        echo "<span class='congrats'>Vous êtes à jour dans vos pronostiques.<br /></span><br />";
                        echo "Vous pouvez toutefois les modifier si vous le souhaitez dans la section <a href='pagePerso.php'>Page Perso</a><br />";
                      }
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
