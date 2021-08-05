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

                    echo (date('Y-m-d H:i:s')) . " <i>(heure locale)</i><br /><br />";
                    //echo (date('Y-m-d G:H:s')) . "<br /><br />";

                    //echo "<br />";

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
                        if ($result=="" OR ($scoreJ1=="0" and $scoreJ2=="0" and $typeMatch==""))
                        {
                          echo "<span class='warning'>Tous les champs doivent être remplis. Vous avez saisit : </span><br />";
                          echo "<span class='warning'>Resultat=" . $result . ", Score=" . $scoreJ1 . "/" . $scoreJ2 . "</span><br />";
                          // echo "<span class='warning'>Retour au formulaire de saisie de pronostique: </span>" . '<a href="pronostique.php">Cliquer ici</a>';
                          echo "<span class='warning'>Retour au formulaire de saisie: </span>";
                          ?>
                          <input type="button" value="OK" onclick="history.go(-1)">
                          <?php
                        }
                        else
                        {
                          //echo "Le match saisit est le match n°" . $_POST['idMatch'] . '<br />'; //idMAtch est la valeur du champs caché du formulaire de saisie de score
                          // echo "Le joueur est l'ID n°" . $_SESSION['JOU_ID'] . '<br />';

                          // convert match type from english to french for process, if english version
                          // RET --> AB
                          if ($typeMatch == 'RET') {
                            ConvertTypeResult($typeMatch);
                            $typeMatch = $outputTypeResult;
                          }

                          // convert result from english to french for process, if english version
                          // W --> V
                          // L --> D
                          if ($result == 'W' or $result == 'L') {
                            ConvertResultETF($result);
                            $result = $outputResult;
                          }

                          //Contrôles avant chargement :
                          $pronoOK = 'OK';

                          // echo "After conversion  ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

                          switch ($typeMatch) {
                            case 'AB':
                              if ($_POST['TypeTournoi'] != 'GC') {

                              //echo "type de tournoi différent de GC : <" . $_POST['TypeTournoi'] . "><br />";
                                 if ($scoreJ1 == 2 OR $scoreJ2 == 2) {
                                     echo "<span class='warning'>Mauvais score renseigné : Si un joueur a gagné 2 sets il ne peut pas y avoir abandon</span><br />";
                                     $pronoOK = 'KO';
                                 }

                              } else {
                                if ($scoreJ1 == 3 OR $scoreJ2 == 3) {
                                //echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 3 sets !!! Type Tournoi = " . $_POST['TypeTournoi'] . "</span><br />";
                                  echo "<span class='warning'>Mauvais score renseigné : Si un joueur a gagné 3 sets il ne peut pas y avoir abandon</span><br />";
                                  $pronoOK = 'KO';
                                }
                              }

                              if ($_POST['TypeTournoi'] != 'GC') {

                                if ($scoreJ1 == 2) {
                                  echo "<span class='warning'>Attention : Le perdant ne peut pas abandonner si le gagnant a déjà 2 sets</span><br />";
                                  $pronoOK = 'KO';
                                }

                              } else {
                                if ($scoreJ1 == 3) {
                                  echo "<span class='warning'>Attention : Le perdant ne peut pas abandonner si le gagnant a déjà 3 sets</span><br />";
                                  $pronoOK = 'KO';
                                }
                              }


                              break;

                            case 'WO':

                              if ($scoreJ1 != 0 OR $scoreJ2 != 0) {
                                echo "<span class='warning'>Attention : si il y a forfait, le score doit être 0-0</span><br />";
                                $pronoOK = 'KO';
                              }

                              break;

                            default:
                                        if ($scoreJ1 == 0) {
                                            echo "<span class='warning'>Mauvais score renseigné : Le vainqueur ne peut pas gagner avec 0 set</span><br />";
                                            $pronoOK = 'KO';
                                        }

                                        if ($_POST['TypeTournoi'] != 'GC') {

                                          //echo "type de tournoi différent de GC : <" . $_POST['TypeTournoi'] . "><br />";

                                          if ($scoreJ1 != 2) {
                                              //echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 2 sets !!! Type Tournoi <" . $_POST['TypeTournoi'] . "></span><br />";
                                              echo "<span class='warning'>Mauvais score renseigné : Le vainqueur doit gagner 2 sets</span><br />";
                                              $pronoOK = 'KO';
                                          }
                                        }
                                        else {

                                          if ($scoreJ1 != 3) {
                                            //echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 3 sets !!! Type Tournoi = " . $_POST['TypeTournoi'] . "</span><br />";
                                            echo "<span class='warning'>Mauvais score renseigné : Le vainqueur doit gagner 3 sets</span><br />";
                                              $pronoOK = 'KO';
                                          }
                                        }

                                        if ($scoreJ2 >= $scoreJ1) {
                                            echo "<span class='warning'>Mauvais score renseigné : Le nombre de sets du perdant doit être inférieur au vainqueur</span><br />";
                                            $pronoOK = 'KO';
                                        }

                              break;
                          }

                          // echo "pronoOK=" . $pronoOK . "<br />";

                          //Chargement des scores en table MySQL des pronostiques
                          $nbRow = 0;

                          if ($pronoOK == 'OK') {

                            // echo "updatePrognosis(" . $_SESSION['JOU_ID'] . ", " . $_POST['idMatch'] . ", " . $result . ", " . $scoreJ1 . ", " . $scoreJ2 . ", " . $typeMatch . ") <br />";
                            $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch);

                            $nbRow = $req->rowcount();
                          }
                          else {

                            echo "<span class='warning'>Votre pronostique: " . $result . " " . $scoreJ1 . "/" . $scoreJ2 . "</span><br />";
                            echo "<span class='warning'>Retour au formulaire de saisie: </span>";
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
                              switch ($typeMatch) {
                                case 'AB':
                                  echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> par abandon : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player2']) . '</span><br />';
                                  break;

                                case 'WO':
                                  echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> par forfait. </span><br />';
                                  break;

                                default:
                                  echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . '</span><br />';
                                  break;
                               }
                             }
                             else {
                              switch ($typeMatch) {
                                case 'AB':
                                  echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> par abandon : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player1']) . '</span><br />';
                                  break;

                                case 'WO':
                                  echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> par forfait. </span><br />';
                                  break;

                                default:
                                  echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . '</span><br />';
                                  break;
                              }
                            }

                            echo '<span class=info>Vous pouvez modifier ce pronostique dans la section <a href="pagePerso.php">' . 'Page perso' . '</a> </span>';
                            // echo '<br />Pour faire un nouveau pronostique, clique <a href="pronostique_matchs.php">' . 'ICI' . '</a><br/>';
                            // echo '<br /><a href="pronostique_matchs.php" class="button">' . 'Nouveau pronostique' . '</a><br/>';
                            ?>
                            <input type="button" value="OK" onclick="window.location.href='pronostique_matchs.php'"><br />
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
                            //var_dump($diff);
                            //echo $diffStr;

                            //$remainingTime = strtotime($donnees['RES_MATCH_DAT']) - strtotime(date('Y-m-d H:i:s'));

                            //echo "Il vous reste " . $remainingTime . " pour faire votre pronostique.<br /><br />";

                            if (($donnees['RES_MATCH_JOU1'] != "Bye") AND ($donnees['RES_MATCH_JOU2'] != "Bye")) {


                              // Nouvelle table avec titre si le tour est différent
                              if ($niveauPrecedent != $donnees['RES_MATCH_TOUR']) {
                                ?>
                                </table>
                                <?php
                                echo "<br /><span class='info'>" . $donnees['RES_MATCH_TOUR'] . "</span><br />";
                                ?>
                                <table>
                                <?php
                              } else {
                                // Séparation si la date est différente
                                if ($datePrecedente != $donnees['RES_MATCH_DAT']) {
                                  ?>
                                  </table>
                                  <br />
                                  <table>
                                  <?php
                                }
                              }

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
                                    <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
                                    <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                                    <td width="200" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                                    <td width="150" align="center" valign="middle" class="cellule"><?php echo "<a href=pronostique_matchs.php?ResMatchId=".$matchASaisir."#FinListeMatchs class='button'>" . "<b>Saisir le score</b></a><br />"; ?></td>
                                    <!-- <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Saisir le score" ></td> -->
                                    <td width="200" align="center" valign="middle" class="cellule">(reste <?php echo $diffStr; ?> )</td>
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
                            }
                            $datePrecedente = $donnees['RES_MATCH_DAT'];
                            $niveauPrecedent = $donnees['RES_MATCH_TOUR'];
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

                                    echo "<br />Pronostiquez votre score pour ce match :<br /><br />";

                                    $GLOBALS['pageOrigine'] = 'pronostique_matchs';
                                    include ("formulairePronostiqueMatchASaisir.php");
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
                        echo "<span class='congrats'>Vous êtes à jour dans vos pronostiques.<br /></span><br />";
                        echo "Vous pouvez toutefois les modifier si vous le souhaitez dans la section <a href='pagePerso.php'>Page Perso</a><br />";
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
