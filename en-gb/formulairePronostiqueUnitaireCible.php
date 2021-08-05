<?php
session_start(); // On démarre la session AVANT toute chose
?>

 <!--
*************************************
*  De mise à jour d'un pronostique  *
*  ==> Un seul match pronostiqué    *
*************************************
-->

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

	    <div id="corps">
	        <h1>Pronostiques des matchs</h1>

	        <!-- <p>
	            Validation du pronostique<br />
	        </p> -->

			<!-- Connexion base de données -->

			<?php
			//include("connexionSGBD.php");
			//include("../commun/model.php");


      $typeMatch = $_POST['TypeMatch'];
      $result = $_POST['VouD'];
      $scoreJ1 = $_POST['ScoreJ1'];
      $scoreJ2 = $_POST['ScoreJ2'];

      // echo "Before conversion ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

      //if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
			// if ($_POST['VouD']=="" OR $_POST['ScoreJ1']=="" OR $_POST['ScoreJ2']=="")
      if ($result=="" OR $scoreJ1=="" OR $scoreJ2=="")
			{
				echo "You must fill out all the fields. Tou entered: <br />";
        echo "Result=" . $result . ", Score=" . $scoreJ1 . "/" . $scoreJ2 . "<br />";
				echo "Go back to the form: " . '<a href="pronostique.php">Cliquer ici</a>';
			}
			else
			{
				//echo "Le match saisit est le match n°" . $_POST['idMatch'] . '<br />'; //idMAtch est la valeur du champs caché du formulaire de saisie de score
				// echo "The player ID is " . $_SESSION['JOU_ID'] . '<br />';

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
		               echo "<span class='warning'>Wrong score: If a player won 2 sets he can't retire.</span><br />";
		               $pronoOK = 'KO';
               }
	          } else {
            	if ($scoreJ1 == 3 OR $scoreJ2 == 3) {
          		//echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 3 sets !!! Type Tournoi = " . $_POST['TypeTournoi'] . "</span><br />";
	         		  echo "<span class='warning'>Wrong score: If a player won 3 sets he can't retire.</span><br />";
	           	  $pronoOK = 'KO';
	           	}
	          }

            if ($_POST['TypeTournoi'] != 'GC') {

              if ($scoreJ1 == 2) {
  							echo "<span class='warning'>Warning : the loser can't retire if the opponent already won 2 sets.</span><br />";
  							$pronoOK = 'KO';
              }

            } else {
              if ($scoreJ1 == 3) {
  							echo "<span class='warning'>Warning : the loser can't retire if the opponent already won 3 sets.</span><br />";
  							$pronoOK = 'KO';
              }
            }


						break;

					case 'WO':
						if ($scoreJ1 != 0 OR $scoreJ2 != 0) {
							echo "<span class='warning'>Warning : in the event of a walk over, score must be 0-0</span><br />";
							$pronoOK = 'KO';
						}

						break;

					default:
	                    if ($scoreJ1 == 0) {
	                        echo "<span class='warning'>Wrong score: the winner can't win with 0 set</span><br />";
	                        $pronoOK = 'KO';
	                    }

	                    if ($_POST['TypeTournoi'] != 'GC') {

	                    	//echo "type de tournoi différent de GC : <" . $_POST['TypeTournoi'] . "><br />";

		                    if ($scoreJ1 != 2) {
		                        //echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 2 sets !!! Type Tournoi <" . $_POST['TypeTournoi'] . "></span><br />";
		                        echo "<span class='warning'>Wrong score: the winner has to win 2 sets</span><br />";
		                        $pronoOK = 'KO';
		                    }
	                    }
	                    else {

	                    	if ($scoreJ1 != 3) {
	                    		//echo "<span class='warning'>!!! Mauvais score renseigné : Le vainqueur doit gagner 3 sets !!! Type Tournoi = " . $_POST['TypeTournoi'] . "</span><br />";
	                    		echo "<span class='warning'>Wrong score: the winner has to win 3 sets</span><br />";
	                        	$pronoOK = 'KO';
	                    	}
	                    }

	                    if ($scoreJ2 >= $scoreJ1) {
	                        echo "<span class='warning'>Wrong score: winner's number of sets must be greater than loser's number of sets</span><br />";
	                        $pronoOK = 'KO';
	                    }

						break;
				}

				//Chargement des scores en table MySQL des pronostiques
				$nbRow = 0;

				if ($pronoOK == 'OK') {

					// $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch']);
          $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch);

					$nbRow = $req->rowcount();
				}
				else {
					echo "<span class='warning'>Please try again " . '<a href="pronostique_matchs.php">HERE</a>' . ". If the error persists, please contact the webadmin.</span><br />";
				}


				if ($nbRow > 0)
				{
					// echo 'Congrats! Prediction done!<br />';

					// if ($_POST['VouD'] == 'V') {
          if ($result == 'V') {
					 	switch ($typeMatch) {
					 	 	case 'AB':
					 	 		echo '<span class="congrats">Your prediction: ' . htmlspecialchars($_POST['Player1']) . ' defeated ' . htmlspecialchars($_POST['Player2']) . ' by withdrawal *** ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . ' before ' . htmlspecialchars($_POST['Player2']) . ' withdrawal. </span><br />';
					 	 		break;

					 	 	case 'WO':
				 	 			echo '<span class="congrats">Your prediction: ' . htmlspecialchars($_POST['Player1']) . ' defeated ' . htmlspecialchars($_POST['Player2']) . ' by W.O. </span><br />';
				 	 			break;

					 	 	default:
				 	 			echo '<span class="congrats">Your prediction: ' . htmlspecialchars($_POST['Player1']) . ' defeated ' . htmlspecialchars($_POST['Player2']) . ' : ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . '</span><br />';
				 	 			break;
					 	 }
					 }
					 else {
					 	switch ($typeMatch) {
					 	 	case 'AB':
					 	 		echo '<span class="congrats">Your prediction: ' . htmlspecialchars($_POST['Player2']) . ' defeated ' . htmlspecialchars($_POST['Player1']) . ' by withdrawal *** ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . ' before ' . htmlspecialchars($_POST['Player1']) . ' withdrawal. </span><br />';
					 	 		break;

					 	 	case 'WO':
					 	 		echo '<span class="congrats">Your prediction: ' . htmlspecialchars($_POST['Player2']) . ' defeated ' . htmlspecialchars($_POST['Player1']) . ' by W.O. </span><br />';
					 	 		break;

					 	 	default:
					 	 		echo '<span class="congrats">Your prediction: ' . htmlspecialchars($_POST['Player2']) . ' defeated ' . htmlspecialchars($_POST['Player1']) . ' : ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . '</span><br />';
					 	 		break;
					 	}
					}

					echo '<br />You can change your prediction in your <a href="pagePerso.php">' . 'Personal page ' . '</a><br/>';
					// echo '<br />To make a new prediction, click <a href="pronostique_matchs.php">' . 'HERE' . '</a><br/>';
          echo '<br /><a href="pronostique_matchs.php" class="button">' . 'New prediction' . '</a><br/>';


				} else {
          // echo "<br />Update did nothing";
        }
			}

			?>


	    </div>

    </div>


    <!-- Le pied de page -->

    <?php include("../commun/piedDePAge.php"); ?>

    </body>
</html>
