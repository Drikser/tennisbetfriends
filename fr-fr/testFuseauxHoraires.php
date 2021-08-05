<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Affichage Date avec moment.format()</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
<style>
html, body{
  margin:0;
  padding:0;
  font: 1em/1.5 Verdana, sans-serif;
}
#main {
  width:60em;
  margin:0 auto;
}
h1, h2, h3 {
  color:#069;
}
#contenu {
  font-size:1em;
}
#contenu ul {
  font-weight:bold;
}
#contenu div:first-letter {
  text-transform: uppercase;
  font-size:initial;
}
#contenu div {
  font-size:.9em;
  font-weight:normal;
  margin:0 0 .5em .5em;
  width:20em;
  text-align:right;
}
</style>
</head>
<body>
<div id="contenu">
   <h1>Fuseaux horaires</h1>
  <ul>
    <li>
      Papeete
      <div id="papeete"></div>
    </li>
    <li>
      Martinique
      <div id="martinique"></div>
    </li>
    <li>
      Saint Pierre et Miquelon
      <div id="saint-pierre"></div>
    </li>
    <li>
      Brest
      <div id="brest"></div>
    </li>
    <li>
      Réunion
      <div id="reunion"></div>
    </li>
    <li>
      Nouméa
      <div id="noumea"></div>
    </li>
    <li>
      Melbourne
      <div id="melbourne"></div>
    </li>
    <li>
      Paris
      <div id="paris"></div>
    </li>
    <li>
      London
      <div id="london"></div>
    </li>
    <li>
      New-York
      <div id="new-york"></div>
    </li>
  </ul>
</div>
</body>

<script>
// redéfinition de données
// http://momentjs.com/docs/#/i18n/changing-locale/
moment.locale( "en", {
  months:        'janvier février mars avril mai juin juillet août septembre octobre novembre décembre'.split(' '),
	monthsShort:   'janv. févr. mars avr. mai juin juil. août sept. oct. nov. déc.'.split(' '),
	weekdays:      'Dimanche Lundi Mardi Mercredi Jeudi Vendredi Samedi'.split(' '),
	weekdaysShort: 'dim. lun. mar. mer. jeu. ven. sam.'.split(' '),
	weekdaysMin:   'Di Lu Ma Me Je Ve Sa'.split(' ')
});
// http://momentjs.com/docs/#/displaying/format/
var dFormat = 'dddd Do MMMM YYYY HH:mm:ss';

// Données d'affichage et de traitement
var data = [
  {'id' : 'papeete',      'utc' : -10 },  // -10 UTC
  {'id' : 'martinique',   'utc' :  -4 },  // -04 UTC
  {'id' : 'saint-pierre', 'utc' :  -3 },  // -03 UTC
  {'id' : 'brest',        'utc' :  +1 },  // +01 UTC
  {'id' : 'reunion',      'utc' :  +4 },  // +04 UTC
  {'id' : 'noumea',       'utc' : +11 },  // +11 UTC
  {'id' : 'melbourne',    'utc' :  +9 },  // -06 UTC
  {'id' : 'paris',        'utc' :  +2 },  // -00 UTC
  {'id' : 'london',       'utc' :  +1 },  // -01 UTC
  {'id' : 'new-york',     'utc' :  -6 }   // -06 UTC
];
// Fonction d'affichage
function afficheHeure(){
  var i, nb = data.length,
      dTemp;
  for( i=0; i < nb; i +=1){
    dTemp = moment().utcOffset(data[i].utc);
    document.getElementById(data[i].id).innerHTML = dTemp.format(dFormat);
  }
}
// lance affichage toutes les prochaines secondes
setInterval(afficheHeure, 1000);
// affichage immédiat
afficheHeure();

</script>
</html>
