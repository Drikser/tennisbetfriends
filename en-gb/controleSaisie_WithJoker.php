<?php
// 06/07/2020: ajout cible ici pour essayer d'afficher le message sur la même page
// include ("formulairePronostiqueUnitaireCible.php");
//****************************************************************************
// debut copy formulairePronostiqueUnitaireCible.php
//****************************************************************************

echo "Display from ControleSaisieWithJoker.php:";
echo "ID match=" . $_POST['idMatch'] . " - poids tour=" . $_POST['Poids'] . " - " . $_POST['Player1'] . " c. " . $_POST['Player2'] . "<br />";
echo "VouD=" . $_POST['VouD'] . " - " . $_POST['ScoreJ1'] . "/" . $_POST['ScoreJ2'] . "(" . $_POST['TypeMatch'] . ")<br />";

$typeMatch = $_POST['TypeMatch'];
if (isset($_POST['VouD'])) {
  // echo "VouD reçu = " . $_POST['VouD'] . "<br />";
  $result = $_POST['VouD'];
} else {
  // echo "VouD pas reçu - initialisé à blanc<br />";
  $result = "";
}$scoreJ1 = $_POST['ScoreJ1'];
$scoreJ2 = $_POST['ScoreJ2'];

if (isset($_POST['Joker'])) {
$joker = $_POST['Joker'];
} else {
$joker = " ";
}

// echo "Before conversion ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

//if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
// if ($_POST['VouD']=="" OR $_POST['ScoreJ1']=="" OR $_POST['ScoreJ2']=="")
// if ($result=="" OR $scoreJ1=="" OR $scoreJ2=="")
if ($result=="" OR ($scoreJ1=="0" and $scoreJ2=="0" and $typeMatch==""))
{
  echo "<span class='warning'>You must fill out all the fields. You entered: </span><br />";
  if ($typeMatch !== "") {
    echo "<span class='warning'>Result=" . $result . ", Score=" . $scoreJ1 . "/" . $scoreJ2 . " (" . $typeMatch . ")</span><br />";
  } else {
    echo "<span class='warning'>Result=" . $result . ", Score=" . $scoreJ1 . "/" . $scoreJ2 . "</span><br />";
  }
  echo "<span class='warning'>Go back to the form: </span>";
  ?>
  <input type="button" value="OK" onclick="history.go(-1)">
  <?php
}
else
{
//echo "Le match saisit est le match n°" . $_POST['idMatch'] . '<br />'; //idMAtch est la valeur du champs caché du formulaire de saisie de score
// echo "The player ID is " . $_SESSION['JOU_ID'] . '<br />';

// convert match type from english to french for process, if english version
// RET --> AB
if ($typeMatch == 'RET') {
ConvertTypeResultETF($typeMatch);
$typeMatch = $outputTypeResult;
}

// convert result from english to french for process, if english version
// W --> V
// L --> D
if ($result == 'W' or $result == 'L') {
$outputResultF = ConvertResultETF($result);
$result = $outputResultF;
}

// $joker = $_POST['Joker'];
// echo "Joker=" . $joker;
// if ($joker == "yes") {
echo "Joker = " . $_POST['Joker'] . "<br />";
// if ($_POST['Joker'] == "yes") {
if ($joker == "on") {
  $doublePoints = 2;
} else {
  $doublePoints = 1;
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
  // $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch);
  $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch, $doublePoints);

  $nbRow = $req->rowcount();
}
else {

  echo "<span class='warning'>Your prediction: " . $result . " " . $scoreJ1 . "/" . $scoreJ2 . "</span><br />";
  if ($doublePoints == 2) {
    echo "<span class='warning'>!!! You have played a wildcard !!!</span>";
  }
  echo "<br />";
  echo "<span class='warning'>Go back to the form: </span>";
  ?>
  <input type="button" value="OK" onclick="history.go(-1)">
  <?php

  echo "<br />";

}


if ($nbRow > 0)
{
// echo 'Congrats! Prediction done!<br />';

// if ($_POST['VouD'] == 'V') {
if ($result == 'V') {
  switch ($typeMatch) {
    case 'AB':
      echo '<span class=info>Your prediction: </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> defeated </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> by withdrawal: ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . ' before </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> withdrawal. </span><br />';
      break;

    case 'WO':
      echo '<span class=info>Your prediction: </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> defeated </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> by W.O. </span><br />';
      break;

    default:
      echo '<span class=info>Your prediction: </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> defeated </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> : ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . '</span><br />';
      break;
   }
 }
 else {
  switch ($typeMatch) {
    case 'AB':
      echo '<span class=info>Your prediction: </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> defeated </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> by withdrawal: ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . ' before </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> withdrawal. </span><br />';
      break;

    case 'WO':
      echo '<span class=info>Your prediction: </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> defeated </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> by W.O. </span><br />';
      break;

    default:
      echo '<span class=info>Your prediction: </span>' . htmlspecialchars($_POST['Player2']) . '<span class=info> defeated </span>' . htmlspecialchars($_POST['Player1']) . '<span class=info> : ' . htmlspecialchars($scoreJ1) . ' sets to ' . htmlspecialchars($scoreJ2) . '</span><br />';
      break;
   }
  }

  if ($pageOrigine == 'pronostique_matchs') {
    echo '<span class=info>You can still change your prediction in the <a href="pagePerso.php">' . 'Your predictions' . ' section</a> </span>';
    ?>
    <input type="button" value="OK" onclick="window.location.href='pronostique_matchs.php'"><br />
    <?php
  } else {
    echo '<span class=info>You can still change your prediction before the match begins </span>';
    ?>
    <input type="button" value="OK" onclick="window.location.href='pagePerso.php'"><br />
    <?php
  }


  } else {
    // echo "<br />Update did nothing";
  }
}
//****************************************************************************
// fin copy formulairePronostiqueUnitaireCible.php
//****************************************************************************
