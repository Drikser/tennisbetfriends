<?php

//----------------------------------------
// Fonction afficher date
//---------------------------------------

function dateFr()
{
  // les noms de jours / mois
  var day = new Array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
  var month = new Array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");
  // on recupere la date
//			function refreshDate()
//			{
    var date = new Date();
    // on construit le message
    var message = day[date.getDay()] + " ";   // nom du jour
    message += date.getDate() + " ";   // numero du jour
    message += month[date.getMonth()] + " ";   // mois
    message += date.getFullYear();
    return message;
//			}
//			refreshDate();
//			setInterval(refreshDate,1);
}

console.log("nous sommes le", dateFr());



//----------------------------------------
// Fonction afficher heure
//---------------------------------------
function heure()
{
//			function refreshTime()
//			{
     var date = new Date();
     var hours = date.getHours();
     var minutes = date.getMinutes();
     if(minutes < 10)
          minutes = "0" + minutes;
     var seconds = date.getSeconds();
     if (seconds < 10)
          seconds = "0" + seconds;

     return hours + ":" + minutes + ":" + seconds;
//			 }
 			refreshTime();
 			setInterval(refreshTime,1000);
}

console.log("il est exactement", heure());

?>
