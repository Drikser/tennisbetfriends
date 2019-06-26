 <!-- 
*********************************************************
*  Page pour saisie de plusieurs matchs d'un seul coup  *
*  ==> Un formulaire par match saisit                  *
*********************************************************
-->
<form action="formulaireSaisieResultatCible.php" method="post" enctype="multipart/form-data">
<table>
    <tr>
        <th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
        <th width="150" align="center" valign="middle" class="cellule">Date du match</th>
        <th width="150" align="center" valign="middle" class="cellule">Tournoi</th>
        <th width="150" align="center" valign="middle" class="cellule">Niveau</th>
        <th width="150" align="center" valign="middle" class="cellule">Joueur 1</th>
        <th width="100" align="center" valign="middle" class="cellule">V ou D</th>
        <th width="150" align="center" valign="middle" class="cellule">Joueur 2</th>
        <th width="100" align="center" valign="middle" class="cellule">Score vainqueur (nb sets)</th>
        <th width="100" align="center" valign="middle" class="cellule">Score perdant (nb sets)</th>
        <th width="100" align="center" valign="middle" class="cellule">Type Match</th>
    </tr>
    <?php
    foreach ($donnees as $uneligne) {
        $idMatch = $uneligne['RES_MATCH_ID'];
        $Player1 = $uneligne['RES_MATCH_JOU1'];
        $Player2 = $uneligne['RES_MATCH_JOU2'];
        $Round = $uneligne['RES_MATCH_TOUR'];
        ?>
        <tr>
<!--            <td align="center" valign="middle" class="cellule" style="display:none" ><?php echo $uneligne['RES_MATCH_ID']; ?></td> -->
            <td align="center" valign="middle" class="cellule" style="display:none"><input type="text" name="idMatch" class="form-control" id="idMatch" value= <?php echo $idMatch; ?> required="required"></td>
            <td align="center" valign="middle" class="cellule"><?php echo $uneligne['RES_MATCH_DAT']; ?></td>
            <td align="center" valign="middle" class="cellule"><?php echo $uneligne['RES_TOURNOI']; ?></td>
            <td align="center" valign="middle" class="cellule"><?php echo $uneligne['RES_MATCH_TOUR']; ?></td>
            <td align="center" valign="middle" class="cellule"><?php echo $uneligne['RES_MATCH_JOU1']; ?></td>
            <td align="center" valign="middle" width="31" ><select class="form-control" name="VouD" id="VouD" required="required">
              <option value="" selected></option>
              <option value="V">V</option>
              <option value="D">D</option>
            </select></td>
            <td align="center" valign="middle"><?php echo $uneligne['RES_MATCH_JOU2']; ?></td>
            <td align="center" valign="middle"><select class="form-control" name="ScoreJ1" id="ScoreJ1" required="required">
              <?php
              if ($uneligne['RES_TYP_TOURNOI'] == 'GC') { ?>
                <option value="0" selected>0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <?php }
              else { ?>
                <option value="0" selected>0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <?php } ?>
            </select></td>
            <td align="center" valign="middle"><select class="form-control" name="ScoreJ2" id="ScoreJ2" required="required">
              <?php
              if ($uneligne['RES_TYP_TOURNOI'] == 'GC') { ?>
                <option value="0" selected>0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <?php }
              else { ?>
                <option value="0" selected>0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <?php } ?>
            </select></td>
            <td align="center" valign="middle"><select class="form-control" name="TypeMatch" id="TypeMatch">
              <option value="" selected></option>
              <option value="AB">AB</option>
              <option value="WO">WO</option>
            </select></td>
            <td align="center" valign="middle" class="cellule"><input type="text" name="Player1" class="form-control" id="Player1" value= <?php echo $Player1; ?> required="required"></td>
            <td align="center" valign="middle" class="cellule"><input type="text" name="Player2" class="form-control" id="Player2" value= <?php echo $Player2; ?> required="required"></td>
            <td align="center" valign="middle" class="cellule"><input type="text" name="Round" class="form-control" id="Round" value= <?php echo $Round; ?> required="required"></td>
        </tr>
        <tr>
            <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Enregistrer la saisie pour ce match"></td>
        </tr>
    <?php
        }
        ?>
</table>
