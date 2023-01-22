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

              // ----- Gran Slams -----
              $adresse = "https://www.atptour.com/en/scores/current/australian-open/580/draws";
              // $adresse = "https://www.atptour.com/en/scores/current/roland-garros/520/draws";
              // $adresse = "C:/wamp64/www/tennisbetfriends/tablesMySQL/tennisbetfriends/Database%20creations/Draw_RG2022/view-source_https___www.atptour.com_en_scores_current_roland-garros_520_draws.html";
              // $adresse = "https://www.atptour.com/en/scores/current/wimbledon/540/draws";
              // $adresse = "https://www.atptour.com/en/scores/current/us-open/560/draws";
              // ----- Other tournaments for tests -----
              // $adresse = "https://www.atptour.com/en/scores/current/paris/352/draws";

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
              // preg_match_all ('#data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>|<td>\s*Qualifier\s*</td>#', $page, $player); // ok in production
              //********************************
              //* Recherche des têtes de série *
              //********************************
              // 1) <td>([0-9]{1,2})</td> = numéro du joueur dans la liste
              // 2.a) <span>\s*\(([0-9]{1,2})\)\s*</span> = têtes de sére
              // 2.b) <span>\s*\(([0-9A-Z]{1,2})\)\s*</span> = têtes de sére + Q + LL + WC
              //                         1ère partie si tête de série trouvée                        |          2ème partie si pas de tête de série trouvée
              // preg_match_all ('#<td>([0-9]{1,2})</td>\s*<td>\s*<span>\s*\(([0-9A-Z]{1,2})\)\s*</span>|<td>([0-9]{1,2})</td>\s*<td>#', $page, $player);   // OK --> renvoi soit numéro du match soit tête de série / Q / LL /WC
              //                         1ère partie si tête de série trouvée                        |          2ème partie si pas de tête de série trouvée
              //----------------------------------------------------------------------------
              // Regedit avec 3 options:
              //----------------------------------------------------------------------------
              //1. Tête de série      :<td>([0-9]{1,3})</td>\s*<td>\s*<span>\s*\(([0-9A-Z]{1,2})\)\s*</span>\s*</td>\s*<td>\s*<a href="/en/players/([A-Za-z\.]+(([ -])[A-Za-z]+)+)/(.{4})/overview" class="scores-draw-entry-box-players-item" data-ga-action="Click"\s*data-ga-category="" data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>
              //2. Non tête de série  :<td>([0-9]{1,3})</td>\s*<td>\s*</td>\s*<td>\s*<a href="/en/players/([A-Za-z\.]+(([ -])[A-Za-z]+)+)/(.{4})/overview" class="scores-draw-entry-box-players-item" data-ga-action="Click"\s*data-ga-category="" data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>
              //3. Autre (Q/LL)       :<td>\s*Qualifier/Lucky Loser\s*</td>
              //----------------------------------------------------------------------------
              // preg_match_all ('#<td>([0-9]{1,3})</td>\s*<td>\s*<span>\s*\(([0-9A-Z]{1,2})\)\s*</span>\s*</td>\s*<td>\s*<a href="/en/players/([A-Za-z\.]+(([ -])[A-Za-z]+)+)/(.{4})/overview" class="scores-draw-entry-box-players-item" data-ga-action="Click"\s*data-ga-category="" data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>|<td>([0-9]{1,3})</td>\s*<td>\s*</td>\s*<td>\s*<a href="/en/players/([A-Za-z\.]+(([ -])[A-Za-z]+)+)/(.{4})/overview" class="scores-draw-entry-box-players-item" data-ga-action="Click"\s*data-ga-category="" data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>#', $page, $player);#', $page, $player);   // OK --> renvoi soit numéro du match soit tête de série / Q / LL /WC
              preg_match_all ('#<td>([0-9]{1,3})</td>\s*<td>\s*<span>\s*\(([0-9A-Z]{1,2})\)\s*</span>\s*</td>\s*<td>\s*<a href="/en/players/([A-Za-z\.]+(([ -])[A-Za-z\.]+)+)/(.{4})/overview" class="scores-draw-entry-box-players-item" data-ga-action="Click"\s*data-ga-category="" data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z\.]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>|<td>([0-9]{1,3})</td>\s*<td>\s*</td>\s*<td>\s*<a href="/en/players/([A-Za-z\.]+(([ -])[A-Za-z\.]+)+)/(.{4})/overview" class="scores-draw-entry-box-players-item" data-ga-action="Click"\s*data-ga-category="" data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z\.]+)+)">\s*<img alt="Country Flag" class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg"/>|<td>\s*Qualifier/Lucky Loser\s*</td>#', $page, $player);   // OK --> renvoi soit numéro du match soit tête de série / Q / LL /WC
              echo "URL=" . $adresse . "<br />";
              var_dump($player); // Le var_dump() du tableau $prix nous montre que $prix[0] contient l'ensemble du morceau trouvé et que $prix[1] contient le contenu de la parenthèse capturante

              dropTablePlayers();
              createTablePlayers();

              $id =0;

              for($i = 0; $i < count($player[7]); $i++) // On parcourt le tableau $player[1]
              {
                $id++;
                //-------------------------------------------------------------------------------------------------
                // - Si Christopher O'Connell est dans le tableau, exécuter le code ci-dessous:
                //      - Prendre le joueur suivant dans le tableau et ajouter 1 à son id
                //      - Ajouter manuellement Christopher O'Connell au tableau via update SQL
                // - sinon
                //      - NE PAS EXECUTER LE CODE CI-DESSOUS (mettre en commentaire avant de charger les joueurs)
                //-------------------------------------------------------------------------------------------------
                if ($player[7][$i] == 'Jenson Brooksby') {
                 $id++;
                 echo "Ajustement pour cet enflure d'O'Connell --> id de Vesely est maintenant " . $id . "<br />";
                }
                //--------------------------------------------------------------------------------------------------
                // Fin du code à exécuter si Christopher O'Connell est dans le tableau
                //--------------------------------------------------------------------------------------------------

                if (!empty($player[7][$i]))
                {
                  echo $player[1][$i] . ". " . $player[7][$i] . " (" . $player[10][$i] . ") [" . $player[2][$i] . "]<br />";
                  if (is_numeric($player[2][$i])) {
                    loadTournamentPlayers($player[1][$i], $player[7][$i], $player[10][$i], "Y", $player[2][$i], $player[2][$i]);
                    // loadTournamentPlayers($player[7][$i], $player[10][$i], "Y", $player[2][$i], $player[2][$i]);
                  } else {
                    loadTournamentPlayers($player[1][$i], $player[7][$i], $player[10][$i], "Y", $player[2][$i], 99);
                    // loadTournamentPlayers($player[7][$i], $player[10][$i], "Y", $player[2][$i], 99);
                  }
                } else {
                  if (!empty($player[16][$i]))
                  {
                    echo $player[11][$i] . ". " . $player[16][$i] . " (" . $player[19][$i] . ") <br />";
                    loadTournamentPlayers($player[11][$i], $player[16][$i], $player[19][$i], "Y", " ", 99);
                    // loadTournamentPlayers($player[16][$i], $player[19][$i], "Y", " ", 99);
                  } else {
                    echo "Qualifier/Lucky Loser<br />";
                    loadTournamentPlayers($id, "Qualifier/Lucky Loser", " ", "N", " ", 99);
                    // loadTournamentPlayers("Qualifier/Lucky Loser", " ", "N", " ", 99);
                  }
                }
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
                } else {
                  echo "<span class=congrats>INFO:</span>Totalité des 128 joueurs chargés avec succès.</span><br />";
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
