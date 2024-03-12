<?php
// *********************************************************
// *  Page pour saisie de plusieurs matchs d'un seul coup  *
// *  ==> Un formulaire par match saisit                   *
// *********************************************************
?>
<table>
    <tr>
        <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
        <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
        <td width="150" align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
        <td width="50"  align="center" valign="middle" class="cellule">
          <?php
          if ($_SESSION['JOU_PSE'] == 'Admin') {
            switch ($donnees['RES_MATCH']) {
              case 'V':
                ?>
                <input type="radio" id="V" name="VouD" value="V" checked>
                <input type="radio" id="D" name="VouD" value="D">
                <?php
                break;

              case 'D':
                ?>
                <input type="radio" id="V" name="VouD" value="V">
                <input type="radio" id="D" name="VouD" value="D" checked>
                <?php
                break;

              default:
              ?>
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
                <input type="radio" id="V" name="VouD" value="V" checked>
                <input type="radio" id="D" name="VouD" value="D">
                <?php
                break;

              case 'D':
                ?>
                <input type="radio" id="V" name="VouD" value="V">
                <input type="radio" id="D" name="VouD" value="D" checked>
                <?php
                break;

              default:
              ?>
                <input type="radio" id="V" name="VouD" value="V">
                <input type="radio" id="D" name="VouD" value="D">
                <?php
                break;
            }
          }
          ?>
        </select></td>
        <td width="150" align="center" valign="middle"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>

        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="ScoreJ1" class="form-control" id="ScoreJ1" value= <?php echo $donnees['RES_MATCH_SCR_JOU1']; ?> required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="ScoreJ2" class="form-control" id="ScoreJ2" value= <?php echo $donnees['RES_MATCH_SCR_JOU2']; ?> required="required"></td>
        <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="TypeMatch" class="form-control" id="TypeMatch" value= <?php echo $donnees['RES_MATCH_TYP']; ?> required="required"></td>
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
        <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Valider"></td>

<!-- ************************** bouton annulation en fin de ligne ***************************** -->
        <?php
        if ($_SESSION['JOU_PSE'] != "Admin") {
          if ($pageOrigine == 'pronostique_matchs') {
          ?>
            <td colspan="3" align="center" valign="middle"><input type="button" value="Annuler" onclick="window.location.href='pronostique_matchs.php'">
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
