 <!-- 
*********************************************************
*  Page pour saisie de plusieurs matchs d'un seul coup  *
*  ==> Un seul formaulaire                              *
*********************************************************
-->

<form action="pronostique.php" method="post" enctype="multipart/form-data">
<table>
    <tr>
        <th width="100" align="center" valign="middle" class="cellule">Id Match</th>
        <th width="150" align="center" valign="middle" class="cellule">Date du match</th>
        <th width="150" align="center" valign="middle" class="cellule">Niveau</th>
        <th width="150" align="center" valign="middle" class="cellule">Joueur 1</th>
        <th width="100" align="center" valign="middle" class="cellule">V ou D</th>
        <th width="150" align="center" valign="middle" class="cellule">Joueur 2</th>
        <th width="100" align="center" valign="middle" class="cellule">Score J1</th>
        <th width="100" align="center" valign="middle" class="cellule">Score J2</th>
        <th width="100" align="center" valign="middle" class="cellule">Type Match</th>
    </tr>
    <?php
    foreach ($donnees as $uneligne) {?>
        <tr>
            <td align="center" valign="middle" class="cellule"><?php echo $uneligne['RES_MATCH_ID']; ?></td>
            <td align="center" valign="middle" class="cellule"><?php echo $uneligne['RES_MATCH_DAT']; ?></td>
            <td align="center" valign="middle" class="cellule"><?php echo $uneligne['RES_MATCH_TOUR']; ?></td>
            <td align="center" valign="middle" class="cellule"><?php echo $uneligne['RES_MATCH_JOU1']; ?></td>
            <td align="center" valign="middle" width="31" ><select class="form-control" name="VouD" id="VouD" required="required">
              <option value="" selected></option>
              <option value="V">V</option>
              <option value="D">D</option>
            </select></td>
            <td align="center" valign="middle"><?php echo $uneligne['RES_MATCH_JOU2']; ?></td>
            <td align="center" valign="middle"><select class="form-control" name="ScoreJ1" id="ScoreJ1" required="required">
              <option value="" selected></option>
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select></td>
            <td align="center" valign="middle"><select class="form-control" name="ScoreJ2" id="ScoreJ2" required="required">
              <option value="" selected></option>
              <option value="0">0</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select></td>
            <td align="center" valign="middle"><select class="form-control" name="TypeMatch" id="TypeMatch">
              <option value="" selected></option>
              <option value="AB">AB</option>
              <option value="WO">WO</option>
            </select></td>
        </tr>
    <?php
        }
        ?>
    <tr>
        <td colspan="3" valign="middle"><input type="submit" name="" id="submit" class="bouton" value="Enregistrer la saisie"></td>
    </tr>
</table>
