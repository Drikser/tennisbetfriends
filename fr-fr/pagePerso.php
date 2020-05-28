<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <?php require("../commun/header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php include("entete.php"); ?>

    <!-- Le menu -->

    <div id="conteneur">

        <?php include("menu.php"); ?>

        <!-- Le corps -->

        <div class="element_corps" id="corps">

            <h1>Recap des pronostiques</h1>

    		<!-- Connexion base de données -->

    		<?php
            //include("connexionSGBD.php");
            //include("../commun/model.php");
            ?>


    		 <!-- Vérification si on est connecté -->

    		 <?php
    		if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']))
    		{
    			//***********************************************************************************************************************************
    			//*                                  RECAPITULATIF DES PRONOSTIQUES D'AVANT TOURNOI
    			//***********************************************************************************************************************************
    		 	echo '<br /><h2>Pronostiques sur le tournoi</h2>';

    		 	//------------------------------    Sélection de la ligne de la table des pronostiques bonus   -----------------------
    		 	$bonus= getPronostique_Bonus($_SESSION['JOU_ID']);

    		 	while ($donnees = $bonus->fetch()) {

                //-------------------------------- Le vaiqueur -------------------------------
    		 		echo "<h4>Vainqueur du tournoi</h4>";
    		 		echo $donnees['PROB_VQR'] . "<br />";

                //-------------------------------- Les 2 finalistes -------------------------------
                    echo "<h4>Les finalistes</h4>";
                    echo " 1. " . $donnees['PROB_FINAL1'] . "<br />";
                    echo " 2. " . $donnees['PROB_FINAL2'] . "<br />";

                //-------------------------------- Les 4 demi-finalistes -------------------------------
    				echo "<h4>Les 4 demi-finalistes</h4>";
    				echo " 1. " . $donnees['PROB_DEMI1'] . "<br />";
    				echo " 2. " . $donnees['PROB_DEMI2'] . "<br />";
    				echo " 3. " . $donnees['PROB_DEMI3'] . "<br />";
    				echo " 4. " . $donnees['PROB_DEMI4'] . "<br />";

    				//echo "<h4>Meilleur français</h4>";
    				//echo $donnees['PROB_FR_NOM'] . "<br />";

    				//echo "<h4>Performance du meilleur français</h4>";
    				//echo $donnees['PROB_FR_NIV'] . "<br />";
    			}


    		 	//-------------------------------- Le meilleur français -------------------------------


    		 	//----------------------------- Performance du meilleur français -------------------------------









    			//***********************************************************************************************************************************
    			//*                                  RECAPITULATIF DES PRONOSTIQUES FAITS SUR LES MATCHS
    			//***********************************************************************************************************************************
    		 	echo '<br /><h2>Pronostiques des matchs</h2>';
            ?>
                <table>
                    <tr>
                        <!--<th width="100" align="center" valign="middle" class="cellule">Id Match</th> -->
                        <th width="150" align="center" valign="middle" class="cellule">Tour</th>
                        <th width="150" align="center" valign="middle" class="cellule">Date</th>
                        <th width="150" align="center" valign="middle" class="cellule">Joueur 1</th>
                        <th width="100" align="center" valign="middle" class="cellule">Pronostique Résultat</th>
                        <th width="150" align="center" valign="middle" class="cellule">Joueur 2</th>
                        <!-- <th width="100" align="center" valign="middle" class="cellule">Pronostique Type Match</th> -->
                        <th width="100" align="center" valign="middle" class="cellule">OFFICIEL Resultat</th>
                        <!-- <th width="50" align="center" valign="middle" class="cellule">OFFICIEL Type Match</th> -->
                        <th width="100" align="center" valign="middle" class="cellule">Pronostique Nb de points</th>
                    </tr>

                <?php
    			//
                $yourPrognosis = getYourPrognosis();
                //while ($donnees = $reponse->fetch()) {
                while ($donnees = $yourPrognosis->fetch()) {


                    $matchAModifier = $donnees['RES_MATCH_ID'];

                        ?>
                    <tr>
                        <!-- <td align="center" valign="middle" class="cellule"><input type="text" name="idMatch" class="form-control" id="idMatch" value= <?php echo $donnees['PRO_MATCH_ID']; ?> required="required"></td> -->
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['PRO_RES_MATCH'] . " " . $donnees['PRO_SCORE_JOU1'] . "/" . $donnees['PRO_SCORE_JOU2'] . " " . $donnees['PRO_TYP_MATCH']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                        <!-- <td align="center" valign="middle" class="cellule"><?php //echo $donnees['PRO_TYP_MATCH']; ?></td> -->
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH'] . " " . $donnees['RES_MATCH_SCR_JOU1'] . "/" . $donnees['RES_MATCH_SCR_JOU2'] . " " . $donnees['RES_MATCH_TYP']; ?></td>
                        <!-- <td align="center" valign="middle" class="cellule"><?php //echo $donnees['RES_MATCH_TYP']; ?></td> -->
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['PRO_PTS_JOU']; ?></td>

                        <?php
                        //date_default_timezone_set('Europe/Paris');
                        //echo 'date=' . date('Y-m-d G:H:s') . ' - Date du match=' . $donnees['RES_MATCH_DAT'] . ' - Resultat officiel=' . $donnees['RES_MATCH'] . '<br />';
    //                    if (strtotime(date('Y-m-d G:H:s')) < strtotime($donnees['RES_MATCH_DAT']) OR $donnees['RES_MATCH'] == "") {

                        if (strtotime(date('Y-m-d H:i:s')) < strtotime($donnees['RES_MATCH_DAT'])
                            and
                           ($donnees['RES_MATCH'] == "")) {
                              ?>
                            <td align="center" valign="middle" class="cellule"><?php echo "<a href=pagePerso.php?ResMatchId=" . $matchAModifier . "#FinListeMatchs>" . "Modifier pronostique</a>"; ?></td>
                        <?php
                        }
                        ?>
                    </tr>

                    <?php
    				}
                    ?>

                   </table>

                <div id="FinListeMatchs"></div>

                <?php
    			//$reponse->closeCursor();


                if (isset($_GET['ResMatchId'])) {

                    echo "<br />Vous souhaitez modifier votre pronostique pour le match suivant :<br />";

                    $idSessionJoueur = $_SESSION['JOU_ID'];
                    //echo "pseudo=" . $idSessionJoueur . "<br />";
                    //echo "Id du match à saisir" . $_GET['ResMatchId'] . "<br />";

                    $matchToModify = selectMatchToModify($_SESSION['JOU_ID'], $_GET['ResMatchId']);

                    //$matchChoisi = $_GET['ResMatchId'];

                    //$reponse = $bdd->query("SELECT *
                    //                         FROM pronostique p INNER JOIN resultats r
                    //                           ON p.PRO_MATCH_ID = r.RES_MATCH_ID
                    //                        WHERE p.PRO_JOU_ID = '$idSessionJoueur'
                    //                          AND r.RES_MATCH_ID = '$matchChoisi'
                    //                     ORDER BY r.RES_MATCH_DAT DESC");

                    while ($donnees = $matchToModify->fetch()) {
                        //echo $donnees['RES_MATCH_ID'] . " - " . $donnees['RES_MATCH_DAT'] . " - " . $donnees['RES_TOURNOI'] . " - " . $donnees['RES_MATCH_TOUR'] . " : " . $donnees['RES_MATCH_JOU1'] . " vs " . $donnees['RES_MATCH_JOU2'] . "<br />";

                        //$GLOBALS['$pageOrigine'] = 'pagePerso';
                        //$_SESSION['$pageOrigine'] = 'pagePerso';
                        include ("formulairePronostiqueMatchASaisir.php");
                    }

                    //$reponse->closeCursor();
                }
    		}
            ?>

        </div>
    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
