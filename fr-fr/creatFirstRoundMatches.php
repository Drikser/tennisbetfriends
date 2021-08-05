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
            //*                                            CREATION DES MATCHS DU PREMIER TOUR
            //*************************************************************************************************************************************************
            -->

            <?php
            // To create a match in the "resultats" table, we need the following information:
            // - match_id : auto increment
            // - tournoi : in query "getTournament"
            // - type de tournoi : in query "getTournament"
            // - date du match : par défaut, 1er jour du tounoi 11h
            // - tour : 1er tour
            // - poids du tour : nb of players / 2
            // - sequence : numéro du match par tour
            // - joueur 1
            // - joueur 2
            //

            //
            $rowcount = getPlayersTournament();
            $donnees = $rowcount->fetch();
            echo 'Nombre de joueurs engagés           = ' . $donnees['NbPlayersTournament'] . '<br />';
            $poids = $donnees['NbPlayersTournament'] / 2;
            echo 'Valeur variable "poids" du 1er tour = ' . $poids . '<br />';
            $seq = 0;
            $level = '1ER TOUR';
            echo 'Tour = ' . $level . '<br />';

            $tournament= getTournament();
            $donnees = $tournament->fetch();

            $nomTournoi = $donnees['SET_TOURNAMENT'];
            $typTournoi = $donnees['SET_TYP_TOURNAMENT'];
            $datePremierMatch = $donnees['SET_DAT_START'];

            echo 'Nom du tournoi  = ' . $nomTournoi . '<br />';
            echo 'Type du tournoi = ' . $typTournoi . '<br />';
            echo 'Date du match = ' . $datePremierMatch . '<br />';


//            while ($donnees = $tournament->fetch())
//            {
//              $nameTournament = $donnees['SET_TOURNAMENT'];
//              $typTournament = $donnees['SET_TYP_TOURNAMENT'];
//              echo '<br />' . 'Nom du tournoi  = ' . $donnees['SET_TOURNAMENT'] . '<br />';
//              echo '<br />' . 'Type du tournoi = ' . $donnees['SET_TYP_TOURNAMENT'] . '<br />';

//            }

            //$level = getLevel();


            //*************************************************************************************************************************************************
            //*                                         TRAITEMENTS A FAIRE POUR LA CREATION D'UN MATCH
            //*************************************************************************************************************************************************
            $param = "all";
            $listPlayers = getAllPlayersTournament($param);

            while ($loop = $listPlayers -> fetch()) {
              // - get last id
              // - if no existing id
              //   or id found and player 1 and player 2 different from space
              //   . create a new matchs
              // - else
              //   . update match with player 2

              //******* Créer le nom du joueur ave son pays pour les matchs
              //******* Si "Bye", laisser tel quel
              if ($loop['PLA_NOM'] != "Bye") {
                $playerFirstRound = $loop['PLA_NOM'] . " (" . $loop['PLA_PAY'] . ")";
              } else {
                $playerFirstRound = $loop['PLA_NOM'];
              }

              echo '--------- New player ' . $playerFirstRound . ' ---------<br />';

              $lastMatchID = getLastCreatedMatch();
              //$donnees = $lastMatchID->fetch();
              //echo 'Dernier match créé est : ' . $donnees['maxID'] . '<br />';

              $FirstMatch = $lastMatchID->fetch();
              //if ($FirstMatch = $lastMatchID->fetch()) {
              //    do {

              $jou1 = $FirstMatch['RES_MATCH_JOU1'];
              $jou2 = $FirstMatch['RES_MATCH_JOU2'];
              //$maxID =  $FirstMatch['idMax'];
              $maxID =  $FirstMatch['RES_MATCH_ID'];

              echo 'Dernier match créé est : Id max = ' . $maxID . ' --> Match ('. $poids . '-' . $seq . ')= ' . $jou1 . ' contre ' . $jou2 . '.<br />';

// test test test test test test test test test test test test
              // if (isset($jou1)) {
              //   echo 'isset jou1 (' . $jou1 . ') est vrai <br />';
              // } else {
              //   echo 'isset jou1 (' . $jou1 . ') est faux <br />';
              // }
              // if (empty($jou1)) {
              //   echo 'jou1 (' . $jou1 . ') est vide <br />';
              // } else {
              //   echo 'jou1 (' . $jou1 . ') est non vide <br />';
              // }
              // if (isset($jou2)) {
              //   echo 'isset jou2 (' . $jou2 . ') est vrai <br />';
              // } else {
              //   echo 'isset jou2 (' . $jou2 . ') est faux <br />';
              // }
              // if (empty($jou2)) {
              //   echo 'jou2 (' . $jou2 . ') est vide <br />';
              // } else {
              //   echo 'jou2 (' . $jou2 . ') est non vide <br />';
              // }
              // if (empty($maxID)) {
              //   echo 'maxID (' . $maxID . ') est vide <br />';
              // } else {
              //   echo 'maxID (' . $maxID . ') est non vide <br />';
              // }
// test test test test test test test test test test test test

              if (empty($maxID) or (!empty($jou1) and !empty($jou2))) {

                echo '   ===> Création nouveau match <br />';

                $maxID++;
                $seq++;

                //if (isset($_POST['Tournoi']) OR isset($_POST['Categorie']) OR isset($_POST['DateMatch']) OR isset($_POST['Niveau']) OR isset($_POST['Joueur1']) OR isset($_POST['Joueur2'])) {
                //if (!empty($nomTournoi) AND !empty($typTounoi) AND !empty($level) AND !empty($datePremierMAtch) AND !empty($poids) AND !empty($jou1)) {
                //if (isset($nomTournoi) AND isset($typTounoi) AND isset($level) AND isset($datePremierMAtch) AND isset($poids)) {

                echo 'Variables pour fonction createMatchFirstRound(): ' . $nomTournoi . ', ' . $typTournoi . ', ' . $datePremierMatch . ', ' . $level . ', ' . $poids . ', ' . $seq . ', ' . $playerFirstRound . '<br />';
                $newMatch = createMatchFirstRound();
                //$nbRow = $req->rowcount();
                $nbRow = $newMatch->rowcount();
                echo '$nbRow after calling createMatchFirstRound(): ' . $nbRow . '<br />';

                if ($nbRow > 0) {

                  // récupérer l'Id du dernier match créé
                  //---------------------------------------
                  $lastMatch = getLastCreatedMatch();
                  $donnees = $lastMatch->fetch();
                  //$idMatch = $donnees['idMax'];
                  $idMatch = $donnees['RES_MATCH_ID'];

                  echo "ID du dernier match créé = " . $idMatch . '<br />';

                  // récupérer les Id de tous les joueurs inscrits
                  //------------------------------------------------
                  $allPlayers = getAllPlayers();
                  $nbRow = $allPlayers->rowcount();

                  if ($nbRow > 0) {
                    while ($donnees = $allPlayers->fetch()) {

                    createMatchToPrognosis($donnees['JOU_ID'],$idMatch);
                    //echo "Match " . $idMatch . " créé pour le joueur " . $donnees['JOU_ID'] . '<br />';
                    }
                    echo 'Bravo ! Match : ' . htmlspecialchars($typTournoi) . ' *** ' . htmlspecialchars($nomTournoi) . ' *** ' . htmlspecialchars($level) . ' seq(' . $seq . ') *** ' . htmlspecialchars($datePremierMatch) . 'id=' . $maxID . ' : ' . htmlspecialchars($playerFirstRound) . ' contre ' . 'joueur 2 (en attente) bien créé<br />';
                    //echo 'Pour créer un nouveau match, clique <a href="creationMatch.php">' . 'ICI' . '</a><br/>';
                  } else {
                    echo "<span class='warning'>Aucun joueur n'est encore enregistré pour le concours, les entrées n'ont pas été créées !</span><br />";
                  }
                } else {
                  echo "Match non créé pour une raison inconnue ... ";
                }
                //}

                //echo 'Nouveau match créé : ' . $maxID . '<br />';

              } else {

                echo '   ===> Mise à jour du match <br />';
                echo 'Mise à jour du match : ' . $maxID . '<br />';

                $completedMatch = updateMatchFirstRound($maxID, $playerFirstRound);
                //$completedMatch = updateMatchFirstRound($maxID);

              }

              //    } while ($donnees = $lastMatchID->fetch());
              //}

              //if ($donnees['maxID'] > 0) {
              //  echo 'Dernier match créé est : ' . $donnees['maxID'] . '<br />';
              //}
              //else {
              //  echo 'Pas de match encore créés';
              //}
            }
            ?>

        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
