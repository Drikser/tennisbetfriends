<div class="clock2" id="timer2"></div>

<script type="text/javascript">

//onload="horloge();"

window.onload=function() {
  horloge2('timer2');
};

function horloge2()
{

//	var tt = new Date().toLocaleTimeString(); // hh:mm:ss
  var tt = new Date().toLocaleString(); // date dans la langue du système, heure (hh:mm:ss) au format 24h si navigateur en français ;
//	var tt = new Date().toString(); // date en anglais, heure (hh:mm:ss) et fuseau horaire ;

	document.getElementById("timer2").innerHTML = tt;
	setTimeout(horloge2, 1000); // mise à jour du contenu "timer" toutes les secondes
}

</script>
