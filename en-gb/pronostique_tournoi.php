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

	            $startDateTournament;

	            if (isset($_SESSION['JOU_ID']) AND isset($_SESSION['JOU_PSE'])) {
	                //$reponse = $bdd->query('SELECT * FROM résultats WHERE RES_MATCH_DAT = CURDATE()');
	                //$reponse = $bdd->query('SELECT * FROM resultats WHERE RES_MATCH_DAT = CURDATE() AND RES_MATCH = ""');

	                //*************************************************************************************************************
	                //*                                      PRONOSTIQUE GENERAUX SUR LE TOURNOI
	                //*************************************************************************************************************
	                echo "<br /><h1>Bonus predictions</h1>";

	                setlocale(LC_TIME, "fr_FR", "French");
                  //---
	                //echo "Nous sommes le " . strftime('%A %d %B %Y, il est %H:%M:%S') . "<br />";
                  //---
					        //echo "Nous sommes le " . (date('l jS \of F Y\, \i\l \e\s\t H:i:s')) . "<br /><br />";

	                $tournament= getTournament();
	                while ($donnees = $tournament->fetch())
					        {
						         $startDateTournament = $donnees['SET_DAT_START'];
                     $cityTournament = $donnees['SET_TOURNAMENT'];
					        }

                  if ($cityTournament == 'Paris') {
                    echo "You must make your bonus tournament predictions <span class=warning>before the start of the tournament</span>, on <span class=warning>Sunday " . substr($startDateTournament,0,10) . "</span> at <span class=warning>" . substr($startDateTournament,11,8) . "</span> (" . $cityTournament . " time)<br /><br />";
                    echo "<span class=congrats>INFO:</span> You must validate your choices category by category.<br /><br />";
                  } else {
                    echo "You must make your bonus tournament predictions <span class=warning>before the start of the tournament</span>, on <span class=warning>Monday " . substr($startDateTournament,0,10) . "</span> at <span class=warning>" . substr($startDateTournament,11,8) . "</span> (" . $cityTournament . " time)<br /><br />";
                    echo "<span class=congrats>INFO:</span> You must validate your choices category by category.<br /><br />";
                  }

                  //*****************************************************************
                  //**      Contrôle si il y a eu des des pronostiques saisis      **
                  //*****************************************************************

                  //* --- vainqueur ---
                  if (isset($_POST['Winner'])) {
                      $req = updateWinner($_SESSION['JOU_ID']);

                      $nbRow = $req->rowcount();
                      if ($nbRow > 0) {
                        echo '<script>window.location.href("pronostique_tournoi.php")</script>';
                        echo "<span class=info>As tournament winner you have chosen: </span><b>" . $_POST['Winner'] . "</b><br />";
                        echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction in your <a href='pagePerso.php'>" . "Personal page " . "</a> </span>";
                          //echo "Tu ne peux maintenant plus modifier ton choix.<br />";
                        ?>
                        <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'"><br />
                        <?php
                      }
                  }

                  //* --- finalistes ---
                  if (isset($_POST['Final1']) and isset($_POST['Final2'])) {

                    if ($_POST['Final1'] != $_POST['Final2']) {

                      $req = updateFinal($_SESSION['JOU_ID']);

                      $nbRow = $req->rowcount();

                      if ($nbRow > 0) {
                        echo '<script>window.location.href("pronostique_tournoi.php")</script>';
                          echo "<span class=info>You have chosen as tournament finalists: </span><b>" . $_POST['Final1'] . "</b><span class=info> and </span><b>" . $_POST['Final2'] . "</b><br />";
                          echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction in your <a href='pagePerso.php'>" . "Personal page " . "</a> </span>";
                          //echo "Tu ne peux maintenant plus modifier ton choix.<br />";
                          ?>
                          <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'"><br />
                          <?php
                      }
                    } else {
                      echo "<span class=warning>Both finalists must be differents, please change your prediction </span>";
                      ?>
                      <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'">
                      <?php
                    }
                  }

                  //* --- demi-finalistes ---
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
                        echo '<script>window.location.href("pronostique_tournoi.php")</script>';
                          echo "<span class=info>You have chosen as tournament semi-finalists: </span><b>" . $_POST['Semi1'] . "</b><span class=info>, </span><b>" . $_POST['Semi2'] . "</b><span class=info>, </span><b>" . $_POST['Semi3'] . "</b><span class=info> and </span><b>" . $_POST['Semi4'] . "</b><br />";
                          echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction in your <a href='pagePerso.php'>" . "Personal page " . "</a> </span>";
                          ?>
                          <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'"><br />
                          <?php
                      }
                    } else {
                      echo "<span class=warning>All the semi-finalists must be differents, please change your prediction.</span>";
                      ?>
                      <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'">
                      <?php
                    }
                  }

                  //* --- meilleur français ---
                  if (isset($_POST['BestFrench'])) {
                      $req = updateBestFrench($_SESSION['JOU_ID']);

                      $nbRow = $req->rowcount();
                      if ($nbRow > 0) {
                          echo "<span class=info>You choose as the best Frenchman: </span>" . $_POST['BestFrench'] . "<br />";
                          echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction in your <a href='pagePerso.php'>" . "Personal page " . "</a> </span>";
                          ?>
                          <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'"><br />
                          <?php
                      }
                  }

                  //* --- niveau du meilleur français ---
                  if (isset($_POST['LevelFrench'])) {
                      $req = updateLevelFrench($_SESSION['JOU_ID']);

                      $nbRow = $req->rowcount();

                      if ($nbRow > 0) {
                          $outputRoundE = ConvertRoundFTE($_POST['LevelFrench']);
                          echo "<span class=info>You think the best round reached by the best Frenchman will be: </span>" . $outputRoundE . "<br />";
                          echo "<span class=info>As long as the tournament has not yet started, you can still change your prediction in your <a href='pagePerso.php'>" . "Personal page " . "</a> </span>";
                          ?>
                          <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'"><br />
                          <?php
                      }
                  }



                  //*******************************************************************
                  //**      Contrôle si il y a encore des pronostiques à saisir      **
                  //*******************************************************************

	                $bonusPrognosis = getBonusPrognosis($_SESSION['JOU_ID']);

                  if ($bonusPrognosis['PROB_VQR'] == ''
                  or  $bonusPrognosis['PROB_FINAL1'] == ''
                  or  $bonusPrognosis['PROB_FINAL2'] == ''
                  or  $bonusPrognosis['PROB_DEMI1'] == ''
                  or  $bonusPrognosis['PROB_DEMI2'] == ''
                  or  $bonusPrognosis['PROB_DEMI3'] == ''
                  or  $bonusPrognosis['PROB_DEMI4'] == ''
                  or  $bonusPrognosis['PROB_FR_NOM'] == ''
                  or  $bonusPrognosis['PROB_FR_NIV'] == ''
                  )
                  {

  	                //**************************************** VAINQUEUR *****************************************
                    if ($bonusPrognosis['PROB_VQR'] == '') {

                      echo "<h2>The winner</h2>";
                    ?>
    	                 <!-- <h2>The winner <img src="../images/Question-mark-resized-2.jpg" alt="Question Mark" /></h2> -->
                    <?php
    	                //echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_VQR=" . $bonusPrognosis['PROB_VQR'] . "<br />";

    	                //if ($bonusPrognosis['PROB_VQR'] == '') {
    	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

    	                	echo "Who will win this edition?<br />";

    	                    ?>
                          <fieldset>
    	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">
    	                    <p>
    	                    <!--    Vainqueur du tournoi : <input type="text" name="Winner" label="Winner" required="required"/><br />-->

    	                    <?php
                          $param = "disp";
    	                    $listPlayersTournament = getAllPlayersTournament($param);
    	                    ?>
    	                    Tournament winner : <select name="Winner" id="Winner" required="required"/><br />

    	                    <option value="">--- make your choice ---</option>
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

                          <p>
                            <span class="info">NOTE : Shortlist of 8 players before the draw, but you will be able to choose among all players after the draw (the Thursday before the tournament starts)</span><br />
                          </p>

    	                    </p>
    	                    <p>
    	                        <input type="submit" value="Confirm" />
    	                    </p>

                          </fieldset>
    	                    </form>
    	                    <?php

    	                }
    	                else {
    	                    echo "<span class=info>The tournament has started, you can no longer enter your prediction.</span><br />";
    	                }
                    }

  	                //**************************************** FINALISTES *****************************************
                    if ($bonusPrognosis['PROB_FINAL1'] == '' AND $bonusPrognosis['PROB_FINAL2'] == '') {

    	                echo "<h2>The finalists</h2>";

    	                //echo "playerId=" . $_SESSION['JOU_ID'] . " FINAL1=" . $bonusPrognosis['PROB_FINAL1'] . " PROB_FINAL2=" . $bonusPrognosis['PROB_FINAL2'] . "<br />";

    	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

    	                	echo "Please choose the finalists, then confirm.<br />";

    	                    ?>
                          <fieldset>
    	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">
    	                    <p>
    	                        <?php
                              $param = "disp";
    	                        $listPlayersTournament = getAllPlayersTournament($param);
    	                        ?>
    	                        Finalist 1 : <select name="Final1" id="Final1" required="required"/>
    	                        <option value="">--- make your choice ---</option>
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
    	                        <option value="">--- make your choice ---</option>
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

                              <p>
                                <span class="info">NOTE : Shortlist of 8 players before the draw, but you will be able to choose among all players after the draw (the Thursday before the tournament starts)</span><br />
                              </p>

    	                    </p>
    	                    <p>
    	                        <input type="submit" value="Confirm" />
    	                    </p>

                          </fieldset>
    	                    </form>
    	                    <?php

    	                }
    	                else {
    	                    echo "<span class=info>The tournament has started, you can no longer enter your prediction.</span><br />";
    	                }
                    }


  	                //**************************************** DEMI-FINALISTES *****************************************
                    if ($bonusPrognosis['PROB_DEMI1'] == '' AND $bonusPrognosis['PROB_DEMI2'] == '' AND $bonusPrognosis['PROB_DEMI3'] == '' AND $bonusPrognosis['PROB_DEMI4'] == '') {

    	                echo "<h2>The semi-finalists</h2>";

    	                //echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_DEMI1=" . $bonusPrognosis['PROB_DEMI1'] . " PROB_DEMI2=" . $bonusPrognosis['PROB_DEMI2'] . " PROB_DEMI3=" . $bonusPrognosis['PROB_DEMI3'] . " PROB_DEMI4=" . $bonusPrognosis['PROB_DEMI4'] . "<br />";

    	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

    	                	echo "Please choose the semi-finalists, then confirm.<br />";

    	                    ?>
                          <fieldset>
    	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">
    	                    <p>
    	                        <?php
                              $param = "disp";
    	                        $listPlayersTournament = getAllPlayersTournament($param);
    	                        ?>
    	                        Semi-finalist 1 : <select name="Semi1" id="Semi1" required="required"/>
    	                        <option value="">--- make your choice ---</option>
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
    	                        <option value="">--- make your choice ---</option>
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
    	                        <option value="">--- make your choice ---</option>
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
    	                        <option value="">--- make your choice ---</option>
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

                              <p>
                                <span class="info">NOTE : Shortlist of 8 players before the draw, but you will be able to choose among all players after the draw (the Thursday before the tournament starts)</span><br />
                              </p>

    	                    </p>
    	                    <p>
    	                        <input type="submit" value="Confirm" />
    	                    </p>

                          </fieldset>
    	                    </form>
    	                    <?php

    	                }
    	                else {
    	                    echo "<span class=info>The tournament has started, you can no longer enter your prediction.</span><br />";
    	                }
                    }

  	                //---------------------------------------------------------------------------
  	                //03/03/2019: FONCTIONNALITE MEILLEUR FRANCAIS ET NIVEAU ATTEINT EN SUSPEND
                    // 19/11/2021: Reinstate best french functionality
  	                //---------------------------------------------------------------------------

  	                //**************************************** MEILLEUR FRANCAIS *****************************************
                    if ($bonusPrognosis['PROB_FR_NOM'] == '') {

    	                echo "<h2>Best Frenchman</h2>";

    	                // echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_FR_NOM=" . $bonusPrognosis['PROB_FR_NOM'] . "<br />";

    	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

                          echo "Who do you think will be the best Frenchman in this tournament?<br />";

    	                    ?>
                          <fieldset>
    	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">

    	                    <?php
    	                    $listFrenchTournament = getAllFrenchTournament();
    	                    ?>

                          <p>
    	                    Best Frenchman : <select name="BestFrench" id="BestFrench" required="required"/><br />
    	                    <option value="---">--- make your choice ---</option>
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
                          <p>
                            <span class="info">NOTE : You can enter this bonus after the draw (the Thursday before the tournament starts)</span><br />
                          </p>

    	                    </p>
    	                    <p>
    	                        <input type="submit" value="Confirm" />
    	                    </p>
                          </fieldset>
    	                    </form>
    	                    <?php

    	                }
    	                else {
    	                    // echo "<span class=info>Tu as choisi comme meilleur français du tournoi : </span>" . $bonusPrognosis['PROB_FR_NOM'] . "<br />";
    	                    // echo "<span class=info>Tant que le tournoi n'est pas encore commencé, tu peux encore changer tes pronostiques dans la section 'Page Perso'</span><br />";
                          echo "<span class=info>The tournament has started, you can no longer enter your prediction.</span><br />";
    	                }
                    }

  	                //**************************************** NIVEAU MEILLEUR FRANCAIS *****************************************
                    if ($bonusPrognosis['PROB_FR_NIV'] == '') {

    	                echo "<h2>Round reached by the best Frenchman</h2>";

    	                // echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_FR_NIV=" . $bonusPrognosis['PROB_FR_NIV'] . "<br />";

                      if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {
    	                // if ($bonusPrognosis['PROB_FR_NIV'] == '') {

                          echo "... and what will be his best result?<br />";

    	                    ?>
                          <fieldset>
    	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">

    	                    <?php
    	                    $listLevel = getAllLevel();
    	                    ?>

    	                    <p>
    	                    Niveau du meilleur français : <select type="text" name="LevelFrench" label="LevelFrench" required="required"/><br />

    	                    <option value="---">--- make your choice ---</option>

    	                    <?php
    	                    while ($donnees = $listLevel->fetch()) {
                              $outputRoundE = ConvertRoundFTE($donnees['SET_LVL_LIBELLE']);
    	                    ?>
    	                       	<option value="<?php echo $donnees['SET_LVL_LIBELLE']; ?>"><?php echo $outputRoundE; ?></option>
    	                    <?php
    	                       	}
    	                    ?>
    	                    </select>

    	                    </p>
    	                    <p>
    	                        <input type="submit" value="Confirm" />
    	                    </p>
                          </fieldset>
    	                    </form>
    	                    <?php

    	                }
    	                else {
                          echo "<span class=info>The tournament has started, you can no longer enter your prediction.</span><br />";
    	                }
                    }

                  } else {
                    echo "<br />";
                    echo "<span class='congrats'>You are up to date with your predictions.<br /></span><br />";
                    if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {
                      echo "However, you can still change them in the <a href='pagePerso.php'>Personal Page</a> section <br />";
                    }
                  }
              }
	            else {

	                echo "To make a prediction, you must sign in. <br />";

	                // Affichage du formulaire de connexion
	                // include("formulaireConnexion.php");

	                echo "Not registered yet? Please register <a href='formulaireInscription.php'>HERE</a><br />";
	            }
	      		?>

	        </div>
        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
