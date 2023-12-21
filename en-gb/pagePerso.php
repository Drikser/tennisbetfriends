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

        <h1>Your predictions</h1>

    		<?php
        $startDateTournament;

    		if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']))
    		{
    			//***********************************************************************************************************************************
    			//*                                  RECAPITULATIF DES PRONOSTIQUES D'AVANT TOURNOI
    			//***********************************************************************************************************************************
    		 	echo '<br /><h2>Bonus predictions</h2>';

          setlocale(LC_TIME, "fr_FR", "French");

          $tournament= getTournament();
          while ($donnees = $tournament->fetch())
          {
             $startDateTournament = $donnees['SET_DAT_START'];
          }
          // echo 'date=' . date('Y-m-d H:i:s') . ' / début du tournoi=' . $startDateTournament . '<br />';

          //----------------------------------------------------------------------------------------------------------
          //----------- On teste en début de page pour que la mise à jour puisse se voir dans le tableau récap
          //----------- Si il y a eu des modif de pronostique, une des valeurs doit être renseignée et donc à terster
          //----------------------------------------------------------------------------------------------------------
          if (isset($_POST['Winner'])) {
              $req = updateWinner($_SESSION['JOU_ID']);

              $nbRow = $req->rowcount();
              if ($nbRow > 0) {
                echo "<span class=info>As tournament winner you have chosen: </span>" . $_POST['Winner'] . "<br />";
                echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction.</span> ";
                ?>
                <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
                <?php
              }
          }

          if (isset($_POST['Final1']) and isset($_POST['Final2'])) {
            if ($_POST['Final1'] != $_POST['Final2']) {
              $req = updateFinal($_SESSION['JOU_ID']);

              $nbRow = $req->rowcount();

              if ($nbRow > 0) {
                  echo "<span class=info>You have chosen as tournament finalists: </span>" . $_POST['Final1'] . "<span class=info> and </span>" . $_POST['Final2'] . "<br />";
                  echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction.</span> ";
                  ?>
                  <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
                  <?php
              }
            } else {
              echo "<span class=warning>Both finalists must be different, please change your prediction.</span>";
              ?>
              <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
              <?php
            }
          }

          if (isset($_POST['Semi1']) and isset($_POST['Semi2']) and isset($_POST['Semi3']) and isset($_POST['Semi4'])) {
            if ($_POST['Semi1'] != $_POST['Semi2']
            and $_POST['Semi1'] != $_POST['Semi3']
            and $_POST['Semi1'] != $_POST['Semi4']
            and $_POST['Semi2'] != $_POST['Semi3']
            and $_POST['Semi2'] != $_POST['Semi4']
            and $_POST['Semi3'] != $_POST['Semi4'])
            {
              $req = updateSemi($_SESSION['JOU_ID']);

              $nbRow = $req->rowcount();

              if ($nbRow > 0) {
                  echo "<span class=info>You have chosen as tournament semi-finalists: </span>" . $_POST['Semi1'] . "<span class=info>, </span>" . $_POST['Semi2'] . "<span class=info>, </span>" . $_POST['Semi3'] . "<span class=info> and </span>" . $_POST['Semi4'] . "<br />";
                  echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction.</span> ";
                  ?>
                  <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
                  <?php
              }
            } else {
              echo "<span class=warning>The semi-finalists must be all different, please change your prediction.</span>";
              ?>
              <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
              <?php
            }
          }

          if (isset($_POST['BestFrench'])) {
              $req = updateBestFrench($_SESSION['JOU_ID']);

              $nbRow = $req->rowcount();
              if ($nbRow > 0) {
                  echo "<span class=info>You have chosen as the best Frenchman: </span>" . $_POST['BestFrench'] . "<br />";
                  echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction.</span> ";
                  ?>
                  <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
                  <?php
              }
          }

          if (isset($_POST['LevelFrench'])) {
              $req = updateLevelFrench($_SESSION['JOU_ID']);

              $nbRow = $req->rowcount();

              if ($nbRow > 0) {
                  $outputRound = ConvertRoundFTE($_POST['LevelFrench']);
                  echo "<span class=info>You think the level of the best Frenchman will be: </span>" . $outputRound . "<br />";
                  echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction.</span> ";
                  ?>
                  <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
                  <?php
              }
          }
          //---------------------------------------------------------------------------------------------------------------------
          //----------- Fin des tests de retour du formulaire (si les joueurs ont fait des modifications dans leur pronostique)
          //---------------------------------------------------------------------------------------------------------------------

          ?>

          <table>
              <tr>
                  <th colspan="2" align="center" valign="middle" class="cellule">OFFICIAL</th>
                  <th align="center" valign="middle" class="cellule"></th>
                  <th colspan="2" align="center" valign="middle" class="cellule">YOUR PREDICTION</th>
              </tr>
              <tr>
                  <th width="200" align="center" valign="middle" class="cellule">Description</th>
                  <th width="200" align="center" valign="middle" class="cellule">Result</th>
                  <th align="center" valign="middle" class="cellule"></th>
                  <th width="200" align="center" valign="middle" class="cellule">Your choice</th>
                  <th width="80" align="center" valign="middle" class="cellule">Pts won</th>
              </tr>

              <?php
              //Recherche des matchs finale et demi-finale dans la table des résultats
            	//poids 1 = finale
            	//poids 2 = demi-finales
            	//--> Les demi-finalsites sont player1 et player2 pour les 2 matchs dont le poids est 2
            	//--> Les finalistes sont les joueurs player1 et player2 du match dont le poids est 1
            	//--> Le vainqueur est le vainqueur du match dont le poids est 1
              $OfficialSemi1 ="";
              $OfficialSemi2 ="";
              $OfficialSemi3 ="";
              $OfficialSemi4 ="";
              $OfficialFinalist1 ="";
              $OfficialFinalist2 ="";
              $OfficialWinner ="";
              $tabOfficialBestFrench = array();
              $OfficialBestFrench = "";
              $OfficialBestFrenchLevel = "";

            	$allSemisAndFinalists = getSemisAndFinalists();
            	//$allFinalists = getFinalists();

            	//while ($donnees = $response->fetch()) {
            	while ($donnees = $allSemisAndFinalists->fetch()) {

            		if ($donnees['RES_MATCH_POIDS_TOUR'] == 1) {
            			$OfficialFinalist1 = $donnees['RES_MATCH_JOU1'];
            			$OfficialFinalist2 = $donnees['RES_MATCH_JOU2'];

            			if ($donnees['RES_MATCH'] == 'V') {
            				$OfficialWinner = $donnees['RES_MATCH_JOU1'];
            			}

            			if ($donnees['RES_MATCH'] == 'D') {
            				$OfficialWinner = $donnees['RES_MATCH_JOU2'];
            			}
            		}

            		if ($donnees['RES_MATCH_POIDS_TOUR'] == 2) {
            			if ($OfficialSemi1 == "" and $OfficialSemi2 == "") {
            				$OfficialSemi1 = $donnees['RES_MATCH_JOU1'];
            				$OfficialSemi2 = $donnees['RES_MATCH_JOU2'];
            			} else {
            				$OfficialSemi3 = $donnees['RES_MATCH_JOU1'];
            				$OfficialSemi4 = $donnees['RES_MATCH_JOU2'];
            			}
            		}
            	}

              $iTab = 0;
            	$bonusFrNom = getBonusBestFrench();
            	while ($donnees = $bonusFrNom->fetch()) {
            		$tabOfficialBestFrench[$iTab] = $donnees['RESB_VALUE'];
            		$OfficialBestFrench = 'Y';
            		$iTab++;
            	}

            	$bonusFrNiv = getBonusLevelBestFrench();
            	while ($donnees = $bonusFrNiv->fetch()) {
            		$outputRound = ConvertRoundFTE($donnees['RESB_VALUE']);
            		$OfficialBestFrenchLevel = $outputRound;
            	}

              $bonus= getPronostique_Bonus($_SESSION['JOU_ID']);

              while ($donnees = $bonus->fetch()) {

                //change display for english version of the website
                $outputRound = ConvertRoundFTE($donnees['PROB_FR_NIV']);

              ?>

                <tr class="lignenormale">
                    <td align="center" valign="middle" class="cellule">Winner</td>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialWinner; ?></td>
                    <th align="center" valign="middle" class="cellule"></th>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_VQR']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_VQR_PTS']; ?></td>
                    <?php
                    // if ((strtotime(date('Y-m-d H:i:s')) < $startDateTournament)
                    if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <td align="center" valign="middle" class="cellule"><?php echo "<a href=pagePerso.php?updateBonus=1>" . "Change prediction</a>"; ?></td>
                    <?php
                    }
                    ?>
                </tr>
                <tr class="lignenormale2">
                    <td align="center" valign="middle" class="cellule" rowspan="2">Finalists</td>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialFinalist1; ?></td>
                    <th align="center" valign="middle" class="cellule"></th>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FINAL1']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FINAL1_PTS']; ?></td>
                    <?php
                    if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <td align="center" valign="middle" class="cellule" rowspan="2"><?php echo "<a href=pagePerso.php?updateBonus=2>" . "Change prediction</a>"; ?></td>
                    <?php
                    }
                    ?>
                </tr>
                <tr class="lignenormale2">
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialFinalist2; ?></td>
                    <th align="center" valign="middle" class="cellule"></th>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FINAL2']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FINAL2_PTS']; ?></td>
                </tr>
                <tr class="lignenormale">
                    <td align="center" valign="middle" class="cellule" rowspan="4">Semi-Finalists</td>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialSemi1; ?></td>
                    <th align="center" valign="middle" class="cellule"></th>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI1']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI1_PTS']; ?></td>
                    <?php
                    if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <td align="center" valign="middle" class="cellule" rowspan="4"><?php echo "<a href=pagePerso.php?updateBonus=3>" . "Change prediction</a>"; ?></td>
                    <?php
                    }
                    ?>
                </tr>
                <tr class="lignenormale">
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialSemi2; ?></td>
                    <th align="center" valign="middle" class="cellule"></th>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI2']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI2_PTS']; ?></td>
                </tr>
                <tr class="lignenormale">
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialSemi3; ?></td>
                    <th align="center" valign="middle" class="cellule"></th>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI3']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI3_PTS']; ?></td>
                </tr>
                <tr class="lignenormale">
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialSemi4; ?></td>
                    <th align="center" valign="middle" class="cellule"></th>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI4']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI4_PTS']; ?></td>
                </tr>
                <tr class="lignenormale2">
                    <td align="center" valign="middle" class="cellule">Best Frenchman</td>
                    <td align="center" valign="middle" class="cellule"><b>
              				<?php
              				$i = 0;
              				foreach($tabOfficialBestFrench as $OfficialbestFrench) {
              					if ($i <= $iTab) {
              						echo $tabOfficialBestFrench[$i] . '<br />';
              						$i++;
              					}
              				}
              				?>
              			</td>
                    <th align="center" valign="middle" class="cellule"></th>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FR_NOM']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FR_NOM_PTS']; ?></td>
                    <?php
                    if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <td align="center" valign="middle" class="cellule"><?php echo "<a href=pagePerso.php?updateBonus=4>" . "Change prediction</a>"; ?></td>
                    <?php
                    }
                    ?>
                </tr>
                <tr class="lignenormale">
                    <td align="center" valign="middle" class="cellule">Level of the best Frenchman</td>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialBestFrenchLevel; ?></td>
                    <th align="center" valign="middle" class="cellule"></th>
                    <td align="center" valign="middle" class="cellule"><?php echo $outputRound; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FR_NIV_PTS']; ?></td>
                    <?php
                    if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <td align="center" valign="middle" class="cellule"><?php echo "<a href=pagePerso.php?updateBonus=5>" . "Change prediction</a>"; ?></td>
                    <?php
                    }
                    ?>
                </tr>
            <?php
            }
            ?>

          </table>

          <div id="FinListeBonus"></div>

          <?php
          //-----------------------------------------------------------------------------------------
          //------- Si un joueur veut modifier son pronostique, affichage du formulaire correpondant
          //-----------------------------------------------------------------------------------------
          if (isset($_GET['updateBonus'])) {

              echo "<br />You want to change the following Bonus Prediction :<br />";

              $idSessionJoueur = $_SESSION['JOU_ID'];

              $bonusToModify = selectBonusToModify($_SESSION['JOU_ID']);

              while ($donnees = $bonusToModify->fetch()) {
                $updateWinner = $donnees['PROB_VQR'];
                $updateFinal1 = $donnees['PROB_FINAL1'];
                $updateFinal2 = $donnees['PROB_FINAL2'];
                $updateSemi1 = $donnees['PROB_DEMI1'];
                $updateSemi2 = $donnees['PROB_DEMI2'];
                $updateSemi3 = $donnees['PROB_DEMI3'];
                $updateSemi4 = $donnees['PROB_DEMI4'];
                $updateBestFrench = $donnees['PROB_FR_NOM'];
                $updateBestFrenchLevel = $donnees['PROB_FR_NIV'];

                //******* Test de quel pronostique bonus il faut afficher le formulaire
                switch ($_GET['updateBonus']) {

                  //------------------------------------------------------------------------
                  //------- updateBonus=1, on affiche le formulaire du vainqueur du tournoi
                  //------------------------------------------------------------------------
                  case 1:

                  ?>
                      <form action="pagePerso.php" method="post" enctype="multipart/form-data">
                      <p>

                      <?php
                      $param = "disp";
                      $listPlayersTournament = getAllPlayersTournament($param);
                      ?>
                      Winner : <select name="Winner" id="Winner" required="required"/><br />

                      <option value="<?php echo $updateWinner; ?>"><?php echo $updateWinner; ?></option>
                      <?php
                          while ($donnees = $listPlayersTournament->fetch())
                          {
                            if (!empty($donnees['PLA_SEED'])) {
                      ?>
                          <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                      <?php
                            } else {
                      ?>
                          <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                      <?php
                            }
                          }
                      ?>
                      </select>

                      <span data-html="true" info-text="NOTE:
                      [1], [2], ... = Seed number 1, 2, ...
                      [WC] = Wild Card (player accepted in the main draw at the discretion of the tournament)
                      [Q] = Qualifier (player who reaches the tournament's main draw by competing in a pre-tournament qualifying)
                      [LL] = Lucky loser (highest-ranked player to lose in the final round of qualifying, but still ends up qualifying because of a withdrawal)"
                      class='tooltip'> info</span>

                      </p>
                      <p>
                          <input type="submit" value="Submit" />
                          <!-- <input type="button" value="Annuler" onclick="history.go(-1)"> -->
                          <!-- <a href="pagePerso.php" class="button">Annuler</a> -->
                          <input type="button" value="Cancel" onclick="window.location.href='pagePerso.php'">
                      </p>
                      </form>
                      <?php
                    break;

                    //-----------------------------------------------------------------
                    //------- updateBonus=2, on affiche le formulaire des Finalistes
                    //------------------------------------------------------------------
                      case 2:

                      ?>
                          <form action="pagePerso.php" method="post" enctype="multipart/form-data">
    	                    <p>
    	                        <?php
                              $param = "disp";
    	                        $listPlayersTournament = getAllPlayersTournament($param);
    	                        ?>
    	                        Finalist 1 : <select name="Final1" id="Final1" required="required"/>
    	                        <option value="<?php echo $updateFinal1; ?>"><?php echo $updateFinal1; ?></option>
    	                        <?php
    	                            while ($donnees = $listPlayersTournament->fetch())
    	                            {
                                    if (!empty($donnees['PLA_SEED'])) {
        	                    ?>
        	                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
        	                    <?php
                                    } else {
                              ?>
        	                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
        	                    <?php
    	                             }
                                 }
    	                        ?>
    	                        </select>

                              <span data-html="true" info-text="NOTE:
                              [1], [2], ... = Seed number 1, 2, ...
                              [WC] = Wild Card (player accepted in the main draw at the discretion of the tournament)
                              [Q] = Qualifier (player who reaches the tournament's main draw by competing in a pre-tournament qualifying)
                              [LL] = Lucky loser (highest-ranked player to lose in the final round of qualifying, but still ends up qualifying because of a withdrawal)"
                              class='tooltip'> info</span>

                              <br />


    	                        <?php
                              $param = "disp";
    	                        $listPlayersTournament = getAllPlayersTournament($param);
    	                        ?>
    	                        Finalist 2 : <select name="Final2" id="Final2" required="required"/>
    	                        <option value="<?php echo $updateFinal2; ?>"><?php echo $updateFinal2; ?></option>
    	                        <?php
    	                            while ($donnees = $listPlayersTournament->fetch())
    	                            {
                                    if (!empty($donnees['PLA_SEED'])) {
        	                    ?>
        	                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
        	                    <?php
                                    } else {
                              ?>
        	                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
        	                    <?php
                                    }
                                  }
    	                        ?>
    	                        </select><br />

    	                    </p>
    	                    <p>
    	                        <input type="submit" value="Submit" />
                              <input type="button" value="Cancel" onclick="window.location.href='pagePerso.php'">
    	                    </p>
    	                    </form>
                          <?php
                        break;

                        //--------------------------------------------------------------------------------
                        //------- updateBonus=3, on affiche le formulaire du vainqueur des demi-inalistes
                        //--------------------------------------------------------------------------------
                        case 3:

                        ?>
                        <form action="pagePerso.php" method="post" enctype="multipart/form-data">
  	                    <p>
  	                        <?php
                            $param = "disp";
  	                        $listPlayersTournament = getAllPlayersTournament($param);
  	                        ?>
  	                        Semi-finalist 1 : <select name="Semi1" id="Semi1" required="required"/>
  	                        <option value="<?php echo $updateSemi1; ?>"><?php echo $updateSemi1; ?></option>
  	                        <?php
  	                            while ($donnees = $listPlayersTournament->fetch())
  	                            {
                                  if (!empty($donnees['PLA_SEED'])) {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                            <?php
                                  } else {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                            <?php
                                  }
                                }
  	                        ?>
  	                        </select>

                            <span data-html="true" info-text="NOTE:
                            [1], [2], ... = Seed number 1, 2, ...
                            [WC] = Wild Card (player accepted in the main draw at the discretion of the tournament)
                            [Q] = Qualifier (player who reaches the tournament's main draw by competing in a pre-tournament qualifying)
                            [LL] = Lucky loser (highest-ranked player to lose in the final round of qualifying, but still ends up qualifying because of a withdrawal)"
                            class='tooltip'> info</span>

                            <br />


  	                        <?php
                            $param = "disp";
  	                        $listPlayersTournament = getAllPlayersTournament($param);
  	                        ?>
  	                        Semi-finalist 2 : <select name="Semi2" id="Semi2" required="required"/>
  	                        <option value="<?php echo $updateSemi2; ?>"><?php echo $updateSemi2; ?></option>
  	                        <?php
  	                            while ($donnees = $listPlayersTournament->fetch())
  	                            {
                                  if (!empty($donnees['PLA_SEED'])) {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                            <?php
                                  } else {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                            <?php
                                  }
                                }
  	                        ?>
  	                        </select><br />

  	                        <?php
                            $param = "disp";
  	                        $listPlayersTournament = getAllPlayersTournament($param);
  	                        ?>
  	                        Semi-finalist 3 : <select name="Semi3" id="Semi3" required="required"/>
  	                        <option value="<?php echo $updateSemi3; ?>"><?php echo $updateSemi3; ?></option>
  	                        <?php
  	                            while ($donnees = $listPlayersTournament->fetch())
  	                            {
                                  if (!empty($donnees['PLA_SEED'])) {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                            <?php
                                  } else {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                            <?php
                                  }
                                }
  	                        ?>
  	                        </select><br />

  	                        <?php
                            $param = "disp";
  	                        $listPlayersTournament = getAllPlayersTournament($param);
  	                        ?>
  	                        Semi-finalist 4 : <select name="Semi4" id="Semi4" required="required"/>
  	                        <option value="<?php echo $updateSemi4; ?>"><?php echo $updateSemi4; ?></option>
  	                        <?php
  	                            while ($donnees = $listPlayersTournament->fetch())
  	                            {
                                  if (!empty($donnees['PLA_SEED'])) {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                            <?php
                                  } else {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                            <?php
                                  }
                                }
  	                        ?>
  	                        </select><br />
    	                    </p>
    	                    <p>
    	                        <input type="submit" value="Submit" />
                              <input type="button" value="Cancel" onclick="window.location.href='pagePerso.php'">
    	                    </p>
    	                    </form>

                          <?php
                        break;

                        //----------------------------------------------------------------------
                        //------- updateBonus=4, on affiche le formulaire du meilleur français
                        //----------------------------------------------------------------------
                        case 4:

                        ?>
                        <form action="pagePerso.php" method="post" enctype="multipart/form-data">

  	                    <?php
  	                    $listFrenchTournament = getAllFrenchTournament();
  	                    ?>

                        <p>
  	                    Best Frenchman : <select name="BestFrench" id="BestFrench" required="required"/><br />
  	                    <option value="<?php echo $updateBestFrench; ?>"><?php echo $updateBestFrench; ?></option>
  	                    <?php
  	                        while ($donnees = $listFrenchTournament->fetch())
  	                        {
                              if (!empty($donnees['PLA_SEED'])) {
                                ?>
          	                     <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
          	                    <?php
                              } else {
                                ?>
          	                     <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
          	                    <?php
                              }
  	                        }
  	                    ?>
  	                    </select>

                        <span data-html="true" info-text="NOTE:
                        [1], [2], ... = Seed number 1, 2, ...
                        [WC] = Wild Card (player accepted in the main draw at the discretion of the tournament)
                        [Q] = Qualifier (player who reaches the tournament's main draw by competing in a pre-tournament qualifying)
                        [LL] = Lucky loser (highest-ranked player to lose in the final round of qualifying, but still ends up qualifying because of a withdrawal)"
                        class='tooltip'> info</span>

  	                    </p>
  	                    <p>
  	                        <input type="submit" value="Submit" />
                            <input type="button" value="Cancel" onclick="window.location.href='pagePerso.php'">
  	                    </p>
                        </fieldset>
  	                    </form>

                        <?php
                        break;

                        //--------------------------------------------------------------------------------
                        //------- updateBonus=5, on affiche le formulaire du niveau du meilleur français
                        //--------------------------------------------------------------------------------
                        case 5:

                        ?>
                        <form action="pagePerso.php" method="post" enctype="multipart/form-data">

  	                    <?php
  	                    $listLevel = getAllLevel();
  	                    ?>

  	                    <p>
  	                    Level of the best Frenchman : <select type="text" name="LevelFrench" label="LevelFrench" required="required"/><br />

                        <?php
                        $outputRound = ConvertRoundFTE($updateBestFrenchLevel);
                        ?>
                        <option value="<?php echo $updateBestFrenchLevel; ?>"><?php echo $outputRound; ?></option>

  	                    <?php
  	                    while ($donnees = $listLevel->fetch()) {
                          $outputRound = ConvertRoundFTE($donnees['SET_LVL_LIBELLE']);
  	                       ?>
  	                       <option value="<?php echo $donnees['SET_LVL_LIBELLE']; ?>"><?php echo $outputRound; ?></option>
  	                       <?php
  	                    }
  	                    ?>
  	                    </select>

  	                    </p>
  	                    <p>
  	                        <input type="submit" value="Submit" />
                            <input type="button" value="Cancel" onclick="window.location.href='pagePerso.php'">
  	                    </p>
  	                    </form>

                        <?php
                        break;

                }
              }
          }

    			//***********************************************************************************************************************************
    			//*                                  RECAPITULATIF DES PRONOSTIQUES FAITS SUR LES MATCHS
    			//***********************************************************************************************************************************
    		 	echo '<br /><h2>Match predictions</h2>';

          // Les contrôles sont différents selon le tour du Tournoi
          // - Deux 1er tours, pas de score (juste choix du vainqueur)
          // - A partir du 3ème tour, scores
          // - A partir des 1/8ème de finale, introduction du joker pour doubles ses Points
          $GLOBALS['pageOrigine'] = 'pagePerso';
          include ("controleSaisie.php");

          ?>
                <table>
                    <tr>
                        <!--<th width="100" align="center" valign="middle" class="cellule">Id Match</th> -->
                        <th colspan="5" align="center" valign="middle" class="cellule">OFFICIAL</th>
                        <th align="center" valign="middle" class="cellule"></th>
                        <th colspan="2" align="center" valign="middle" class="cellule">YOUR PREDICTION</th>
                    </tr>
                    <tr>
                        <!--<th width="100" align="center" valign="middle" class="cellule">Id Match</th> -->
                        <th width="150" align="center" valign="middle" class="cellule">Round</th>
                        <th width="150" align="center" valign="middle" class="cellule">Date</th>
                        <th width="200" align="center" valign="middle" class="cellule">Player 1</th>
                        <th width="100" align="center" valign="middle" class="cellule">Result</th>
                        <th width="200" align="center" valign="middle" class="cellule">Player 2</th>
                        <!-- <th width="100" align="center" valign="middle" class="cellule">Pronostique Type Match</th> -->
                        <th align="center" valign="middle" class="cellule"></th>
                        <th width="100" align="center" valign="middle" class="cellule">Result</th>
                        <!-- <th width="50" align="center" valign="middle" class="cellule">OFFICIEL Type Match</th> -->
                        <th width="80" align="center" valign="middle" class="cellule">Pts won</th>
                    </tr>

                <?php
    			//
                $yourPrognosis = getYourPrognosis();

                $ResMatchPoidsTourPrecedent = "";
                $colorLine = "";

                //while ($donnees = $reponse->fetch()) {
                while ($donnees = $yourPrognosis->fetch()) {

                    $matchAModifier = $donnees['RES_MATCH_ID'];

                    //change display for english version of the website
                    $outputRound = ConvertRoundFTE($donnees['RES_MATCH_TOUR']);
                    $ResMatch = convertResultFTE($donnees['RES_MATCH']);
                    $ResTypeMatch = convertTypeResultFTE($donnees['RES_MATCH_TYP']);
                    $ProResMatch = convertResultFTE($donnees['PRO_RES_MATCH']);
                    $ProTypeMatch = convertTypeResultFTE($donnees['PRO_TYP_MATCH']);

                    //Classe permettant de modifier légèrement la couleur des lignes en fonction du tour
          					if ($donnees['RES_MATCH_POIDS_TOUR'] !== $ResMatchPoidsTourPrecedent) {
          						if ($colorLine == '' or $colorLine == 'lignenormale2') {
          							$colorLine = 'lignenormale';
          						} else {
          							$colorLine = 'lignenormale2';
          						}
          					}
          					$ResMatchPoidsTourPrecedent = $donnees['RES_MATCH_POIDS_TOUR'];

                        ?>
                    <tr class="<?php echo $colorLine; ?>">
                        <!-- <td align="center" valign="middle" class="cellule"><input type="text" name="idMatch" class="form-control" id="idMatch" value= <?php echo $donnees['PRO_MATCH_ID']; ?> required="required"></td> -->
                        <td align="center" valign="middle" class="cellule"><?php echo $outputRound; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $ResMatch . " " . $donnees['RES_MATCH_SCR_JOU1'] . "/" . $donnees['RES_MATCH_SCR_JOU2'] . " " . $ResTypeMatch; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                        <th align="center" valign="middle" class="cellule"></th>
                        <?php
                        if ($donnees['PRO_DBL_PTS'] == 2) {
                        ?>
                          <td align="center" valign="middle" class="cellule"><?php echo "&#9733 " . $ProResMatch . " " . $donnees['PRO_SCORE_JOU1'] . "/" . $donnees['PRO_SCORE_JOU2'] . " " . $ProTypeMatch; ?></td>
                        <?php
                        } else {
                        ?>
                          <td align="center" valign="middle" class="cellule"><?php echo $ProResMatch . " " . $donnees['PRO_SCORE_JOU1'] . "/" . $donnees['PRO_SCORE_JOU2'] . " " . $ProTypeMatch; ?></td>
                        <?php
                        }
                        ?>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['PRO_PTS_JOU']; ?></td>

                        <?php
                        //date_default_timezone_set('Europe/Paris');
                        //echo 'date=' . date('Y-m-d G:H:s') . ' - Date du match=' . $donnees['RES_MATCH_DAT'] . ' - Resultat officiel=' . $donnees['RES_MATCH'] . '<br />';
    //                    if (strtotime(date('Y-m-d G:H:s')) < strtotime($donnees['RES_MATCH_DAT']) OR $donnees['RES_MATCH'] == "") {

                        if (strtotime(date('Y-m-d H:i:s')) < strtotime($donnees['RES_MATCH_DAT'])
                            and
                           ($donnees['RES_MATCH'] == "")) {
                              ?>
                            <td align="center" valign="middle" class="cellule"><?php echo "<a href=pagePerso.php?ResMatchId=" . $matchAModifier . "#FinListeMatchs>" . "Change prediction</a>"; ?></td>
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

                if (isset($_GET['ResMatchId'])) {

                    echo "<br />You want to change your prediction for the following match:<br />";

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

                        $GLOBALS['pageOrigine'] = 'pagePerso';
                        // echo "Origine = " . $pageOrigine . "<br />";
                        //$_SESSION['$pageOrigine'] = 'pagePerso';
                        if (($donnees['RES_MATCH_POIDS_TOUR'] == 64) or ($donnees['RES_MATCH_POIDS_TOUR'] == 32)) {
                          include ("formulairePronostiqueMatchASaisir2_entete.php");
                        } else {
                          include ("formulairePronostiqueMatchASaisir.php");
                        }
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
