<?php
// Les contrôles sont différents selon le tour du Tournoi
// - Deux 1er tours, pas de score (juste choix du vainqueur)
// - A partir du 3ème tour, scores
// - A partir des 1/8ème de finale, introduction du joker pour doubles ses Points

if (isset($_POST['TypeMatch'])
and isset($_POST['VouD'])
and isset($_POST['ScoreJ1'])
and isset($_POST['ScoreJ2']))
{

  // echo "ID match=" . $_POST['idMatch'] . " - poids tour=" . $_POST['Poids'] . " - " . $_POST['Player1'] . " c. " . $_POST['Player2'] . "<br />";
  // echo "VouD=" . $_POST['VouD'] . " - " . $_POST['ScoreJ1'] . "/" . $_POST['ScoreJ2'] . "(" . $_POST['TypeMatch'] . ")<br />";

  switch ($_POST['Poids']) {
    case 64:
    case 32:
      // Sur les 2 premiers tours, on ne teste que le résultat (V ou D)
      include ("controleSaisie_First2Rounds.php");
      break;

    case 16:
      // 3ème tour, controles normaux
      include ("controleSaisie_WithoutJoker.php");
      break;

    default:
      // A partir des huitièmes, on ajoute le joker
      include ("controleSaisie_WithJoker.php");

      // Compter le nombre de jokers utilisés / restants
      $Nb_joker = getNbJoker();
      $donnees = $Nb_joker->fetch();
      $Nb_remaining_joker = 3 - $donnees['nbJoker'];
      echo 'Nb remaining wildcard(s) (&#9733) = ' . $Nb_remaining_joker . '<br /><br />';
      break;
  }
}
//****************************************************************************
// fin copy formulairePronostiqueUnitaireCible.php
//****************************************************************************
