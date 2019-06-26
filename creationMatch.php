<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <?php require("header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php include("entete.php"); ?>


    <div id="conteneur">

        <!-- Le menu -->

        <?php include("menu.php"); ?>

        <!-- Le corps -->

        <div class="element_corps" id="corps">
            <h1>Le coin de l'Admin</h1>

            <p>
                Création d'un nouveau match <br />
            </p>

    		<!-- Connexion base de données -->

    		<?php
        //*************************************************************************************************************************************************
    		//*                                         CHARGEMENT TABLE DES JOUEURS
    		//*************************************************************************************************************************************************
            //1) extraction du noms des joueurs à partir du tableau issu du site de l'atp: www.atpworldtour.com;

            $rowcount = getPlayersTournament();

            $donnees = $rowcount->fetch();

            echo '<br />' . 'Nombre de joueurs dans le tableau du tournoi = ' . $donnees['NbPlayersTournament'] . '<br />';


            if ($donnees['NbPlayersTournament'] == 0) {

              //$adresse = "https://www.atpworldtour.com/en/scores/current/nitto-atp-finals/605/draws";
              //$adresse = "https://www.atptour.com/en/scores/current/australian-open/580/draws";
              //$adresse = "https://www.atptour.com/en/scores/current/marseille/496/draws";
              //$adresse = "https://www.atptour.com/en/scores/current/dubai/495/draws";
              //$adresse = "https://www.atptour.com/en/scores/archive/miami/403/draws";
              //$adresse = "https://www.atptour.com/en/scores/current/monte-carlo/410/draws";
              //$adresse = "https://www.atptour.com/en/scores/current/barcelona/425/draws";
              //$adresse = "https://www.atptour.com/en/scores/current/madrid/1536/draws";
              //$adresse = "https://www.atptour.com/en/scores/current/roland-garros/520/draws";
              $adresse = "https://www.atptour.com/en/scores/current/antalya/7650/draws";

              $page = file_get_contents ($adresse);

            //preg_match_all ('#src="/en/~/media/images/flags/([a-z]{3}).svg"/>
//([A-Za-z]+(([ -])[A-Za-z]+)+)</a>#', $page, $player);
            preg_match_all ('#data-ga-label="([A-Za-z]+(([ -])[A-Za-z]+)+)">	<img class="scores-draw-entry-box-players-item-flag " src="/en/~/media/images/flags/([a-z]{3}).svg"/>#', $page, $player);

              //var_dump($player); // Le var_dump() du tableau $prix nous montre que $prix[0] contient l'ensemble du morceau trouvé et que $prix[1] contient le contenu de la parenthèse capturante

              for($i = 0; $i < count($player[1]); $i++) // On parcourt le tableau $player[1]
              {
                  echo "ligne=" . $player[1][$i] . " (" . $player[2][$i] . ")<br />"; // On affiche le joueur et son pays

                  loadTournamentPlayers($player[1][$i], $player[2][$i]);

              //    echo "ligne=" . $player[1][$i] . "<br />"; // On affiche le joueur
              }

            }

            ?>

            <!--
            //*************************************************************************************************************************************************
            //*                                         AFFICHAGE DU FORMULAIRE DE CREATION DE MATCH
            //*************************************************************************************************************************************************
            -->
            <p>
                Formulaire création match :
            </p>

            <?php
            //include("model.php");

            $tournament= getTournament();

            while ($donnees = $tournament->fetch())
            {
            ?>

                <form action="creationMatch.php" method="post" enctype="multipart/form-data">
                <p>
                    Tournoi : <input type="text" name="Tournoi" label="Tournoi" required="required" value="<?php echo $donnees['SET_TOURNAMENT']; ?>"/><br />
                    Catégorie du tournoi : <input type="text" name="Categorie" label="Categorie" required="required" value="<?php echo $donnees['SET_TYP_TOURNAMENT']; ?>"/><br />
                    Date du match : <input type="datetime-local" name="DateMatch" label="DateMatch" required="required"/><br />
                    <!--Heure du match : <input type="text" name="HeureMatch" label="HeureMatch" required="required"/><br /> -->
                    <!--Niveau de la compétition : <input type="text" name="Niveau" label="Niveau" required="required"/><br /> -->
    <!--                Joueur 1 : <input type="text" name="Joueur1" label="Joueur1" required="required"/><br />-->
    <!--                Joueur 2 : <input type="text" name="Joueur2" label="Joueur2" required="required"/><br />-->

                    <?php
                    $listLevel = getAllLevel();
                    ?>
                    Niveau de la compétition : <select name="Niveau" id="Niveau" required="required"/>
                    <option value="" selected></option>
                    <?php
                    while ($donnees = $listLevel->fetch())
                    {
                    ?>
                        <option value="<?php echo $donnees['SET_LVL_LIBELLE']; ?>"><?php echo $donnees['SET_LVL_LIBELLE']; ?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <br />

                    <?php
                    $listPlayersTournament = getAllPlayersTournament();
                    ?>
                    Joueur 1 : <select name="Joueur1" id="Joueur1" required="required"/>
                    <option value="" selected></option>
                    <?php
                    while ($donnees = $listPlayersTournament->fetch())
                    {
                    ?>
                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <br />

                    <?php
                    $listPlayersTournament = getAllPlayersTournament();
                    ?>
                    Joueur 2 : <select name="Joueur2" id="Joueur2" required="required"/><br />
                    <option value="" selected></option>
                    <?php
                    while ($donnees = $listPlayersTournament->fetch())
                    {
                    ?>
                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <br />


                </p>
                <p>
                    <input type="submit" value="Valider" />
                </p>
                </form>


            <?php
            }
            ?>


            <?php
            //*************************************************************************************************************************************************
            //*                                         TRAITEMENTS A FAIRE POUR LA CREATION D'UN MATCH
            //*************************************************************************************************************************************************

            if (isset($_POST['Tournoi']) OR isset($_POST['Categorie']) OR isset($_POST['DateMatch']) OR isset($_POST['Niveau']) OR isset($_POST['Joueur1']) OR isset($_POST['Joueur2'])) {


                    //Determination poids du tour
                    switch ($_POST['Niveau']) {

                    case 'FINALE':
                        $poidsTour = 1;
                        break;

                    case 'DEMI-FINALE':
                        $poidsTour = 2;
                        break;

                    case 'QUART DE FINALE':
                        $poidsTour = 4;
                        break;

                    case 'HUITIEME DE FINALE':
                        $poidsTour = 8;
                        break;

                    case '3EME TOUR':
                        $poidsTour = 16;
                        break;

                    case '2EME TOUR':
                        $poidsTour = 32;
                        break;

                    case '1ER TOUR':
                        $poidsTour = 64;
                        break;

                    default:
                        $poidsTour = 0;
                        break;
                }


                $newMatch = createMatch();
                //$nbRow = $req->rowcount();
                $nbRow = $newMatch->rowcount();

                if ($nbRow > 0)
                {

                    // récupérer l'Id du dernier match créé
                    //---------------------------------------
                    $lastMatch = getLastCreatedMatch();
                    $donnees = $lastMatch->fetch();
                    $idMatch = $donnees['idMax'];

                    //echo "ID du dernier match créé = " . $idMatch . '<br />';

                    // récupérer les Id de tous les joueurs inscrits
                    //------------------------------------------------
                    $allPlayers = getAllPlayers();
                    $nbRow = $allPlayers->rowcount();

                    if ($nbRow > 0) {
                        while ($donnees = $allPlayers->fetch()) {

                            createMatchToPrognosis($donnees['JOU_ID'],$idMatch);

                            //echo "Match " . $idMatch . " créé pour le joueur " . $donnees['JOU_ID'] . '<br />';
                        }

                        echo 'Bravo ! Match : ' . htmlspecialchars($_POST['Categorie']) . ' *** ' . htmlspecialchars($_POST['Tournoi']) . ' *** ' . htmlspecialchars($_POST['Niveau']) . ' *** ' . htmlspecialchars($_POST['DateMatch']) . ' : ' . htmlspecialchars($_POST['Joueur1']) . ' contre ' . htmlspecialchars($_POST['Joueur2']) . ' bien créé<br />';
                        echo 'Pour créer un nouveau match, clique <a href="creationMatch.php">' . 'ICI' . '</a><br/>';
                    }
                    else {
                        echo "<span class='warning'>Aucun joueur n'est encore enregistré pour le concours, les entrées n'ont pas été créées !</span><br />";
                    }
                }
                else
                {
                    echo "Match non créé pour une raison inconnue ... ";
                }
            }
            ?>

        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("piedDePage.php"); ?>

    </body>
</html>
