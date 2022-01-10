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

	        <h1>Competition rules</h1>

	        <h2>What you get out of it</h2>

        	<p>All the admiration of the other participants of course!</p>

        	<p>Let's be clear from the start. There is nothing to win. This website is purely for fun and to make predictions with friends and follow tournaments in a fun way.
        	</p>

        	<h2>The reference website</h2>

			<p>During this competition, the reference website will be <a class="a_text" href="https://www.atptour.com/" target="_blank">www.atptour.com</a>, from which the order of matches and times will be taken from the tournament's "Daily schedule" section.</p>


			<h2>Make predictions</h2>

        	<h3>Tournament predictions</h3>

        	<p>
        	 Before the start of the tournament, you can choose:<br />
        	- The winner<br />
        	- The two finalists<br />
        	- The four semi-finalists<br />
          - The best Frenchman (last standing Frenchman)<br />
          &ensp;NOTE: There might be more than one player, but if your choice is in the list, you win the bonus.<br />
          - Level of best Frenchman (choose the round the last Frenchman will be out)<br />
          &ensp;NOTE: If you think a Frenchman will win the tournament, then select 'WINNER'.
        	</p>
        	<p>
        	Each correct prediction will earn you points.
        	</p>

        	<h3>Matches predictions</h3>

        	<p>You will be able to enter your prediction for the day's matches every day.</p>
        	<p>The match score will be in number of sets, i.e. the scores can be 2/0 or 2/1 for non-Grand Slam tournaments, and 3/0, 3/1 or 3/2 for Grand Slams.</p>

        	<p>
        	The matches are in the following format: Player1 against Player2, which means that if you think that Player 2 will win, you will predict the defeat of Player 1.<br />
        	The score will always be in favour of the winner. A victory for Player 2 will therefore be recorded as follows: L 3/0, L 3/1 or L 3/2.<br />
        	Exceptions:<br />
        	- Retirement: A player can retire during a match, and you can choose the format RET, with the score at the point when the player retired.<br />
        	- Forfeit: A player can forfeit a match before it starts. In this case the result will be: 0/0 (WO). <br />
        	</p>
        	<p>
        	Some examples:<br />
        	<table>
        		<tr>
        			<th>Your prediction</td>
        			<th colspan="6">To be entered on the website</td>
        		</tr>
        		<tr>
        			<td>Player1 beats Player2 by 3 sets to 0</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio" checked>
                <input type="radio" >
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Player 2</td>
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
        			<!-- <td><img src="../images/Rules-P1-V-P2-3-0.PNG" /></td> -->
        		</tr>
        		<tr>
        			<td>Player 2 beats Player1 by 3 sets to 1</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio">
                <input type="radio" checked>
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Player 2</td>
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
        			<!-- <td><img src="../images/Rules-P1-D-P2-3-1.PNG" /></td> -->
        		</tr>
        		<tr>
        			<td>Player 1 retires through injury despite leading 1 set to 0</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio">
                <input type="radio" checked>
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Player 2</td>
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
                  <option>RET</option>
              </select>
              </td>
        			<!-- <td><img src="../images/Rules-P1-D-P2-0-1-RET.PNG" /></td> -->
        		</tr>
        		<tr>
        			<td>Player 2 forfeits their match</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio" checked>
                <input type="radio">
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Player 2</td>
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
        			<!-- <td><img src="../images/Rules-P1-V-P2-0-0-WO.PNG" /></td> -->
        		</tr>
        	</table>
        	</p>


        	<h3>Match times</h3>

        	<p>The match times will be those posted on the website <a class="a_text" href="https://www.atptour.com/" target="_blank">www.atptour.com</a>, in the tournament's Daily schedule.</p>
        	<p>N.B. all matches that do not have a set time and all matches that are labelled "Followed by" will have as a reference time the first match with a set time or will be labelled "Not before".</p>

        	<p>For the following schedule:<br />
        	11 a.m.:<br />
        	- Match 1<br />
        	Followed by <br />
        	- Match 2<br />
        	- Match 3<br />
        	Not before 4 p.m.:<br />
        	- Match 4<br />
        	- Match 5<br />
        	Not before 8 p.m.:<br />
        	- Match 6<br />
        	<br />
        	 In this case, the time limit for entering the result of matches 1, 2 and 3 is 11 a.m. The time limit for entering the result of matches 4 and 5 is 4 p.m. The time limit for entering the result of match 6 is 8 p.m.
        	</p>


        	<h2>The scale</h2>

        	<p>Tournament predictions:
				<ul>
            		<li>10 points for the winner</li>
		            <li>5 points per finalist predicted</li>
		            <li>3 points per semi-finalist predicted</li>
                <li>6 points for the best Frenchman</li>
                <li>6 points for the level of the best Frenchman</li>
		       	</ul>
        	</p>

        	<p>Match predictions:
				<ul>
            		<li>5 points if you predicted the exact result (winner + exact no. of sets, or AB or WO)</li>
		            <li>3 points if you predicted the winner without the correct score</li>
		            <li>0 points if you did not predict the winner</li>
		       	</ul>
        	</p>

			<h2>Ranking</h2>

			<p>The final ranking is based on the number of points scored. In the event of a tie, the criteria taken into account are:

				<ul>
            		<li>Total number of points</li>
            		<li>Number of points scored from match predictions</li>
		            <li>Number of exact results predicted</li>
		            <li>Number of semi-finalists predicted</li>
		            <li>Number of finalists predicted</li>
		            <li>Winner predicted or not </li>
		        </ul>

		    If in spite of everything there is still a tie, whoever registered first wins. Let's hope we don't have to use this rule to decide the winner!
			</p>

			<br />
			<br />
			<br />

			<p><center><em><strong>Good luck with your predictions and have fun!!!</strong></em></center></p>

			<br />
			<br />
			<br />

		</div>
    </div>


    <!-- Le pied de page -->

    <?php require("../commun/piedDePAge.php"); ?>

    </body>
</html>
