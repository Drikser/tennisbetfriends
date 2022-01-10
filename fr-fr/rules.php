<?php
session_start(); // On démarre la session AVANT toute chose
?>


<!DOCTYPE html>
<html>

    <?php require("../commun/header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php require("entete.php"); ?>


    <div id="conteneur">


	    <!-- Le menu -->

	    <?php require("menu.php"); ?>

	    <!-- Le corps -->

	    <div class="element_corps" id="corps">

	        <h1>Le règlement du concours</h1>

	        <h2>Ce qu'il y a à gagner</h2>

        	<p>Toute l'estime des autres participants bien sûr ! </p>

        	<p>D'entrée de jeu soyons clair, il n'y a rien à gagner, c'est un site purement pour s'amuser à faire des pronostiques entre potes. Le but est simplement de partager ensemble notre passion du tennis et de suivre les tournois ATP d'un autre oeil, en étant plus "actif".
        	</p>

        	<h2>Le site de référence</h2>

			<p>Lors de ce concours, le site de référence sera le site <a class="a_text" href="https://www.atptour.com/" target="_blank">www.atptour.com</a>, sur lequel seront pris l'ordre des matchs et les horaires, dans la section "Daily schedule" du site.</p>


			<h2>Faire les pronostiques</h2>

        	<h3>Pronostiques tournoi</h3>

        	<p>
        	Avant le début du tournoi, vous pouvez choisir : <br />
        	- Le vainqueur <br />
        	- Les deux finalistes <br />
        	- Les quatre demi-finalistes <br />
          - Le meilleur français (le français qui ira le plus loin dans le tournoi)<br />
          &ensp;NB: il peut y en avoir plusieurs mais si votre choix est dans cette liste, vous gagnez ce bonus<br />
          - Le niveau du meilleur français (le tour où le dernier français est éliminé)<br />
          &ensp;NB: Si vous voyez un français gagner le tournoi, renseigner 'VAINQUEUR' pour ce bonus.
        	</p>
        	<p>
        	Chaque bon pronostique vous rapportera des points.
        	</p>

        	<h3>Pronostiques matchs</h3>

        	<p>Tous les jours, vous aurez la possibilité de saisir votre pronostique pour les matchs de la journée.</p>
        	<p>Le score d'un match sera en nombre de set, c'est à dire que les scores peuvent être 2/0 ou 2/1 pour les tournois hors Grand Chelem, et 3/0, 3/1 ou 3/2 pour les Grand Chelem.</p>

        	<p>
        	Les matchs sont proposés au format: Joueur1 contre Joueur2, ce qui veut dire que si vous pensez que le Joueur 2 va gagner, vous devrez pronostiquer la défaite du joueur 1.<br />
        	Le score sera toujours en faveur du vainqueur. Une victoire du joueur 2 sera donc enregistrée comme : D 3/0, D 3/1 ou D 3/2.<br />
        	Cas particuliers :<br />
        	- Abandon : Un joueur peut abandonner en cours de match, et vous pouvez choisir le format AB, avec le score qu'il y avait au moment de l'abandon.<br />
        	- Forfait : Un joueur peut déclarer forfait avant la rencontre, dans ce cas le résultat sera : 0/0 (WO).<br />
        	</p>
        	<p>
        	Quelques exemples concrêts: <br />
        	<table>
        		<tr>
        			<th>Votre pronostique</td>
        			<th colspan="6">A renseigner sur le site</td>
        		</tr>
        		<tr>
        			<td>Le joueur1 bat le joueur2 par 3 sets à 0</td>
              <td width="150" align="center" valign="middle" class="cellule">Joueur 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio" checked>
                <input type="radio" >
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Joueur 2</td>
              <td width="150" align="center" valign="middle" class="cellule">
                <select>
                  <option>3</option>
                </select>
              </td>
              <td width="150" align="center" valign="middle" class="cellule">
                <select>
                  <option>0</option>
              </select>
              <td width="50" align="center" valign="middle" class="cellule">
                <select>
                  <option></option>
              </select>
              </td>
        			<!-- <td><img src="../images/Rules-J1-V-J2-3-0.PNG" /></td> -->
        		</tr>
        		<tr>
        			<td>Le joueur2 bat le joueur1 par 3 sets à 1</td>
              <td width="150" align="center" valign="middle" class="cellule">Joueur 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio">
                <input type="radio" checked>
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Joueur 2</td>
              <td width="150" align="center" valign="middle" class="cellule">
                <select>
                  <option>3</option>
                </select>
              </td>
              <td width="150" align="center" valign="middle" class="cellule">
                <select>
                  <option>1</option>
              </select>
              <td width="50" align="center" valign="middle" class="cellule">
                <select>
                  <option selected></option>
              </select>
              </td>
        			<!-- <td><img src="../images/Rules-J1-D-J2-3-1.PNG" /></td> -->
        		</tr>
        		<tr>
        			<td>Le joueur1 abandonne sur blessure alors qu'il menait 1 set à 0</td>
              <td width="150" align="center" valign="middle" class="cellule">Joueur 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio">
                <input type="radio" checked>
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Joueur 2</td>
              <td width="150" align="center" valign="middle" class="cellule">
                <select>
                  <option>0</option>
                </select>
              </td>
              <td width="150" align="center" valign="middle" class="cellule">
                <select>
                  <option>1</option>
              </select>
              <td width="50" align="center" valign="middle" class="cellule">
                <select>
                  <option>AB</option>
              </select>
              </td>
        			<!-- <td><img src="../images/Rules-J1-D-J2-0-1-AB.PNG" /></td> -->
        		</tr>
        		<tr>
        			<td>Le joueur2 déclare forfait pour son match</td>
              <td width="150" align="center" valign="middle" class="cellule">Joueur 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio" checked>
                <input type="radio">
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Joueur 2</td>
              <td width="150" align="center" valign="middle" class="cellule">
                <select>
                  <option>0</option>
                </select>
              </td>
              <td width="150" align="center" valign="middle" class="cellule">
                <select>
                  <option>0</option>
              </select>
              <td width="50" align="center" valign="middle" class="cellule">
                <select>
                  <option>WO</option>
              </select>
              </td>
        			<!-- <td><img src="../images/Rules-J1-V-J2-0-0-WO.PNG" /></td> -->
        		</tr>
        	</table>
        	</p>


        	<h3>Les horaires des matchs</h3>

        	<p>Les horaires des matchs seront ceux affiché sur le site <a class="a_text" href="https://www.atptour.com/" target="_blank">www.atptour.com</a>, dans la programmation du jour (Daily schedule).</p>
        	<p>ATTENTION, tous les matchs n'ayant pas un horaire fixe, tous les matchs qui ont la mention "Followed by" (suivi de) auront pour horaire de référence le premier match avec un horaire fixe, ou avec la mention "Not before" (Pas avant).</p>

        	<p>Pour la programmation suivante:<br />
        	11h :<br />
        	- Match 1<br />
        	Suivi de <br />
        	- Match 2<br />
        	- Match 3<br />
        	Pas avant 16h :<br />
        	- Match 4<br />
        	- Match 5<br />
        	Pas avant 20h :<br />
        	- Match 6<br />
        	<br />
        	Dans ce cas, la limite pour rentrer le résultat des matchs 1, 2 et 3 est 11h. La limite pour rentrer le résultat des matchs 4 et 5 est 16h. La limite pour rentrer le résultat du match 6 est 20h.
        	</p>


        	<h2>Le barème</h2>

        	<p>Pronostiques tournoi:
				<ul>
            		<li>10 points pour le vainqueur</li>
		            <li>5 points par finaliste trouvé</li>
		            <li>3 points par demi-finaliste trouvé</li>
                <li>6 points pour le meilleur français</li>
                <li>6 points pour le niveau du meilleur français</li>
		       	</ul>
        	</p>

        	<p>Pronostiques matchs:
				<ul>
            		<li>5 points si vous avez trouvé le résultat exact (vainqueur + nb sets exact, ou AB ou WO)</li>
		            <li>3 points si vous avez trouvé le vainqueur sans le bon score</li>
		            <li>0 points si vous n'avez pas trouvé le vainqueur</li>
		       	</ul>
        	</p>

			<h2>Le classement</h2>

			<p>Le classement final se fait en fonction du nombre de points obtenus. En cas d'égalité, les critères pris en comptes sont:

				<ul>
            		<li>Nombre de points total</li>
            		<li>Nombre de points obtenus sur les pronostiques des matchs</li>
		            <li>Nombre de résultats exacts trouvés</li>
		            <li>Nombre de demi-finalistes trouvés</li>
		            <li>Nombre de finalistes trouvés</li>
		            <li>Vainqueur trouvé ou pas</li>
                <li>Meilleur français trouvé ou pas</li>
                <li>Niveau du meilleur français trouvé ou pas</li>
		        </ul>

		    Si malgré tout il devait encore y avoir égalité, c'est la date d'inscription qui rentrerait en jeu, avec priorité à celui qui s'est inscrit le plus tôt . En espérant ne pas en arriver sur ce dernier critère pour vous départager !
			</p>

			<br />
			<br />
			<br />

			<p><center><em><strong>Maintenant bon pronostiques et amusez-vous bien !!!</strong></em></center></p>

			<br />
			<br />
			<br />

		</div>
    </div>


    <!-- Le pied de page -->

    <?php require("../commun/piedDePAge.php"); ?>

    </body>
</html>
