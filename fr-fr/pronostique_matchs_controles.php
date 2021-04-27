<?php
//include("connexionSGBD.php");
include("../commun/model.php");

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
  echo "Retour au formulaire de saisie de pronostique: " . '<a href="pronostique.php">Cliquer ici</a>';
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

  //Chargement des scores en table MySQL des pronostiques
  $nbRow = 0;

  if ($pronoOK == 'OK') {

    // $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch);
    $req = updatePrognosis($session_jou_id, $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch);

    $nbRow = $req->rowcount();
  }
  else {
    echo "<span class='warning'>Merci de ré-essayer " . '<a href="pronostique_matchs.php">ICI</a>' . ". Si l'erreur persiste, veuillez contacter l'admninistrateur du site.</span><br />";
  }


  if ($nbRow > 0)
  {
    echo 'Bravo ! Pronostique fait !<br />';

    // if ($_POST['VouD'] == 'V') {
    if ($result == 'V') {
      switch ($typeMatch) {
        case 'AB':
          echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' par abandon *** ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player2']) . '<br />';
          break;

        case 'WO':
          echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' par forfait. <br />';
          break;

        default:
          echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player1']) . ' contre ' . htmlspecialchars($_POST['Player2']) . ' : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . '<br />';
          break;
       }
     }
     else {
      switch ($typeMatch) {
        case 'AB':
          echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' par abandon *** ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player1']) . '<br />';
          break;

        case 'WO':
          echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' par forfait. <br />';
          break;

        default:
          echo 'Tu as pronostiqué : Victoire de ' . htmlspecialchars($_POST['Player2']) . ' contre ' . htmlspecialchars($_POST['Player1']) . ' : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . '<br />';
          break;
      }
    }

    echo '<br />Vous pouvez modifier ce pronostique dans la section <a href="pagePerso.php">' . 'Page perso' . '</a><br/>';
    echo '<br />Pour faire un nouveau pronostique, clique <a href="pronostique_matchs.php">' . 'ICI' . '</a><br/>';


  } else {
    // echo "<br />Update n'a rien fait";
  }
}

?>
