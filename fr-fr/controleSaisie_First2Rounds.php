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

 if ($result=="")
 {
   echo "<span class='warning'>Vous devez choisir un vainqueur</span>";
   ?>
   <input type="button" value="OK" onclick="history.go(-1)">
   <?php
 }
 else
 {
   //Contrôles avant chargement :
   $pronoOK = 'OK';

   // echo "After conversion  ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

   if ($result !== "V" and $result !== "D") {
     echo "<span class='warning'>Mauvaise valeur pour le résultat: " . $result . " (Doit être 'V' ou 'D')</span><br />";
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

     echo "<span class='warning'>Votre pronostique: " . $result . "</span><br />";
     echo "<span class='warning'>Refaire la saisie: </span>";
     ?>
     <input type="button" value="OK" onclick="history.go(-1)">
     <?php

     echo "<br />";
     // echo "<span class='warning'>Merci de ré-essayer " . '<a href="pronostique_matchs.php">ICI</a>' . ". Si l'erreur persiste, veuillez contacter l'admninistrateur du site.</span><br />";
   }


   if ($nbRow > 0)
   {
     // echo 'Bravo ! Pronostique fait !<br />';

     // if ($_POST['VouD'] == 'V') {
     if ($result == 'V') {
       echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><br />';
     }
    else {
       echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><br />';
     }

     if ($pageOrigine == 'pronostique_matchs') {
       echo '<span class=info>Vous pouvez modifier ce pronostique dans la section <a href="pagePerso.php">' . 'Vos pronostiques' . '</a> </span>';
       ?>
       <input type="button" value="OK" onclick="window.location.href='pronostique_matchs.php'"><br />
       <?php
     } else {
       echo '<span class=info>Vous pouvez toujours modifier ce pronostique avant le début du match </span>';
       ?>
       <input type="button" value="OK" onclick="window.location.href='pagePerso.php'"><br />
       <?php
     }

   } else {
     // echo "<br />Update n'a rien fait";
   }
 }
 //****************************************************************************
 // fin copy formulairePronostiqueUnitaireCible.php
 //****************************************************************************
