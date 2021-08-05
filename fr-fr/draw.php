<?php
session_start(); // On démarre la session AVANT toute chose
?>

<!DOCTYPE html>
<html>

    <?php require("../commun/header.php"); ?>

    <body>

    <!-- L'en-tête -->

    <?php require("entete.php"); ?>

    <!-- Le menu -->

    <div id="conteneur">

        <?php require("menu.php"); ?>

        <!-- Le corps -->

        <div class="element_corps" id="corps">

          <h1>Australian Open 2020 - Tableau simple messieurs</h1>
    		<p>
        		<!-- Affichage du classement des joueurs -->
            <table>
              <tr>
                <th align="center" valign="middle">1er tour</th>
                <th align="center" valign="middle">2ème tour</th>
                <th align="center" valign="middle">3ème tour</th>
                <th align="center" valign="middle">1/8ème de finales</th>
                <th align="center" valign="middle">1/4 de finales</th>
                <th align="center" valign="middle">1/2 finales</th>
                <th align="center" valign="middle">Finale</th>
                <th align="center" valign="middle">Vainqueur</th>
              </tr>
              <?php
              $line = 1;

              $nbPlayers = getPlayersTournament();
              $donnees = $nbPlayers->fetch();
              //echo 'Nombre de jouers engagés dans le tournoi = ' . $nbPlayers . '<br />';
              echo 'Nombre de joueurs engagés dans le tournoi = ' . $donnees['NbPlayersTournament'] . '<br />';
              while ($line <= $donnees['NbPlayersTournament']) {
                ?>

                <tr>
                  <td align="center" valign="middle">a</td>
                  <td align="center" valign="middle">b</td>
                  <td align="center" valign="middle">c</td>
                  <td align="center" valign="middle">d</td>
                  <td align="center" valign="middle">e</td>
                  <td align="center" valign="middle">f</td>
                  <td align="center" valign="middle">g</td>
                  <td align="center" valign="middle">h</td>
                </tr>

                <?php

                $line ++;
              }
              ?>
            </table>
    		</p>

        </div>

      <div class="container">
        <div id="outer-edito-content"><!----> <!---->
          <div data-v-a13384c2="" class="container__content js-container-content layout">
            <div data-v-a13384c2="" class="Bracket container__main js-container-main">
              <div data-v-a13384c2="" class="pageHeading">
                <h1 data-v-a13384c2="" class="heading heading--1">Rotterdam 2020 - Tableau simple messieurs</h1>
              </div>
      <div data-v-a13384c2="">
        <div data-v-33863374="" data-v-a13384c2="">
          <div data-v-33863374="" class="Bracket">
            <div data-v-e93c3154="" data-v-33863374="" class="observer">
            </div> <div data-v-33863374="" class="Bracket__top">
              <div data-v-33863374="" class="Bracket__header">
                <div data-v-33863374="" class="Bracket__head Bracket__head--round Bracket__head--activeRound">Premier tour</div>
                <div data-v-33863374="" class="min--desktop Bracket__head Bracket__head--round">
                       Deuxième tour
                   </div>
                   <div data-v-33863374="" class="Bracket__head Bracket__head--navigation">
                     <div data-v-33863374="" class="Bracket__head Bracket__head--link Bracket__head--disabled">
                           tour préc.
                       </div>
                       <div data-v-33863374="" class="Bracket__head Bracket__head--separator">|</div>
                       <div data-v-33863374="" class="Bracket__head Bracket__head--link">
                           tour suiv.
                       </div>

                       <div data-v-33863374="" class="Bracket__container" style="height: auto;">
                         <div data-v-33863374="" class="Bracket__content js-bracket-content" style="left: 0px; width: 1500px;">
                           <div data-v-33863374="" infos-round="0" class="Bracket__round js-bracket-round Bracket__round--current">
                             <ul data-v-33863374="" class="Bracket__list" style="height: 1440px;">
                               <li data-v-33863374="" class="Bracket__item">
                                 <div data-v-33863374="" class="Bracket__event"><!---->
                                   <a data-v-42ef1a0f="" data-v-33863374="" target="_blank" class="Link TennisScore">
                                   <div data-v-42ef1a0f="" class="TennisScore__teams">
                                     <div data-v-42ef1a0f="" class="TennisScore__team TennisScore__team--home">
                                         <div data-v-42ef1a0f="" class="TennisScore__name TennisScore__name--hasRank">
                                           <span data-v-42ef1a0f="" title="Medvedev" class="TennisScore__player">Medvedev</span>
                                         </div>
                                       <div data-v-42ef1a0f="" class="TennisScore__team TennisScore__team--away">
                                         <div data-v-42ef1a0f="" class="TennisScore__name TennisScore__name--winner">
                                           <span data-v-42ef1a0f="" title="Pospisil0" class="TennisScore__player">Pospisil</span>
                                         </div> <!---->
                                       </div>
                                     </div> <!----> <!---->
                                   </a> <!---->
                                 </div>
                               </li>




    </div>

    <!-- Le pied de page -->

    <?php require("../commun/piedDePAge.php"); ?>

    </body>
</html>
