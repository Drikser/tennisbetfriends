<?php
// *********************************************************
// *  Page pour saisie de plusieurs matchs d'un seul coup  *
// *  ==> Un formulaire par match saisit                   *
// *********************************************************
if ($_SESSION['JOU_PSE'] == "Admin") {
  // echo "Formulaire - pageOrigine = " . $pageOrigine . "<br />";
  if ($pageOrigine == 'gestionMatchs_correction') {
  ?>
    <form action="formulaireSaisieResultatCible2.php" method="post" enctype="multipart/form-data">
  <?php
  } else {
    ?>
    <form action="formulaireSaisieResultatCible2.php" method="post" enctype="multipart/form-data">
    <?php
  }
}
else {
  // echo "Formulaire - pageOrigine = " . $pageOrigine . "<br />";
  if ($pageOrigine == 'pronostique_matchs') {
  ?>
    <form action="pronostique_matchs.php" method="post" enctype="multipart/form-data">
  <?php
  } else {
    ?>
    <form action="pagePerso.php" method="post" enctype="multipart/form-data">
    <?php
  }
}

include ("formulairePronostiqueMatchASaisir2_table.php");
?>
</form>
