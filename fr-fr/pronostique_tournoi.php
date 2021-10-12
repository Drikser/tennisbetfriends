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
	                echo "<br /><h1>Pronostiques Bonus</h1>";

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
                  echo "Vous devez faire vos pronostiques sur le tournoi <span class=warning>avant le début du tournoi</span>, le <span class=warning>lundi " . substr($startDateTournament,0,10) . "</span> à <span class=warning>" . substr($startDateTournament,11,8) . "</span> (heure de " . $cityTournament . ").<br /><br />";

                  echo "<span class=congrats>INFO:</span> Vous devez valider vos choix catégorie par catégorie.<br /><br />";

                  //*****************************************************************
                  //**      Contrôle si il y a eu des des pronostiques saisis      **
                  //*****************************************************************

                  //* --- vainqueur ---
                  if (isset($_POST['Winner'])) {
                      $req = updateWinner($_SESSION['JOU_ID']);

                      $nbRow = $req->rowcount();
                      if ($nbRow > 0) {
                        echo '<script>window.location.href("pronostique_tournoi.php")</script>';
                        echo "<span class=info>Tu as choisi comme vainqueur du tournoi : </span><b>" . $_POST['Winner'] . "</b><br />";
                        echo "<span class=info>Tant que le tournoi n'est pas encore commencé, tu peux encore modifier ton pronostique dans la section <a href='pagePerso.php'>" . "Page perso" . "</a> </span>";
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
                          echo "<span class=info>Tu as choisi comme finalistes du tournoi : </span><b>" . $_POST['Final1'] . "</b><span class=info> et </span><b>" . $_POST['Final2'] . "</b><br />";
                          echo "<span class=info>Tant que le tournoi n'est pas encore commencé, tu peux encore modifier ton pronostique dans la section <a href='pagePerso.php'>" . "Page perso" . "</a> </span>";
                          //echo "Tu ne peux maintenant plus modifier ton choix.<br />";
                          ?>
                          <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'"><br />
                          <?php
                      }
                    } else {
                      echo "<span class=warning>Les deux finalistes doivent êtres différents, merci de corriger ton choix.</span>";
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
                          echo "<span class=info>Tu as choisi comme demi-finalistes du tournoi : </span><b>" . $_POST['Semi1'] . "</b><span class=info>, </span><b>" . $_POST['Semi2'] . "</b><span class=info>, </span><b>" . $_POST['Semi3'] . "</b><span class=info> et </span><b>" . $_POST['Semi4'] . "</b><br />";
                          echo "<span class=info>Tant que le tournoi n'est pas encore commencé, tu peux encore modifier ton pronostique dans la section <a href='pagePerso.php'>" . "Page perso" . "</a> </span>";
                          ?>
                          <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'"><br />
                          <?php
                      }
                    } else {
                      echo "<span class=warning>Tous les demi-finalistes doivent êtres différents, merci de corriger ton choix.</span>";
                      ?>
                      <input type="button" value="OK" onclick="window.location.href='pronostique_tournoi.php'">
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
                  // or  $bonusPrognosis['PROB_FR_NOM'] == ''
                  // or  $bonusPrognosis['PROB_FR_NIV'] == ''
                  )
                  {

                    // --- VAINQUEUR ---
                    if ($bonusPrognosis['PROB_VQR'] == '') {
    	                echo "<h2>Vainqueur du tournoi</h2>";

    	                //echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_VQR=" . $bonusPrognosis['PROB_VQR'] . "<br />";

    	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

    	                	// echo "Choisissez un vainqueur puis validez.<br />";
                        echo "Qui va remporter cette édition ?<br />";


    	                    ?>
                          <fieldset>
    	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">
    	                    <p>
    	                    <!--    Vainqueur du tournoi : <input type="text" name="Winner" label="Winner" required="required"/><br />-->

    	                    <?php
                          $param = "disp";
    	                    $listPlayersTournament = getAllPlayersTournament($param);
    	                    ?>
    	                    Vainqueur du tournoi : <select name="Winner" id="Winner" required="required"/><br />

    	                    <option value="">--- faites votre choix ---</option>
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

                          <span data-html="true" info-text="NOTE:
                          [1], [2], ... = Tête de série numéro 1, 2, ...
                          [WC] = Wild Card (joueur invité par le tournoi)
                          [Q] = Qualifié (joueur entré dans le tableau principal grâce aux qualifications)
                          [LL] = Lucky Loser (joueur de plus haut classement ne s'étant pas qualifié directement mais entré dans le tableau principal suite à un retrait)"
                          class='tooltip'> info</span>

    	                    </p>
    	                    <p>
    	                        <input type="submit" value="Valider" />
    	                    </p>

                          </fieldset>
    	                    </form>
    	                    <?php

    	                }
    	                else {
    	                    echo "<span class=info>Le tournoi a commencé, tu ne peux malheureusement plus saisir ton choix</span><br />";
    	                }
                    }

  	                //* --- FINALISTES ---
                    if ($bonusPrognosis['PROB_FINAL1'] == '' AND $bonusPrognosis['PROB_FINAL2'] == '') {

                      echo "<h2>Les finalistes</h2>";

    	                //echo "playerId=" . $_SESSION['JOU_ID'] . " FINAL1=" . $bonusPrognosis['PROB_FINAL1'] . " PROB_FINAL2=" . $bonusPrognosis['PROB_FINAL2'] . "<br />";

    	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

                        echo "Qui selon vous seront les finalistes cette année ?<br />";

    	                    ?>
                          <fieldset>
    	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">
    	                    <p>
    	                        <?php
                              // Recupérer les pronostiques bonus du joueur. La list des joueurs affichés ne doit pas contenir
                              // un joueur présent dans une autre case pour éviter les doublons (les deux finalistes doivent être
                              // différents, ainsi que les 4 demi-finalistes)
                              // $listPronoBonusJoueur = getPronostique_Bonus($_SESSION['JOU_ID']);
                              // while ($donnees = $listPronoBonusJoueur->fetch()) {
                              //   $finalist1_inDB = $donnees['PROB_FINAL1'];
                              //   $finalist2_inDB = $donnees['PROB_FINAL2'];
                              // }

                              $param = "disp";
    	                        $listPlayersTournament = getAllPlayersTournament($param);
    	                        ?>
    	                        Finaliste 1 : <select name="Final1" id="Final1" required="required"/>
    	                        <option value="">--- faites votre choix ---</option>
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

                              <span data-html="true" info-text="NOTE:
                              [1], [2], ... = Tête de série numéro 1, 2, ...
                              [WC] = Wild Card (joueur invité par le tournoi)
                              [Q] = Qualifié (joueur entré dans le tableau principal grâce aux qualifications)
                              [LL] = Lucky Loser (joueur de plus haut classement ne s'étant pas qualifié directement mais entré dans le tableau principal suite à un retrait)"
                              class='tooltip'> info</span>

                              <br />

    	                        <?php
                              $param = "disp";
    	                        $listPlayersTournament = getAllPlayersTournament($param);
    	                        ?>
    	                        Finaliste 2 : <select name="Final2" id="Final2" required="required"/>
    	                        <option value="">---faites votre choix ---</option>
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
    	                    </p>

                          </fieldset>
    	                    </form>
    	                    <?php

    	                }
    	                else {
                        echo "<span class=info>Le tournoi a commencé, tu ne peux malheureusement plus saisir ton choix</span><br />";
    	                }
                    }

  	                //* --- DEMI-FINALISTES ---
                    if ($bonusPrognosis['PROB_DEMI1'] == '' AND $bonusPrognosis['PROB_DEMI2'] == '' AND $bonusPrognosis['PROB_DEMI3'] == '' AND $bonusPrognosis['PROB_DEMI4'] == '') {

    	                echo "<h2>Les demi-finalistes</h2>";

    	                //echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_DEMI1=" . $bonusPrognosis['PROB_DEMI1'] . " PROB_DEMI2=" . $bonusPrognosis['PROB_DEMI2'] . " PROB_DEMI3=" . $bonusPrognosis['PROB_DEMI3'] . " PROB_DEMI4=" . $bonusPrognosis['PROB_DEMI4'] . "<br />";

    	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

    	                	echo "Quels seront selon vous les 4 demi-finaliste de cette édition ?<br />";

    	                    ?>
                          <fieldset>
    	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">
    	                    <p>
    	                        <?php
                              $param = "disp";
    	                        $listPlayersTournament = getAllPlayersTournament($param);
    	                        ?>
    	                        Demi-finaliste 1 : <select name="Semi1" id="Semi1" required="required"/>
    	                        <option value="">--- faites votre choix ---</option>
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

                              <span data-html="true" info-text="NOTE:
                              [1], [2], ... = Tête de série numéro 1, 2, ...
                              [WC] = Wild Card (joueur invité par le tournoi)
                              [Q] = Qualifié (joueur entré dans le tableau principal grâce aux qualifications)
                              [LL] = Lucky Loser (joueur de plus haut classement ne s'étant pas qualifié directement mais entré dans le tableau principal suite à un retrait)"
                              class='tooltip'> info</span>

                              <br />

    	                        <?php
                              $param = "disp";
    	                        $listPlayersTournament = getAllPlayersTournament($param);
    	                        ?>
    	                        Demi-finaliste 2 : <select name="Semi2" id="Semi2" required="required"/>
    	                        <option value="">--- faites votre choix ---</option>
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
    	                        <option value="">--- faites votre choix ---</option>
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
    	                        <option value="">--- faites votre choix ---</option>
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
    	                    </p>

                          </fieldset>
    	                    </form>
    	                    <?php
    	                }
    	                else {
                          echo "<span class=info>Le tournoi a commencé, tu ne peux malheureusement plus saisir ton choix</span><br />";
    	                }
                    }

  	                //---------------------------------------------------------------------------
  	                // 03/03/2019: FONCTIONNALITE MEILLEUR FRANCAIS ET NIVEAU ATTEINT EN SUSPEND
  	                //---------------------------------------------------------------------------

    	            } else {
                    echo "<br />";
                    echo "<span class='congrats'>Vous êtes à jour dans vos pronostiques bonus.<br /></span><br />";
                    if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {
                      echo "Vous pouvez toutefois les modifier si vous le souhaitez dans la section <a href='pagePerso.php'>Page Perso</a><br />";
                    }
                  }
                }

  	            else {

  	                echo "Pour pronostiquer, vous devez vous connecter à votre compte : <br />";

  	                // Affichage du formulaire de connexion
  	                // include("formulaireConnexion.php");

  	                echo "Pas encore inscrit ? Faites partie de la communauté en cliquant <a href='formulaireInscription.php'>ICI</a><br />";
  	            }
	      		?>

	        </div>
        </div>

    </div>

    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
