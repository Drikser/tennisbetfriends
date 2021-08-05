<div id="div_localTime"></div>

<script type="text/javascript">

window.onload=function() {
  localTime('div_localTime');
};

//----------------------------------------
// Fonction afficher heure
//---------------------------------------
function localTime()
{
     var date = new Date();
     var hours = date.getHours();
     var minutes = date.getMinutes();
     if(minutes < 10)
          minutes = "0" + minutes;
     var seconds = date.getSeconds();
     if (seconds < 10)
          seconds = "0" + seconds;

     return hours + ":" + minutes + ":" + seconds;
}

//setInterval(localTime(),1000);

console.log("il est exactement", localTime());


//-----

//function horloge(el) {
//  if(typeof el=="string") { el = document.getElementById(el); }
//  function actualiser() {
//    var date = new Date();
//    var str = date.getHours();
//    str += ':'+(date.getMinutes()<10?'0':'')+date.getMinutes();
//    str += ':'+(date.getSeconds()<10?'0':'')+date.getSeconds();
//    el.innerHTML = str;
//  }
//  actualiser();
//  setInterval(actualiser,1000);
//}
</script>
