<form action="formulaireSaisieDateCible.php" method="post" enctype="multipart/form-data">

<table>
    <tr>
<!--        <th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>   -->
<!-- Rows to display for the form -->
        <th width="150" align="center" valign="middle" class="cellule">Date du match</th>
        <th width="150" align="center" valign="middle" class="cellule">Niveau</th>
        <th width="150" align="center" valign="middle" class="cellule">Joueur 1</th>
        <th width="150" align="center" valign="middle" class="cellule">Joueur 2</th>
        <th width="150" align="center" valign="middle" class="cellule">Nouvelle date</th>
<!-- Rows to not display, but which still need to send through the form -->
        <th width="100" align="center" valign="middle" class="cellule" style="display:none">Id Match</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Date du match (à transmettre)</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Tournoi</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Categorie</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Poids</th>
        <th width="150" align="center" valign="middle" class="cellule" style="display:none">Sequence</th>
    </tr>

    <tr>
        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_DAT']; ?></td>
        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_TOUR']; ?></td>
        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU1']; ?></td>
        <td align="center" valign="middle" class="cellule"><?php echo $donnees['RES_MATCH_JOU2']; ?></td>
        <td align="center" valign="middle" class="cellule"><input type="datetime" name="NewDateMatch" class="form-control" id="newDateMatch"></td>

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
        ?>
    </tr>

</table>
