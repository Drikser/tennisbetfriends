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

	        <h2>What's in it for me?</h2>

        	<p>All the admiration of the other participants of course!</p>

        	<p>Let's be clear from the start. There is nothing to win. This website is purely for fun and to make predictions with friends and follow tournaments in a fun way.
        	</p>

        	<h2>The reference website</h2>

			<p>During this competition, the reference website will be <a class="a_text" href="https://www.atptour.com/" target="_blank">www.atptour.com</a>. The order of the matchesand the times will be taken from the tournament's "Daily schedule" section of this website.</p>


			<h2>Make predictions</h2>

        	<h3>Tournament predictions</h3>

        	<p>
        	 Before the start of the tournament, you can choose:<br />
        	- The winner<br />
        	- The two finalists<br />
        	- The four semi-finalists<br />
          - The best Frenchman (the last Frenchman standing)<br />
          &ensp;NOTE: There might be more than one player, but if your choice is in the list, you win the bonus.<br />
          - The level of best Frenchman (Decide in which round the last Frenchman will be leaving the tournament)<br />
          &ensp;NOTE: If you think a Frenchman will win the tournament, select 'WINNER'.
        	</p>
        	<p>
        	Each correct prediction will earn you points.
        	</p>

        	<h3>Match predictions</h3>

        	<p>You will be able to enter your predictions for the matches of the day, everyday. How you do this will vary slightly, depending on the stage of the tournament:<br />
            - First 2 rounds: you only select the winner<br />
            - 3rd round: you make your prediction as usual<br />
            - From round of 16 onwards: you make your prediction as usual, but you now have 3 wild cards that you can use at any time to double your points on the match of your choice.<br />
          </p>

          <h4>- First 2 rounds</h4>

          <p>For the first 2 rounds, you only select the winner, regardless of whether it is a normal  match, one player has retired during the match or one player has withdrawn before the match.</p>

          <p>
        	Example: <br />
        	<table>
        		<tr>
        			<th>Your prediction</td>
        			<th colspan="6">Website entry</td>
        		</tr>
        		<tr>
        			<td>Player1 beats player2</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio" checked>
                <input type="radio" >
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Player 2</td>
              </td>
        			<!-- <td><img src="../images/Rules-J1-V-J2-3-0.PNG" /></td> -->
        		</tr>
        		<tr>
        			<td>Player2 beats player1</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 1</td>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="radio">
                <input type="radio" checked>
              </td>
              <td width="150" align="center" valign="middle" class="cellule">Player 2</td>
        			<!-- <td><img src="../images/Rules-J1-D-J2-3-1.PNG" /></td> -->
        		</tr>
          </table>
        	</p>

          <h4>- 3ème tour</h4>

        	<p>The match score will be in number of sets, i.e. the score can be 3/0, 3/1 or 3/2.</p>

        	<p>
        	The matches are in the following format: Player1 against Player2, to select the winner, tick the appropriate box.<br />
        	The score will always be in favour of the winner. If you select Player 2 as the winner, the score must be recorded as follows: 3/0, 3/1 or 3/2.<br />
        	Exceptions:<br />
        	- Retirement: A player can retire during a match, and you can choose the format RET, with the score when the player retired.<br />
        	- Forfeit: A player can forfeit a match before it starts. In this case the result will be: 0/0 (WO). <br />
        	</p>
        	<p>
        	Some examples:<br />
        	<table>
        		<tr>
        			<th>Your prediction</td>
        			<th colspan="6">Website entry</td>
        		</tr>
        		<tr>
        			<td>Player1 beats player2 by 3 sets to 0</td>
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

          <h4>- From round of 16 onwards</h4>

          <p>Same way of doing as previous round, but you now have three wild cards that you can use at any time to double your points on the match of your choice. <br />
          If you have the exact score, your points will be 5pts x 2 = 10pts. <br />
          If you only have guessed the winner correctly, your points will be 3pts x 2 = 6pts. <br />
          If your prediction was incorrect, your points will be 0pt x 2 = 0pt. <br />
          </p>

          <p>
        	Let's see some examples: <br />
        	<table>
        		<tr>
        			<th>Your prediction</td>
        			<th colspan="7">Website entry</td>
        		</tr>
        		<tr>
        			<td>You want to play a wild card on this match</td>
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
                  <option>1</option>
                </select>
              <td width="50" align="center" valign="middle" class="cellule">
                <select>
                  <option></option>
                </select>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="checkbox" value="yes" checked><label>(2 wildcards remaining)</label><br>
                  <option></option>
                </select>
              </td>
        		</tr>
            <tr>
        			<td>You do not want to play a wild card on this match</td>
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
                  <option>1</option>
                </select>
              <td width="50" align="center" valign="middle" class="cellule">
                <select>
                  <option></option>
                </select>
              <td width="50" align="center" valign="middle" class="cellule">
                <input type="checkbox" value="yes"><label>(2 wildcards remaining)</label><br>
                  <option></option>
                </select>
              </td>
        		</tr>
        	</table>
        	</p>

          <p>When you use a wild card, it will be marked as &#9733 symbol in the score recap.</p>
          <p>
        	Example: <br />
        	<table>
            <tr>
        			<th>Round</td>
              <th>Player 1</td>
              <th>Result</td>
              <th>Player 2</td>
              <th>Username</td>
        		</tr>
        		<tr>
              <td width="150" align="center" valign="middle" class="cellule">ROUND OF 16</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 1</td>
              <td width="50" align="center" valign="middle" class="cellule">W 3/1</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 2</td>
              <td width="150" align="center" valign="middle" class="cellule">&#9733 W 3/1 (10pts)</td>
        		</tr>
            <tr>
              <td width="150" align="center" valign="middle" class="cellule">ROUND OF 16</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 1</td>
              <td width="50" align="center" valign="middle" class="cellule">W 3/1</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 2</td>
              <td width="150" align="center" valign="middle" class="cellule">&#9733 W 3/0 (6pts)</td>
        		</tr>
            <tr>
              <td width="150" align="center" valign="middle" class="cellule">ROUND OF 16</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 1</td>
              <td width="50" align="center" valign="middle" class="cellule">W 3/1</td>
              <td width="150" align="center" valign="middle" class="cellule">Player 2</td>
              <td width="150" align="center" valign="middle" class="cellule">&#9733 L 3/2 (0pt)</td>
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
        	 In this case, the time limit for entering the results of matches 1, 2 and 3 is 11 a.m. The time limit for entering the results of matches 4 and 5 is 4 p.m. The time limit for entering the result of match 6 is 8 p.m.
        	</p>


        	<h2>The scale</h2>

        	<p>Tournament predictions:

				    <ul>
            		<li>10 points for the winner</li>
		            <li>5 points per correctly predicted finalist</li>
		            <li>3 points per correctly predicted semi-finalist</li>
                <li>6 points for the best Frenchman</li>
                <li>6 points for the level of the best Frenchman</li>
		       	</ul>
        	</p>

        	<p>Match predictions:
            <ul>
            		<li>First 2 rounds</li>
                <ul>
                  <li>1 point if you predicted the winner</li>
                  <li>0 point if you did not predict the winner</li>
                </ul>
		            <li>3rd round</li>
                <ul>
                  <li>5 points if you predicted the exact result (winner + exact no. of sets, or AB or WO)</li>
  		            <li>3 points if you predicted the winner without the correct score</li>
  		            <li>0 points if you did not predict the winner</li>
    		       	</ul>
		            <li>From round of 16 onwards</li>
                <ul>
                  <li>10 points if you predicted the exact result with wildcard</li>
  		            <li>6 points if you predicted the winner without the correct score with wildcard</li>
              		<li>5 points if you predicted the exact result without wildcard</li>
  		            <li>3 points if you predicted the winner without the correct score without wildcard</li>
  		            <li>0 point points if you did not predict the winner, with or without wildcard</li>
    		       	</ul>
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
