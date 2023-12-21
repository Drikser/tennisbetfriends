<?php
// 06/07/2020: ajout cible ici pour essayer d'afficher le message sur la même page
// include ("formulairePronostiqueUnitaireCible.php");
//****************************************************************************
// debut copy formulairePronostiqueUnitaireCible.php
//****************************************************************************

$typeMatch = $_POST['TypeMatch'];
if (isset($_POST['VouD'])) {
  // echo "VouD reçu = " . $_POST['VouD'] . "<br />";
  $result = $_POST['VouD'];
} else {
  // echo "VouD pas reçu - initialisé à blanc<br />";
  $result = "";
}
$scoreJ1 = $_POST['ScoreJ1'];
$scoreJ2 = $_POST['ScoreJ2'];

// echo "Before conversion ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

if ($result=="" )
{
  echo "<span class='warning'>You must choose a winner</span><br />";
  ?>
  <input type="button" value="OK" onclick="history.go(-1)">
  <?php
}
else
{
  // convert result from english to french for process, if english version
  // W --> V
  // L --> D
  if ($result == 'W' or $result == 'L') {
    $outputResultF = ConvertResultETF($result);
    $result = $outputResultF;
  }

  //Contrôles avant chargement :
  $pronoOK = 'OK';

  // echo "After conversion  ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

  if ($result !== "V" and $result !== "D") {
    echo "<span class='warning'>Wrong value for result: " . $result . " (Must be either 'W' ou 'L')</span><br />";
    $pronoOK = 'KO';
  }

  //Chargement des scores en table MySQL des pronostiques
  $nbRow = 0;

  if ($pronoOK == 'OK') {

    // Correction Type Match to avoid "Data too long for column 'PRO_TYP_MATCH'"
    if ($typeMatch !== "") {
      $typeMatch = "";
      //echo 'Type Match initialized<br />';
    }

    // Last argument = joker = 1 for the first 2 rounds
    $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch, 1);

    $nbRow = $req->rowcount();
  }
  else {

    echo "<span class='warning'>Your prediction: " . $result . "</span><br />";
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
      echo '<span class=info>Your prediction: </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> defeated </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><br />';
    } else {
      echo '<span class=info>Your prediction: </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> defeated </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><br />';
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
