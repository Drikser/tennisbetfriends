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

    		<?php
        //*************************************************************************************************************************************************
    		//*                                         CHARGEMENT TABLE DES JOUEURS
    		//*************************************************************************************************************************************************
            //1) extraction du noms des joueurs à partir du tableau issu du site de l'atp: www.atpworldtour.com;

            $rowcount = getPlayersTournament();

            $donnees = $rowcount->fetch();

            echo '<br />' . 'Nombre de joueurs avant chargement = ' . $donnees['NbPlayersTournament'] . '<br />';

            if ($donnees['NbPlayersTournament'] == 0) {

              $adresse = "https://www.atptour.com/en/scores/current/us-open/560/draws";

              $page = file_get_contents($adresse);

              //preg_match_all ('#src="/en/~/media/images/flags/([a-z]{3}).svg"/>
//([A-Za-z]+(([ -])[A-Za-z]+)+)</a>#', $page, $player);
            //   preg_match_all ('#data-ga-label="([A-Za-z]+(([ -])[A-Za-z]+)+)">
            // <img class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>|<td>
            //           Bye
            //       </td>#', $page, $player);

              // preg_match_all ('#data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg" />|<td>\s*Bye\s*</td>#', $page, $player);
              // Australian Open 2021
              // preg_match_all ('#data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>|<td>\s*Qualifier/Lucky Loser\s*</td>#', $page, $player);
              preg_match_all ('#data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>|<td>\s*Qualifier\s*</td>#', $page, $player);
              // Australian Open 2021 avec têtes de série
              // preg_match_all ('#<span>\s*\((0-9)+\)\s*</span>\s* --- continuer ici --- data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>|<td>\s*Qualifier/Lucky Loser\s*</td>#', $page, $player);

              echo "URL=" . $adresse . "<br />";
              var_dump($player); // Le var_dump() du tableau $prix nous montre que $prix[0] contient l'ensemble du morceau trouvé et que $prix[1] contient le contenu de la parenthèse capturante

              for($i = 0; $i < count($player[1]); $i++) // On parcourt le tableau $player[1]
              {
                  //echo "ligne=" . $player[1][$i] . " (" . $player[4][$i] . ")<br />"; // On affiche le joueur et son pays

                  if (empty($player[1][$i])) {
                    // loadTournamentPlayers("Bye", $player[4][$i], "N");
                    // loadTournamentPlayers("Qualifier/Lucky Loser", $player[4][$i], "N");
                    loadTournamentPlayers("Qualifier", $player[4][$i], "N");
                  }
                  else {
                    loadTournamentPlayers($player[1][$i], $player[4][$i], "Y");
                  }
                  //    echo "ligne=" . $player[1][$i] . "<br />"; // On affiche le joueur
              }

              $rowcount = getPlayersTournament();

              $donnees = $rowcount->fetch();
              $nbPlayersTournament = $donnees['NbPlayersTournament'];

              echo '<br />' . 'Nombre de joueurs après chargement = ' . $nbPlayersTournament . '<br />';

              // $typTournament = "";
              // getTournament();
              // while ($donnees = $tournament->fetch())
              // {
              //    $typTournament = $donnees['SET_TYP'];
              // }

              // test pour vérifier qu'on a bien chargé le bon nombre de joueurs
              // if ($typTournament == 'GC') {
              //   echo "Grand chelem, 128 joueurs attendus";
                if ($nbPlayersTournament != 128) {
                  echo "<span class='warning'>128 joueurs attendus, seulement " . $nbPlayersTournament . " chargés !</span><br />";
                  echo "<span class='warning'>Vérifier la liste</span><br />";
                }
              // }

            }
            else {
              if (isset($_POST['Nom']) AND ($_POST['Reset'] == 'Reset')) {
                resetListPlayers();
                echo '<br />Liste des joueurs éffacée. Table vide.<br />';
              } else {
                echo '<br />Table non vide. Vider la table avant un nouveau chargement.<br />';
              }
            }

          ?>

        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
