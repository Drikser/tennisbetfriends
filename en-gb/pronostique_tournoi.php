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
					        }

					        echo "You must make your bonus tournament predictions before the start of the tournament, on " . substr($startDateTournament,0,10) . " at " . substr($startDateTournament,11,8) . "<br /><br />";
                  // echo "You must make your bonus tournament predictions before the start of the tournament, on " . $startDateTournament . "<br /><br />";

					        echo "INFO: you must validate your choices category by category.<br />";


	                $bonusPrognosis = getBonusPrognosis($_SESSION['JOU_ID']);

	                //**************************************** VAINQUEUR *****************************************
	                echo "<h2>The winner</h2>";

	                //echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_VQR=" . $bonusPrognosis['PROB_VQR'] . "<br />";

	                //if ($bonusPrognosis['PROB_VQR'] == '') {
	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

	                	echo "Please choose the tournament winner, then confirm.<br />";

	                    ?>
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
	                    ?>
	                        <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
	                    <?php
	                        }
	                    ?>
	                    </select>

	                    </p>
	                    <p>
	                        <input type="submit" value="Confirm" />
	                    </p>
	                    </form>
	                    <?php

	                    if (isset($_POST['Winner'])) {
	                        $req = updateWinner($_SESSION['JOU_ID']);

	                        $nbRow = $req->rowcount();
	                        if ($nbRow > 0) {
	                        	echo '<script>window.location.href("pronostique_tournoi.php")</script>';
	                        	echo "As tournament winner you have chosen: " . $_POST['Winner'] . "<br />";
                            echo "As long as the tournament has not yet started, you can still change your prediction.<br />";
	                            //echo "Tu ne peux maintenant plus modifier ton choix.<br />";
	                        }
	                    }
	                }
	                else {
	                    echo "As tournament winner you have chosen: " . $bonusPrognosis['PROB_VQR'] . "<br />";
	                    //echo "Tant que le tournoi n'est pas encore commencé, tu peux encore changer ton pronostique dans la section 'Page Perso'<br />";
	                    echo "You can no longer change your choice.<br />";
	                }

	                //**************************************** FINALISTES *****************************************
	                echo "<h2>The finalists</h2>";

	                //echo "playerId=" . $_SESSION['JOU_ID'] . " FINAL1=" . $bonusPrognosis['PROB_FINAL1'] . " PROB_FINAL2=" . $bonusPrognosis['PROB_FINAL2'] . "<br />";

	                //if ($bonusPrognosis['PROB_FINAL1'] == '' AND $bonusPrognosis['PROB_FINAL2'] == '') {
	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

	                	echo "Please choose the finalists, then confirm.<br />";

	                    ?>
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
	                        ?>
	                            <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
	                        <?php
	                            }
	                        ?>
	                        </select><br />


	                        <?php
                          $param = "disp";
	                        $listPlayersTournament = getAllPlayersTournament($param);
	                        ?>
	                        Finalist 2 : <select name="Final2" id="Final2" required="required"/>
	                        <option value="">--- make your choice ---</option>
	                        <?php
	                            while ($donnees = $listPlayersTournament->fetch())
	                            {
	                        ?>
	                            <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
	                        <?php
	                            }
	                        ?>
	                        </select><br />

	                    </p>
	                    <p>
	                        <input type="submit" value="Confirm" />
	                    </p>
	                    </form>
	                    <?php

	                    if (isset($_POST['Final1'])) {
	                        $req = updateFinal($_SESSION['JOU_ID']);

	                        $nbRow = $req->rowcount();

	                        if ($nbRow > 0) {
	                        	echo '<script>window.location.href("pronostique_tournoi.php")</script>';
	                            echo "You have chosen as tournament finalists: " . $_POST['Final1'] . " and " . $_POST['Final2'] . "<br />";
	                            echo "As long as the tournament has not yet started, you can still change your prediction.<br />";
	                            //echo "Tu ne peux maintenant plus modifier ton choix.<br />";
	                        }
	                    }
	                }
	                else {
	                    echo "You have chosen as tournament finalists: <br />";
	                    echo "- " . $bonusPrognosis['PROB_FINAL1'] . "<br />";
	                    echo "- " . $bonusPrognosis['PROB_FINAL2'] . "<br />";
	                    //echo "Tant que le tournoi n'est pas encore commencé, tu peux encore changer tes pronostiques dans la section 'Page Perso'<br />";
	                    echo "You can no longer change your choice.<br />";
	                }


	                //**************************************** DEMI-FINALISTES *****************************************
	                echo "<h2>The semi-finalists</h2>";

	                //echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_DEMI1=" . $bonusPrognosis['PROB_DEMI1'] . " PROB_DEMI2=" . $bonusPrognosis['PROB_DEMI2'] . " PROB_DEMI3=" . $bonusPrognosis['PROB_DEMI3'] . " PROB_DEMI4=" . $bonusPrognosis['PROB_DEMI4'] . "<br />";

	                //if ($bonusPrognosis['PROB_DEMI1'] == '' AND $bonusPrognosis['PROB_DEMI2'] == '' AND $bonusPrognosis['PROB_DEMI3'] == '' AND $bonusPrognosis['PROB_DEMI4'] == '') {
	                if (strtotime(date('Y-m-d G:H:s')) < strtotime($startDateTournament)) {

	                	echo "Please choose the semi-finalists, then confirm.<br />";

	                    ?>
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
	                        ?>
	                            <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
	                        <?php
	                            }
	                        ?>
	                        </select><br />


	                        <?php
                          $param = "disp";
	                        $listPlayersTournament = getAllPlayersTournament($param);
	                        ?>
	                        Semi-finalist 2 : <select name="Semi2" id="Semi2" required="required"/>
	                        <option value="">--- make your choice ---</option>
	                        <?php
	                            while ($donnees = $listPlayersTournament->fetch())
	                            {
	                        ?>
	                            <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
	                        <?php
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
	                        ?>
	                            <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
	                        <?php
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
	                        ?>
	                            <option value="<?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?>"><?php echo $donnees['PLA_NOM'] . ' (' . $donnees['PLA_PAY'] . ')'; ?></option>
	                        <?php
	                            }
	                        ?>
	                        </select><br />
	                    </p>
	                    <p>
	                        <input type="submit" value="Confirm" />
	                    </p>
	                    </form>
	                    <?php

	                    if (isset($_POST['Semi1'])) {
	                        $req = updateSemi($_SESSION['JOU_ID']);

	                        $nbRow = $req->rowcount();

	                        if ($nbRow > 0) {
	                        	echo '<script>window.location.href("pronostique_tournoi.php")</script>';
	                            echo "You have chosen as tournament semi-finalists: " . $_POST['Semi1'] . ", " . $_POST['Semi2'] . ", " . $_POST['Semi3'] . " and " . $_POST['Semi4'] . "<br />";
	                            echo "As long as the tournament has not yet started, you can still change your prediction.<br />";
	                            //echo "Tu ne peux maintenant plus modifier ton choix.<br />";
	                        }
	                    }
	                }
	                else {
	                    echo "You have chosen as tournament semi-finalists: <br />";
	                    echo "- " . $bonusPrognosis['PROB_DEMI1'] . "<br />";
	                    echo "- " . $bonusPrognosis['PROB_DEMI2'] . "<br />";
	                    echo "- " . $bonusPrognosis['PROB_DEMI3'] . "<br />";
	                    echo "- " . $bonusPrognosis['PROB_DEMI4'] . "<br />";
	                    //echo "Tant que le tournoi n'est pas encore commencé, tu peux encore changer tes pronostiques dans la section 'Page Perso'<br />";
	                    echo "You can no longer change your choice.<br />";
	                }

	                //---------------------------------------------------------------------------
	                // 03/03/2019: FONCTIONNALITE MEILLEUR FRANCAIS ET NIVEAU ATTEINT EN SUSPEND
	                //---------------------------------------------------------------------------

	                /*
   	                // DEBUT DU COMMENTAGE

	                //**************************************** MEILLEUR FRANCAIS *****************************************
	                echo "<h2>Le meilleur français</h2><br />";

	                echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_FR_NOM=" . $bonusPrognosis['PROB_FR_NOM'] . "<br />";

	                if ($bonusPrognosis['PROB_FR_NOM'] == '') {
	                    ?>
	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">

	                    <?php
	                    $listFrenchTournament = getAllFrenchTournament();
	                    ?>

	                    Meilleur joueur français : <select name="BestFrench" id="BestFrench" required="required"/><br />
	                    <option value="---">--- make your choice ---</option>
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
	                    </p>
	                    </form>
	                    <?php

	                    if (isset($_POST['BestFrench'])) {
	                        $req = updateBestFrench($_SESSION['JOU_ID']);

	                        $nbRow = $req->rowcount();
	                        if ($nbRow > 0) {
	                            echo "Tu as choisi comme meilleur français : " . $_POST['BestFrench'] . "<br />";
	                            echo "Tant que le tournoi n'est pas encore commencé, tu peux encore changer ton pronostique dans la section 'Page Perso'<br />";
	                        }
	                    }
	                }
	                else {
	                    echo "Tu as choisi comme meilleur français du tournoi : " . $bonusPrognosis['PROB_FR_NOM'] . "<br />";
	                    echo "Tant que le tournoi n'est pas encore commencé, tu peux encore changer tes pronostiques dans la section 'Page Perso'<br />";
	                }


	                //**************************************** NIVEAU MEILLEUR FRANCAIS *****************************************

	                echo "<h2>Niveau du meilleur français</h2><br />";

	                echo "playerId=" . $_SESSION['JOU_ID'] . " PROB_FR_NIV=" . $bonusPrognosis['PROB_FR_NIV'] . "<br />";

	                if ($bonusPrognosis['PROB_FR_NIV'] == '') {
	                    ?>
	                    <form action="pronostique_tournoi.php" method="post" enctype="multipart/form-data">

	                    <?php
	                    $listLevel = getAllLevel();
	                    ?>

	                    <p>
	                    Niveau du meilleur français : <select type="text" name="LevelFrench" label="LevelFrench" required="required"/><br />

	                    <option value="---">--- make your choice ---</option>

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
	                    </p>
	                    </form>
	                    <?php

	                    if (isset($_POST['LevelFrench'])) {
	                        $req = updateLevelFrench($_SESSION['JOU_ID']);

	                        $nbRow = $req->rowcount();

	                        if ($nbRow > 0) {
	                            echo "Tu penses que le meilleur français du tournoi sera : " . $_POST['LevelFrench'] . "<br />";
	                            echo "Tant que le tournoi n'est pas encore commencé, tu peux encore changer tes pronostiques dans la section 'Page Perso'<br />";
	                        }
	                    }
	                }
	                else {
	                    echo "Tu penses que le meilleur français du tournoi sera : " . $bonusPrognosis['PROB_FR_NIV'] . "<br />";
	                    echo "Tant que le tournoi n'est pas encore commencé, tu peux encore changer tes pronostiques dans la section 'Page Perso'<br />";
	                }

	                // FIN DU COMMENTAGE
	                */

	            }
	            else {

	                ech/ "Pour pronostiquer, vous devez vous connecter à votre compte : <br />";

	                // Affichage du formulaire de connexion
	                include("formulaireConnexion.php");

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
