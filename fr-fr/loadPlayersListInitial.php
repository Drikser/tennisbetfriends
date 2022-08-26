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

            /////////////////////////////////////////////////////////////////
            // Test another way to extract data in web page
            // include_once('simple_html_dom.php');
            // require_once 'simple_html_dom.php';
            // $adresse = "https://www.atptour.com/en/tournaments/roland-garros/520/overview";
            // $htmlPage = file_get_html($adresse, false);
            //
            // foreach($html->find('.action-player') as $actionPlayerClass)
            //   echo $actionPlayerClass->src . '<br>';
            /////////////////////////////////////////////////////////////////


            if ($donnees['NbPlayersTournament'] == 0) {

              // ----- Gran Slams -----
              // $adresse = "https://www.atptour.com/en/tournaments/roland-garros/520/overview";
              // $adresse = "https://www.atptour.com/en/tournaments/roland-garros/520/overview";
              // $adresse = "https://www.atptour.com/en/tournaments/wimbledon/540/overview";
              $adresse = "https://www.atptour.com/en/tournaments/us-open/560/overview";
              // ----- Other tournaments for tests -----
              // $adresse = "https://www.atptour.com/en/tournaments/paris/352/overview";

              $page = file_get_contents($adresse);
              // Charger les premiers joueurs à partir de "Who is playing"
              //-------------------------------------------------------------
              preg_match_all ('#ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)" ga-action=""\s*ga-category="Who is Playing - Tournaments" ga-use="true">\s*<span>(.*?)<\/span><span>(.*?)<\/span>\s*</a>\s*<img alt="Country Flag" class="movement-flag " src="/-/media/images/flags/([a-z]{3}).svg#', $page, $player);
              // preg_match_all ('#ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)" ga-action=""\s*ga-category="Who is Playing - Tournaments" ga-use="true">#', $page, $player); // working --> renvoie liste de joueurs sans nationalité
              // preg_match_all ('#ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)" ga-action=""\s*ga-category="Who is Playing - Tournaments" ga-use="true">\s*<span>*</span><span>*</span>\S*</a>\s*<img alt="Country Flag" class="movement-flag " src="/-/media/images/flags/([a-z]{3}).svg#', $page, $player);
              // preg_match_all ('#ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)" ga-action=""\S*<img alt="Country Flag" class="movement-flag " src="/-/media/images/flags/([a-z]{3}).svg#', $page, $player);

              // Charger TOUS les joueurs à partir du tableau
              //------------------------------------------------
              // preg_match_all ('#data-ga-label="([A-Za-z\.]+(([ -])[A-Za-z]+)+)">\s*<img class="scores-draw-entry-box-players-item-flag" src="/en/~/media/images/flags/([a-z]{3}).svg" />|<td>\s*Qualifier/Lucky Loser\s*</td>#', $page, $player);

              var_dump($player); // Le var_dump() du tableau $prix nous montre que $prix[0] contient l'ensemble du morceau trouvé et que $prix[1] contient le contenu de la parenthèse capturante

              dropTablePlayers();
              createTablePlayers();

              $id = 0;
              $seed = 0;

              for($i = 0; $i < count($player[1]); $i++) // On parcourt le tableau $player[1]
              {
                  $id++;
                  echo "ligne=" . $id . " - ". $player[1][$i] . " (" . $player[6][$i] . ")<br />"; // On affiche le joueur et son pays

                  if (empty($player[1][$i])) {
                    // loadTournamentPlayers("Bye", $player[4][$i], "N");
                    loadTournamentPlayers($id, "Qualifier/Lucky Loser", $player[6][$i], "N", " ", 99);
                  }
                  else {
                    $seed++;
                    loadTournamentPlayers($id, $player[1][$i], $player[6][$i], "Y", " ", $seed);
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
