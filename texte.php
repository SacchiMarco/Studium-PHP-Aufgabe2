<?php 
$text = array();
$text[0][0]="<h1>Willkommen beim Konzertportal</h1>";
$text[0][1]="<h3>Die angesagtesten Konzerte in Ihrer nähe!!</h3>";
$text[0][2]="<p>Folgende Artikel können Sie bei uns bestellen:</p>";

$text[3][0]="<h1>Warenkorb</h1><p>Im Warenkorb liegen:</p>";
$text[4][0]="<h1>Bestellung erfolgreich</h1><p>Wir haben Ihre Bestellung erhalten.</p>";

$text[1][0]="<br /><a href=\"".$_SERVER['PHP_SELF'].
						"?wk\">Zum Warenkorb</a>";
$text[2][0]="<br /><a href=\"".$_SERVER['PHP_SELF'].
						"?order\">Bestellen</a>";
$text[2][1]="<br /><a href=\"".$_SERVER['PHP_SELF'].
						"?pdfrech\">PDF- Rechnung</a>";
$text[5][0]="<br /><a href=\"".$_SERVER['PHP_SELF'].
						"\">zurück zur Konzertauswahl</a>";
						
$text[6][1]='';
$text[6][2]='<form method="post" accept-charset= "utf-8">';
$text[6][3]='<table bgcolor="#CCCCCC">';
$text[6][4]='<tr height="15	"><td>Anmeldename: <input '.
						'name="kennung" type="text">';
$text[6][5]='Passwort: <input '.
            'name="passwort" type="password"> ';
$text[6][6]='<input '.
            'type="submit" value="anmelden"> <a href="'.$_SERVER['PHP_SELF'].'?neu"><span style=" font-size: 14px">Neuer Kunde?</span></a></td></tr>';
$text[6][7]='</table> ';
$text[6][8]='</form>';


$text[7][0]="<h3>Bitte geben Sie ihre Daten ein.</h3>\n<p>Diese werden selbstverständlich vertraulich behandelt.</p>";
$text[7][1]="<form method=\"post\" accept-charset=\"utf-8\">";
$text[7][2]="<input type=\"hidden\" name=\"neuanmeldung\">";
$text[7][3]="<table>";
$text[7][4]="<tr>\n<td>Name: </td><td><input name=\"name\" type=\"text\"></td>\n</tr>";
$text[7][5]="<tr>\n<td>Vorname: </td><td><input name=\"vorname\" type=\"text\"></td>\n</tr>";
$text[7][6]="<tr>\n<td>PLZ: </td><td><input type=\"text\" name=\"plz\"></td>\n</tr>";
$text[7][7]="<tr>\n<td>Ort: </td><td><input name=\"ort\" type=\"text\"></td>\n</tr>";
$text[7][8]="<tr>\n<td>Stra&szlig;e: </td><td><input name=\"strasse\" type=\"text\"></td>\n</tr>";
$text[7][9]="<tr>\n<td>EMail-Adresse: </td><td><input name=\"email\" type=\"text\"></td>\n</tr>";
$text[7][10]="<tr>\n<td>Anmeldename: </td><td><input name=\"kennung\" type=\"text\"></td>\n</tr>";
$text[7][11]="<tr>\n<td>Passwort: </td><td><input name=\"passwort\" type=\"password\"></td>\n</tr>";
$text[7][12]="<tr>\n<td colspan=\"2\" align=\"center\"><hr><input type=\"submit\" value=\"anmelden\"></td>\n</tr>";
$text[7][13]="</table>";
$text[7][14]="</form>"
?>