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

    		<?php
        $startDateTournament;

    		if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE']))
    		{
    			//***********************************************************************************************************************************
    			//*                                  RECAPITULATIF DES PRONOSTIQUES D'AVANT TOURNOI
    			//***********************************************************************************************************************************
    		 	echo '<br /><h2>Pronostiques bonus</h2>';

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
                echo "<span class=info>Tu as choisi comme vainqueur du tournoi : </span>" . $_POST['Winner'] . "<br />";
                echo "<span class=info>Tant que le tournoi n'est pas encore commencé, tu peux encore modifier ton pronostique.</span> ";
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
                  echo "<span class=info>Tu as choisi comme finalistes du tournoi : </span>" . $_POST['Final1'] . "<span class=info> et </span>" . $_POST['Final2'] . "<br />";
                  echo "<span class=info>Tant que le tournoi n'est pas encore commencé, tu peux encore modifier ton pronostique.</span> ";
                  ?>
                  <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
                  <?php
              }
            } else {
              echo "<span class=warning>Les deux finalistes doivent êtres différents, merci de corriger ton choix.</span>";
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
                  echo "<span class=info>Tu as choisi comme demi-finalistes du tournoi : </span>" . $_POST['Semi1'] . "<span class=info>, </span>" . $_POST['Semi2'] . "<span class=info>, </span>" . $_POST['Semi3'] . "<span class=info> et </span>" . $_POST['Semi4'] . "<br />";
                  echo "<span class=info>Tant que le tournoi n'est pas encore commencé, tu peux encore modifier ton pronostique.</span> ";
                  ?>
                  <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
                  <?php
              }
            } else {
              echo "<span class=warning>Tous les demi-finalistes doivent êtres différents, merci de corriger ton choix.</span>";
              ?>
              <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
              <?php
            }
          }

          if (isset($_POST['BestFrench'])) {
              $req = updateBestFrench($_SESSION['JOU_ID']);

              $nbRow = $req->rowcount();
              if ($nbRow > 0) {
                  echo "<span class=info>Tu as choisi comme meilleur français : </span>" . $_POST['BestFrench'] . "<br />";
                  echo "<span class=info>Tant que le tournoi n'est pas encore commencé, tu peux encore changer ton pronostique.</span> ";
                  ?>
                  <input type="button" value="OK" onclick="window.location.href='pagePerso.php'">
                  <?php
              }
          }

          if (isset($_POST['LevelFrench'])) {
              $req = updateLevelFrench($_SESSION['JOU_ID']);

              $nbRow = $req->rowcount();

              if ($nbRow > 0) {
                  echo "<span class=info>Tu penses que le niveau du meilleur sera : </span>" . $_POST['LevelFrench'] . "<br />";
                  echo "<span class=info>Tant que le tournoi n'est pas encore commencé, tu peux encore changer ton pronostique.</span> ";
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
                  <th colspan="2" align="center" valign="middle" class="cellule">OFFICIEL</th>
                  <th colspan="2" align="center" valign="middle" class="cellule">VOTRE PRONOSTIQUE</th>
              </tr>
              <tr>
                  <th width="200" align="center" valign="middle" class="cellule">Description</th>
                  <th width="200" align="center" valign="middle" class="cellule">Résultat</th>
                  <th width="200" align="center" valign="middle" class="cellule">Votre choix</th>
                  <th width="80" align="center" valign="middle" class="cellule">Nb pts</th>
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

              $bonus= getPronostique_Bonus($_SESSION['JOU_ID']);

              while ($donnees = $bonus->fetch()) {
              ?>

                <tr>
                    <td align="center" valign="middle" class="cellule">Vainqueur du tournoi</td>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialWinner; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_VQR']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_VQR_PTS']; ?></td>
                    <?php
                    // if ((strtotime(date('Y-m-d H:i:s')) < $startDateTournament)
                    if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <td align="center" valign="middle" class="cellule"><?php echo "<a href=pagePerso.php?updateBonus=1>" . "Modifier pronostique</a>"; ?></td>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td align="center" valign="middle" class="cellule" rowspan="2">Finalistes</td>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialFinalist1; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FINAL1']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FINAL1_PTS']; ?></td>
                    <?php
                    if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <td align="center" valign="middle" class="cellule" rowspan="2"><?php echo "<a href=pagePerso.php?updateBonus=2>" . "Modifier pronostique</a>"; ?></td>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialFinalist2; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FINAL2']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FINAL2_PTS']; ?></td>
                </tr>
                <tr>
                    <td align="center" valign="middle" class="cellule" rowspan="4">Demi-finalistes</td>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialSemi1; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI1']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI1_PTS']; ?></td>
                    <?php
                    if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <td align="center" valign="middle" class="cellule" rowspan="4"><?php echo "<a href=pagePerso.php?updateBonus=3>" . "Modifier pronostique</a>"; ?></td>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialSemi2; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI2']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI2_PTS']; ?></td>
                </tr>
                <tr>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialSemi3; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI3']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI3_PTS']; ?></td>
                </tr>
                <tr>
                    <td align="center" valign="middle" class="cellule"><?php echo $OfficialSemi4; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI4']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_DEMI4_PTS']; ?></td>
                </tr>
                <!-- <tr>
                    <td align="center" valign="middle" class="cellule">Meilleur français</td>
                    <td align="center" valign="middle" class="cellule"></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FR_NOM']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FR_NOM_PTS']; ?></td> -->
                    <?php
                    // if ((strtotime(date('Y-m-d H:i:s')) < $startDateTournament)
                    // if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <!-- <td align="center" valign="middle" class="cellule"><?php echo "<a href=pagePerso.php?updateBonus=4>" . "Modifier pronostique</a>"; ?></td> -->
                    <?php
                    // }
                    ?>
                <!-- </tr>
                <tr>
                    <td align="center" valign="middle" class="cellule">Niveau du meilleur français</td>
                    <td align="center" valign="middle" class="cellule"></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FR_NIV']; ?></td>
                    <td align="center" valign="middle" class="cellule"><?php echo $donnees['PROB_FR_NIV_PTS']; ?></td> -->
                    <?php
                    // if ((strtotime(date('Y-m-d H:i:s')) < $startDateTournament)
                    // if ((date('Y-m-d H:i:s') < $startDateTournament) and ($donnees['PROB_VQR'] != "")) {
                    ?>
                        <!-- <td align="center" valign="middle" class="cellule"><?php echo "<a href=pagePerso.php?updateBonus=5>" . "Modifier pronostique</a>"; ?></td> -->
                    <?php
                    // }
                    ?>
                <!-- </tr> -->
            <?php
            }
            ?>

          </table>

          <div id="FinListeBonus"></div>

          <?php
          if (isset($_GET['updateBonus'])) {

              echo "<br />Vous souhaitez modifier le pronostique bonus suivant :<br />";

              $idSessionJoueur = $_SESSION['JOU_ID'];

              $bonusToModify = getPronostique_Bonus($_SESSION['JOU_ID']);

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
                      Vainqueur du tournoi : <select name="Winner" id="Winner" required="required"/><br />

                      <option value="<?php echo $updateWinner; ?>"><?php echo $updateWinner; ?></option>
                      <?php
                          while ($donnees = $listPlayersTournament->fetch())
                          {
                            if (!empty($donnees['PLA_SEED'])) {
                      ?>
                          <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . '] '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                      <?php
                            } else {
                      ?>
                          <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                      <?php
                            }
                          }
                      ?>
                      </select>

                      </p>
                      <p>
                          <input type="submit" value="Valider" />
                          <!-- <input type="button" value="Annuler" onclick="history.go(-1)"> -->
                          <!-- <a href="pagePerso.php" class="button">Annuler</a> -->
                          <input type="button" value="Annuler" onclick="window.location.href='pagePerso.php'">
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
    	                        Finaliste 1 : <select name="Final1" id="Final1" required="required"/>
    	                        <option value="<?php echo $updateFinal1; ?>"><?php echo $updateFinal1; ?></option>
    	                        <?php
    	                            while ($donnees = $listPlayersTournament->fetch())
    	                            {
                                    if (!empty($donnees['PLA_SEED'])) {
        	                    ?>
        	                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . '] '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
        	                    <?php
                                    } else {
                              ?>
        	                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
        	                    <?php
                                    }
                                  }
    	                        ?>
    	                        </select><br />


    	                        <?php
                              $param = "disp";
    	                        $listPlayersTournament = getAllPlayersTournament($param);
    	                        ?>
    	                        Finaliste 2 : <select name="Final2" id="Final2" required="required"/>
    	                        <option value="<?php echo $updateFinal2; ?>"><?php echo $updateFinal2; ?></option>
    	                        <?php
    	                            while ($donnees = $listPlayersTournament->fetch())
    	                            {
                                    if (!empty($donnees['PLA_SEED'])) {
        	                    ?>
        	                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . '] '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
        	                    <?php
                                    } else {
                              ?>
        	                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
        	                    <?php
                                    }
                                  }
    	                        ?>
    	                        </select><br />

    	                    </p>
    	                    <p>
    	                        <input type="submit" value="Valider" />
                              <input type="button" value="Annuler" onclick="window.location.href='pagePerso.php'">
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
  	                        Demi-finaliste 1 : <select name="Semi1" id="Semi1" required="required"/>
  	                        <option value="<?php echo $updateSemi1; ?>"><?php echo $updateSemi1; ?></option>
  	                        <?php
  	                            while ($donnees = $listPlayersTournament->fetch())
  	                            {
                                  if (!empty($donnees['PLA_SEED'])) {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . '] '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                            <?php
                                  } else {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                            <?php
                                  }
                                }
  	                        ?>
  	                        </select><br />


  	                        <?php
                            $param = "disp";
  	                        $listPlayersTournament = getAllPlayersTournament($param);
  	                        ?>
  	                        Demi-finaliste 2 : <select name="Semi2" id="Semi2" required="required"/>
  	                        <option value="<?php echo $updateSemi2; ?>"><?php echo $updateSemi2; ?></option>
  	                        <?php
  	                            while ($donnees = $listPlayersTournament->fetch())
  	                            {
                                  if (!empty($donnees['PLA_SEED'])) {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . '] '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                            <?php
                                  } else {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                            <?php
                                  }
                                }
  	                        ?>
  	                        </select><br />

  	                        <?php
                            $param = "disp";
  	                        $listPlayersTournament = getAllPlayersTournament($param);
  	                        ?>
  	                        Demi-finaliste 3 : <select name="Semi3" id="Semi3" required="required"/>
  	                        <option value="<?php echo $updateSemi3; ?>"><?php echo $updateSemi3; ?></option>
  	                        <?php
  	                            while ($donnees = $listPlayersTournament->fetch())
  	                            {
                                  if (!empty($donnees['PLA_SEED'])) {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . '] '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                            <?php
                                  } else {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                            <?php
                                  }
                                }
  	                        ?>
  	                        </select><br />

  	                        <?php
                            $param = "disp";
  	                        $listPlayersTournament = getAllPlayersTournament($param);
  	                        ?>
  	                        Demi-finaliste 4 : <select name="Semi4" id="Semi4" required="required"/>
  	                        <option value="<?php echo $updateSemi4; ?>"><?php echo $updateSemi4; ?></option>
  	                        <?php
  	                            while ($donnees = $listPlayersTournament->fetch())
  	                            {
                                  if (!empty($donnees['PLA_SEED'])) {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . '] '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') [' . $donnees['PLA_SEED'] . ']'; ?></option>
                            <?php
                                  } else {
                            ?>
                                <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ') '; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                            <?php
                                  }
                                }
  	                        ?>
  	                        </select><br />
  	                    </p>
  	                    <p>
  	                        <input type="submit" value="Valider" />
                            <input type="button" value="Annuler" onclick="window.location.href='pagePerso.php'">
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
                      Meilleur joueur français : <select name="BestFrench" id="BestFrench" required="required"/><br />
                      <option value="<?php echo $updateBestFrench; ?>"><?php echo $updateBestFrench; ?></option>
                      <?php
                          while ($donnees = $listFrenchTournament->fetch())
                          {
                      ?>
                          <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
                      <?php
                          }
                      ?>
                      </select>

                      </p>
                      <p>
                          <input type="submit" value="Valider" />
                          <input type="button" value="Annuler" onclick="window.location.href='pagePerso.php'">
                      </p>
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
	                    Niveau du meilleur français : <select type="text" name="LevelFrench" label="LevelFrench" required="required"/><br />

	                    <option value="<?php echo $updateBestFrenchLevel; ?>"><?php echo $updateBestFrenchLevel; ?></option>

	                    <?php
	                    while ($donnees = $listLevel->fetch()) {
	                    ?>
	                       	<option value="<?php echo $donnees['SET_LVL_LIBELLE']; ?>"><?php echo $donnees['SET_LVL_LIBELLE']; ?></option>
	                    <?php
	                       	}
	                    ?>
	                    </select>

	                    </p>
	                    <p>
	                        <input type="submit" value="Valider" />
                          <input type="button" value="Annuler" onclick="window.location.href='pagePerso.php'">
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
    		 	echo '<br /><h2>Pronostiques des matchs</h2>';

          //****************************************************************************
          // debut copy formulairePronostiqueUnitaireCible.php
          //****************************************************************************
          if (isset($_POST['TypeMatch'])
          and isset($_POST['VouD'])
          and isset($_POST['ScoreJ1'])
          and isset($_POST['ScoreJ2']))
          {

              $typeMatch = $_POST['TypeMatch'];
              $result = $_POST['VouD'];
              $scoreJ1 = $_POST['ScoreJ1'];
              $scoreJ2 = $_POST['ScoreJ2'];

              // echo "Before conversion ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

              //if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
              // if ($_POST['VouD']=="" OR $_POST['ScoreJ1']=="" OR $_POST['ScoreJ2']=="")
              if ($result=="" OR $scoreJ1=="" OR $scoreJ2=="")
              {
                echo "Tous les champs doivent être remplis. Vous avez saisit : <br />";
                echo "Resultat=" . $result . ", Score=" . $scoreJ1 . "/" . $scoreJ2 . "<br />";
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
                  echo "<br />";
                  echo "<span class='warning'>Retour au formulaire de saisie: </span>";
                  ?>
                  <input type="button" value="OK" onclick="history.go(-1)">
                  <?php
                }


                if ($nbRow > 0)
                {
                  // echo 'Bravo ! Pronostique fait !<br />';

                  // if ($_POST['VouD'] == 'V') {
                  if ($result == 'V') {
                    switch ($typeMatch) {
                      case 'AB':
                        echo '<span class=info>Tu as pronostiqué : Victoire de </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> contre </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> par abandon : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player2']) . '</span><br />';
                        break;

                      case 'WO':
                        echo '<span class=info>Tu as pronostiqué : Victoire de </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> contre </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> par forfait. </span><br />';
                        break;

                      default:
                        echo '<span class=info>Tu as pronostiqué : Victoire de </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> contre </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . '</span><br />';
                        break;
                     }
                   }
                   else {
                    switch ($typeMatch) {
                      case 'AB':
                        echo '<span class=info>Tu as pronostiqué : Victoire de </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> contre </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> par abandon : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player1']) . '</span><br />';
                        break;

                      case 'WO':
                        echo '<span class=info>Tu as pronostiqué : Victoire de </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> contre </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> par forfait. </span><br />';
                        break;

                      default:
                        echo '<span class=info>Tu as pronostiqué : Victoire de </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> contre </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . '</span><br />';
                        break;
                    }
                  }

                  echo '<span class=info>Vous pouvez toujours modifier ce pronostique avant le début du match </span>';
                  // echo '<br />Pour faire un nouveau pronostique, clique <a href="pronostique_matchs.php">' . 'ICI' . '</a><br/>';
                  // echo '<br /><a href="pronostique_matchs.php" class="button">' . 'Nouveau pronostique' . '</a><br/>';
                  ?>
                  <input type="button" value="OK" onclick="window.location.href='pagePerso.php'"><br />
                  <?php

                } else {
                  // echo "<br />Update n'a rien fait";
                }
              }
            }
          //****************************************************************************
          // fin copy formulairePronostiqueUnitaireCible.php
          //****************************************************************************

            ?>
                <table>
                    <tr>
                        <!--<th width="100" align="center" valign="middle" class="cellule">Id Match</th> -->
                        <th colspan="5" align="center" valign="middle" class="cellule">OFFICIEL</th>
                        <th colspan="2" align="center" valign="middle" class="cellule">VOTRE PRONOSTIQUE</th>
                    </tr>
                    <tr>
                        <!--<th width="100" align="center" valign="middle" class="cellule">Id Match</th> -->
                        <th width="150" align="center" valign="middle" class="cellule">Tour</th>
                        <th width="150" align="center" valign="middle" class="cellule">Date</th>
                        <th width="200" align="center" valign="middle" class="cellule">Joueur 1</th>
                        <th width="100" align="center" valign="middle" class="cellule">Resultat</th>
                        <th width="200" align="center" valign="middle" class="cellule">Joueur 2</th>
                        <!-- <th width="100" align="center" valign="middle" class="cellule">Pronostique Type Match</th> -->
                        <!-- <th width="50" align="center" valign="middle" class="cellule">OFFICIEL Type Match</th> -->
                        <th width="100" align="center" valign="middle" class="cellule">Résultat</th>
                        <th width="80" align="center" valign="middle" class="cellule">Nb pts</th>
                    </tr>

                <?php

                $yourPrognosis = getYourPrognosis();

                $ResMatchPoidsTourPrecedent = "";
                $colorLine = "";

                //while ($donnees = $reponse->fetch()) {
                while ($donnees = $yourPrognosis->fetch()) {

                    $matchAModifier = $donnees['RES_MATCH_ID'];

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
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH'] . " " . $donnees['RES_MATCH_SCR_JOU1'] . "/" . $donnees['RES_MATCH_SCR_JOU2'] . " " . $donnees['RES_MATCH_TYP']; ?></td>
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
                        <!-- <td align="center" valign="middle" class="cellule"><?php //echo $donnees['PRO_TYP_MATCH']; ?></td> -->
                        <!-- <td align="center" valign="middle" class="cellule"><?php //echo $donnees['RES_MATCH_TYP']; ?></td> -->
                        <td align="center" valign="middle" class="cellule"><?php echo $donnees['PRO_RES_MATCH'] . " " . $donnees['PRO_SCORE_JOU1'] . "/" . $donnees['PRO_SCORE_JOU2'] . " " . $donnees['PRO_TYP_MATCH']; ?></td>
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

                        $GLOBALS['pageOrigine'] = 'pagePerso';
                        // echo "Origine = " . $pageOrigine . "<br />";
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
