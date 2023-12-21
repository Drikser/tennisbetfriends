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
}
$scoreJ1 = $_POST['ScoreJ1'];
$scoreJ2 = $_POST['ScoreJ2'];

if (isset($_POST['Joker'])) {
  $joker = $_POST['Joker'];
} else {
  $joker = " ";
}

// echo "Before conversion ==> Result=" . $result . " (" . $scoreJ1 . "/" . $scoreJ2 . ") - type de match: " . $typeMatch . ". <br />";

//if (empty($_POST['VouD']) OR empty($_POST['ScoreJ1']) OR empty($_POST['ScoreJ2']))
// if ($_POST['VouD']=="" OR $_POST['ScoreJ1']=="" OR $_POST['ScoreJ2']=="")
if ($result=="" OR ($scoreJ1=="0" and $scoreJ2=="0" and $typeMatch==""))
{
 echo "<span class='warning'>Tous les champs doivent être remplis. Vous avez saisit : </span><br />";
 if ($typeMatch !== "") {
   echo "<span class='warning'>Resultat=" . $result . ", Score=" . $scoreJ1 . "/" . $scoreJ2 . " (" . $typeMatch . ")</span><br />";
 } else {
   echo "<span class='warning'>Resultat=" . $result . ", Score=" . $scoreJ1 . "/" . $scoreJ2 . "</span><br />";
 }
 // echo "<span class='warning'>Retour au formulaire de saisie de pronostique: </span>" . '<a href="pronostique.php">Cliquer ici</a>';
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

   echo "updatePrognosis(" . $_SESSION['JOU_ID'] . ", " . $_POST['idMatch'] . ", " . $result . ", " . $scoreJ1 . ", " . $scoreJ2 . ", " . $typeMatch . ", " . $doublePoints . ") <br />";
   // $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch);
   $req = updatePrognosis($_SESSION['JOU_ID'], $_POST['idMatch'], $result, $scoreJ1, $scoreJ2, $typeMatch, $doublePoints);

   $nbRow = $req->rowcount();
 }
 else {

   echo "<span class='warning'>Votre pronostique: " . $result . " " . $scoreJ1 . "/" . $scoreJ2 . "</span><br />";
   echo "<span class='warning'>Retour au formulaire de saisie: </span>";
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
     switch ($typeMatch) {
       case 'AB':
         echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> par abandon : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player2']) . '</span><br />';
         break;

       case 'WO':
         echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> par forfait. </span><br />';
         break;

       default:
         echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . '</span><br />';
         break;
      }
    }
    else {
     switch ($typeMatch) {
       case 'AB':
         echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> par abandon : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . ' avant l\'abandon de ' . htmlspecialchars($_POST['Player1']) . '</span><br />';
         break;

       case 'WO':
         echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> par forfait. </span><br />';
         break;

       default:
         echo '<span class=info>Tu as pronostiqué : Victoire de </span><b>' . htmlspecialchars($_POST['Player2']) . '</b><span class=info> contre </span><b>' . htmlspecialchars($_POST['Player1']) . '</b><span class=info> : ' . htmlspecialchars($scoreJ1) . ' sets à ' . htmlspecialchars($scoreJ2) . '</span><br />';
         break;
     }
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
