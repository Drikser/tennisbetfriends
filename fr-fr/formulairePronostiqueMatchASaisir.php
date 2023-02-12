<?php
    // *********************************************************
    // *  Page pour saisie de plusieurs matchs d'un seul coup  *
    // *  ==> Un formulaire par match saisit                   *
    // *********************************************************


    // $Player1 = htmlentities($donnees['RES_MATCH_JOU1']);
    // $Player2 = htmlentities($donnees['RES_MATCH_JOU2']);
    // $DateMatch = $donnees['RES_MATCH_DAT'];

    // echo "date match from database=" . $donnees['RES_MATCH_DAT'] . "<br />";
    // echo "date match from variable=" . $DateMatch . "<br />";
    // echo "date avec htmlspecialchars=" . htmlspecialchars($DateMatch) . "<br />";

//Redirection du formulaire selon si on fait une saisie de résultat (Admin) ou un pronostique (Autre)

  if ($_SESSION['JOU_PSE'] == "Admin") {
    // echo "Formulaire - pageOrigine = " . $pageOrigine . "<br />";
    if ($pageOrigine == 'gestionMatchs_correction') {
    ?>
    <!-- <form action="formulairePronostiqueUnitaireCible.php" method="post" enctype="multipart/form-data"> -->
      <form action="formulaireSaisieResultatCible.php" method="post" enctype="multipart/form-data">
    <?php
    } else {
      ?>
      <form action="formulaireSaisieResultatCible.php" method="post" enctype="multipart/form-data">
      <?php
    }
  }
  else {
    // echo "Formulaire - pageOrigine = " . $pageOrigine . "<br />";
    if ($pageOrigine == 'pronostique_matchs') {
    ?>
    <!-- <form action="formulairePronostiqueUnitaireCible.php" method="post" enctype="multipart/form-data"> -->
      <form action="pronostique_matchs.php" method="post" enctype="multipart/form-data">
    <?php
    } else {
      ?>
      <form action="pagePerso.php" method="post" enctype="multipart/form-data">
      <?php
    }
  }
?>

<!-- <form action= <?php $cibleFormulaire; ?> method="post" enctype="multipart/form-data"> -->
<!-- <form action="formulairePronostiqueUnitaireCible.php" method="post" enctype="multipart/form-data"> -->
<table>
    <tr>
<!--        <th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>   -->
<!-- Rows to display for the form -->
        <th width="150" align="center" valign="middle" class="cellule">Date du match</th>
        <th width="150" align="center" valign="middle" class="cellule">Niveau</th>
        <th width="150" align="center" valign="middle" class="cellule">Joueur 1</th>
        <th width="50" align="center" valign="middle" class="cellule">Choisir vainqueur</th>
        <th width="150" align="center" valign="middle" class="cellule">Joueur 2</th>
        <th width="150" align="center" valign="middle" class="cellule">Score Vainqueur (nb sets)</th>
        <th width="150" align="center" valign="middle" class="cellule">Score Perdant (nb sets)</th>
        <th width="100" align="center" valign="middle" class="cellule">Type Match</th>
        <th width="100" align="center" valign="middle" class="cellule">Doubler tes points ?</th>
<!-- Rows to not display, but which still need to send through the form -->
        <th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Date du match (à transmettre)</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Tournoi</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Categorie</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Poids</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Sequence</th>
    </tr>

    <tr>
        <!-- <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="idMatch" class="form-control" id="idMatch" value= <?php echo $idMatch; ?> required="required"></td>   -->
        <!-- <td align="center" valign="middle" class="cellule" type="text" name="DateMatch" class="form-control" id="DateMatch" required="required"><?php echo $donnees['RES_MATCH_DAT']; ?></td> -->
        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
        <!-- <td align="center" valign="middle" class="cellule"><?php echo $DateMatch; ?></td> -->
        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
        <!-- <td align="center" valign="middle" width="31" ><select class="form-control" name="VouD" id="VouD" required="required"> -->
        <td align="center" valign="middle" class="cellule">
          <?php
          if ($_SESSION['JOU_PSE'] == 'Admin') {
            switch ($donnees['RES_MATCH']) {
              case 'V':
                ?>
                <!-- <input type="radio" id="V" name="VouD" value="V" checked><label for="V"></label>
                <input type="radio" id="D" name="VouD" value="D"><label for="D"></label> -->
                <input type="radio" id="V" name="VouD" value="V" checked>
                <input type="radio" id="D" name="VouD" value="D">
                <?php
                break;

              case 'D':
                ?>
                <!-- <input type="radio" id="V" name="VouD" value="V"><label for="V"></label>
                <input type="radio" id="D" name="VouD" value="D" checked><label for="D"></label> -->
                <input type="radio" id="V" name="VouD" value="V">
                <input type="radio" id="D" name="VouD" value="D" checked>
                <?php
                break;

              default:
              ?>
                <!-- <input type="radio" id="V" name="VouD" value="V"><label for="V"></label>
                <input type="radio" id="D" name="VouD" value="D"><label for="D"></label> -->
                <input type="radio" id="V" name="VouD" value="V">
                <input type="radio" id="D" name="VouD" value="D">
                <?php
                break;
            }
          }
          else {
            switch ($donnees['PRO_RES_MATCH']) {
              case 'V':
                ?>
                <!-- <input type="radio" id="V" name="VouD" value="V" checked><label for="V"></label>
                <input type="radio" id="D" name="VouD" value="D"><label for="D"></label> -->
                <input type="radio" id="V" name="VouD" value="V" checked>
                <input type="radio" id="D" name="VouD" value="D">
                <?php
                break;

              case 'D':
                ?>
                <!-- <input type="radio" id="V" name="VouD" value="V"><label for="V"></label>
                <input type="radio" id="D" name="VouD" value="D" checked><label for="D"></label> -->
                <input type="radio" id="V" name="VouD" value="V">
                <input type="radio" id="D" name="VouD" value="D" checked>
                <?php
                break;

              default:
              ?>
                <!-- <input type="radio" id="V" name="VouD" value="V"><label for="V"></label>
                <input type="radio" id="D" name="VouD" value="D"><label for="D"></label> -->
                <input type="radio" id="V" name="VouD" value="V">
                <input type="radio" id="D" name="VouD" value="D">
                <?php
                break;
            }
          }
          ?>
        </select></td>
        <td align="center" valign="middle"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
        <td align="center" valign="middle"><select class="form-control" name="ScoreJ1" id="ScoreJ1" required="required">
          <?php
          if ($donnees['RES_TYP_TOURNOI'] == 'GC') {
            if ($_SESSION['JOU_PSE'] == 'Admin') {

              switch ($donnees['RES_MATCH_SCR_JOU1']) {
                case '0':
                ?>
                  <option value="0" selected>0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '1':
                ?>
                  <option value="0">0</option>
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '2':
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2" selected>2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '3':
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3" selected>3</option>
                  <?php
                  break;

                default:
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3" selected>3</option>
                  <?php
                  break;
              }
            }
            else {
              switch ($donnees['PRO_SCORE_JOU1']) {
                case '0':
                ?>
                  <option value="0" selected>0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '1':
                ?>
                  <option value="0">0</option>
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '2':
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2" selected>2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '3':
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3" selected>3</option>
                  <?php
                  break;

                default:
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3" selected>3</option>
                  <?php
                  break;
              }
            }
          }
          else {
            if ($_SESSION['JOU_PSE'] == 'Admin') {

              switch ($donnees['RES_MATCH_SCR_JOU1']) {
                case '0':
                ?>
                  <option value="0" selected>0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <?php
                  break;

                case '1':
                ?>
                  <option value="0">0</option>
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <?php
                  break;

                case '2':
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2" selected>2</option>
                  <?php
                  break;

                default:
                  break;
              }
            }
            else {
              switch ($donnees['PRO_SCORE_JOU1']) {
              case '0':
              ?>
                <option value="0" selected>0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <?php
                break;

              case '1':
              ?>
                <option value="0">0</option>
                <option value="1" selected>1</option>
                <option value="2">2</option>
                <?php
                break;

              case '2':
              ?>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2" selected>2</option>
                <?php
                break;

              default:
                break;
              }
            }
          }
          ?>
        </select></td>
        <td align="center" valign="middle"><select class="form-control" name="ScoreJ2" id="ScoreJ2" required="required">
          <?php
          if ($donnees['RES_TYP_TOURNOI'] == 'GC') {
            if ($_SESSION['JOU_PSE'] == 'Admin') {

              switch ($donnees['RES_MATCH_SCR_JOU2']) {
                case '0':
                ?>
                  <option value="0" selected>0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '1':
                ?>
                  <option value="0">0</option>
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '2':
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2" selected>2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '3':
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3" selected>3</option>
                  <?php
                  break;

                default:
                  break;
              }
            }
            else {
              switch ($donnees['PRO_SCORE_JOU2']) {
                case '0':
                ?>
                  <option value="0" selected>0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '1':
                ?>
                  <option value="0">0</option>
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '2':
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2" selected>2</option>
                  <option value="3">3</option>
                  <?php
                  break;

                case '3':
                ?>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3" selected>3</option>
                  <?php
                  break;

                default:
                  break;
              }
            }
          }
          else {
            if ($_SESSION['JOU_PSE'] == 'Admin') {
              switch ($donnees['RES_MATCH_SCR_JOU2']) {
              case '0':
              ?>
                <option value="0" selected>0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <?php
                break;

              case '1':
              ?>
                <option value="0">0</option>
                <option value="1" selected>1</option>
                <option value="2">2</option>
                <?php
                break;

              case '2':
              ?>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2" selected>2</option>
                <?php
                break;

              default:
                break;
              }
            }
            else {
              switch ($donnees['PRO_SCORE_JOU2']) {
              case '0':
              ?>
                <option value="0" selected>0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <?php
                break;

              case '1':
              ?>
                <option value="0">0</option>
                <option value="1" selected>1</option>
                <option value="2">2</option>
                <?php
                break;

              case '2':
              ?>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2" selected>2</option>
                <?php
                break;

              default:
                break;
              }
            }
          } ?>
        </select></td>
        <td align="center" valign="middle"><select class="form-control" name="TypeMatch" id="TypeMatch">
          <?php
          if ($_SESSION['JOU_PSE'] == 'Admin') {
            switch ($donnees['RES_MATCH_TYP']) {
              case 'AB':
                ?>
                <option value=""></option>
                <option value="AB" selected>AB</option>
                <option value="WO">WO</option>
                <?php
                break;

              case 'WO':
                ?>
                <option value=""></option>
                <option value="AB">AB</option>
                <option value="WO" selected>WO</option>
                <?php
                break;

              default:
              ?>
                <option value="" selected></option>
                <option value="AB">AB</option>
                <option value="WO">WO</option>
                <?php
                break;
            }
          }
          else {
              switch ($donnees['PRO_TYP_MATCH']) {
                case 'AB':
                  ?>
                  <option value=""></option>
                  <option value="AB" selected>AB</option>
                  <option value="WO">WO</option>
                  <?php
                  break;

                case 'WO':
                  ?>
                  <option value=""></option>
                  <option value="AB">AB</option>
                  <option value="WO" selected>WO</option>
                  <?php
                  break;

                default:
                ?>
                  <option value="" selected></option>
                  <option value="AB">AB</option>
                  <option value="WO">WO</option>
                  <?php
                  break;
              }
          }
          ?>
        </select></td>
        <!-- Add option to double points on prediction from Round of 16 onwards -->
        <?php
        if ($_SESSION['JOU_PSE'] !== 'Admin') {
          switch ($donnees['PRO_DBL_PTS']) {
            case '1':
            ?>
            <td align="center" valign="middle" class="cellule">
            <!-- <input type="checkbox" name="DoublePoints" id="DoublePoints"> <label for="DoublePoints"></label><br> -->
              <input type="checkbox" name="Joker" id="DoublePoints"><br>
            </td>
            <?php
            break;

            case '2':
            ?>
            <td align="center" valign="middle" class="cellule">
            <!-- <input type="checkbox" name="DoublePoints" id="DoublePoints"> <label for="DoublePoints"></label><br> -->
              <input type="checkbox" name="Joker" id="DoublePoints" value="yes" checked><br>
            </td>
            <?php
            break;
          }
        }
        ?>

        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="idMatch" class="form-control" id="idMatch" value= <?php echo $donnees['RES_MATCH_ID']; ?> required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="DateMatch" class="form-control" id="DateMatch" value= <?php echo $donnees['RES_MATCH_DAT']; ?> required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="Tournoi" class="form-control" id="Tournoi" value= <?php echo $donnees['RES_TOURNOI']; ?> required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="Categorie" class="form-control" id="Categorie" value= <?php echo $donnees['RES_TYP_TOURNOI']; ?> required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="Poids" class="form-control" id="Poids" value= <?php echo $donnees['RES_MATCH_POIDS_TOUR']; ?> required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="Sequence" class="form-control" id="Sequence" value= <?php echo $donnees['RES_MATCH_TOUR_SEQ']; ?> required="required"></td>

        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="Player1" class="form-control" id="Player1" value="<?php echo $donnees['RES_MATCH_JOU1']; ?>" required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="Player2" class="form-control" id="Player2" value="<?php echo $donnees['RES_MATCH_JOU2']; ?>" required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="Round" class="form-control" id="Round" value="<?php echo $donnees['RES_MATCH_TOUR']; ?>" required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="TypeTournoi" class="form-control" id="TypeTournoi" value="<?php echo $donnees['RES_TYP_TOURNOI']; ?>" required="required"></td>
<!-- ************************** bouton validation en fin de ligne ***************************** -->
        <!-- <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Valider" onclick="return confirm('Êtes-vous sûr de votre choix ?')"></td> -->
        <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Valider"></td>

<!-- ************************** bouton annulation en fin de ligne ***************************** -->
        <!-- <td colspan="3" valign="middle"><input type="button" value="Annuler" onclick="history.go(-1)"></td> -->
        <!-- <td colspan="3" valign="middle"><input type="button" value="Annuler" onclick="window.location.href='pagePerso.php#FinListeMatchs'"> -->
        <?php
        if ($_SESSION['JOU_PSE'] != "Admin") {
          if ($pageOrigine == 'pronostique_matchs') {
          ?>
            <td colspan="3" align="center" valign="middle"><input type="button" value="Annuler" onclick="window.location.href='pronostique_matchs.php#FinListeMatchs'">
          <?php
            } else {
              ?>
              <td colspan="3" align="center" valign="middle"><input type="button" value="Annuler" onclick="window.location.href='pagePerso.php#FinListeMatchs'">
              <?php
            }
        } else {
          if ($pageOrigine == 'gestionMatchs_correction') {
          ?>
            <!-- annulation pour correction d'un résultat déjà saisi -->
            <!-- difficulté = on ne peut pas reloader car on a chargé un formulaire -->
            <!-- le mieux est donc de faire historique -1  -->
            <td colspan="3" align="center" valign="middle"><input type="button" value="Annuler" onclick="history.go(-1)">
          <?php
        } else {
          ?>
            <td colspan="3" align="center" valign="middle"><input type="button" value="Annuler" onclick="window.location.href='gestionMatchs.php#FinListeMatchs'">
          <?php
          }
        }
        ?>
    </tr>

</table>
