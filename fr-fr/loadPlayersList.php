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

              //$adresse = "https://www.atptour.com/en/scores/current/acapulco/807/draws";
              $adresse = "https://www.atptour.com/en/scores/archive/indian-wells/404/2019/draws";

              $page = file_get_contents ($adresse);

              //preg_match_all ('#src="/en/~/media/images/flags/([a-z]{3}).svg"/>
//([A-Za-z]+(([ -])[A-Za-z]+)+)</a>#', $page, $player);
              preg_match_all ('#data-ga-label="([A-Za-z]+(([ -])[A-Za-z]+)+)">	<img class="scores-draw-entry-box-players-item-flag " src="/en/~/media/images/flags/([a-z]{3}).svg"/>|<td>
                                    Bye
                                </td>#', $page, $player);

              var_dump($player); // Le var_dump() du tableau $prix nous montre que $prix[0] contient l'ensemble du morceau trouvé et que $prix[1] contient le contenu de la parenthèse capturante

              for($i = 0; $i < count($player[1]); $i++) // On parcourt le tableau $player[1]
              {
                  //echo "ligne=" . $player[1][$i] . " (" . $player[4][$i] . ")<br />"; // On affiche le joueur et son pays

                  if (empty($player[1][$i])) {
                    loadTournamentPlayers("Bye", $player[4][$i], "N");
                  }
                  else {
                    loadTournamentPlayers($player[1][$i], $player[4][$i], "Y");
                  }
                  //    echo "ligne=" . $player[1][$i] . "<br />"; // On affiche le joueur
              }

              $rowcount = getPlayersTournament();

              $donnees = $rowcount->fetch();

              echo '<br />' . 'Nombre de joueurs après chargement = ' . $donnees['NbPlayersTournament'] . '<br />';

            }
            else {
              echo '<br />Table non vide. Vider la table avant un nouveau chargement.<br />';
            }

          ?>

        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
