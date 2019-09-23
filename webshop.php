<?php 
require_once("class_webshop.php");
require_once("texte.php");
require_once("funktionen.php");
#Upload
$result = false;
$daten = array("name" => "md5 USER", 
               "vorname" => "3", 
							 "plz" => "1", 
							 "ort" => "3", 
							 "strasse" => "3", 
							 "mail" => "1", 
							 "passwort" => "62726", 
							 "kennung" => "dj0mac");

if(isset($_FILES['xml']))
{
	$result = xmlUpload("xml");
}

$a = new webshop();
$a->setTitel("Webshop");
$a->kopf();
if(isset($_REQUEST['pdf']))
			$a->pdfliste();
if(isset($_REQUEST['neuanmeldung']))
{
	$neuanmeldung = $a->setKundenDaten(
					 array( 'name' => $_REQUEST['name'], 
                  'vorname' => $_REQUEST['vorname'], 
								  'plz' => $_REQUEST['plz'], 
								  'ort' => $_REQUEST['ort'], 
								  'strasse' =>$_REQUEST['strasse'], 
								  'mail' => $_REQUEST['email'], 
								  'passwort' => $_REQUEST['passwort'], 
								  'kennung' => $_REQUEST['kennung']
								 ));
	
	if(!$neuanmeldung)
	{
	 echo "<div style=\"color: red; font-size: 19px;\">Es wurden nicht alle Felder ausgefüllt</div>";
	}
	else {$_REQUEST['neu'] = null;}
}

#Login & Logout
if(isset($_REQUEST['abmelden']))
{
	if($a->getKundennummmer() == $_REQUEST['abmelden'])
		$a->abmelden();
}

if(!empty($_REQUEST['kennung']) && !empty($_REQUEST['passwort']))
{
	$a->setKundenNummer($_REQUEST['kennung'], $_REQUEST['passwort']);
}

if($a->getKundennummmer() == 0)
{
	if(!isset($_REQUEST['neu']))
	{
		$a->inhalt($text[6]); #Anmeldeform
	}
	else
	{
		$a->inhalt($text[7]); #Datenerfassungsform
	}
}
else
{	
	echo $a->uploadform($a->getKundennummmer()); 
}

#Seite

	if(isset($_REQUEST['wk']))
	{
		$a->inhalt($text[3]);
		$a->auswahl($a->getKundennummmer());
		$a->inhalt($text[2]);
		$a->inhalt($text[5]);
	}
	elseif(isset($_REQUEST['order']))
	{
		$a->inhalt($text[4]);
		$a->bestellen($a->getKundennummmer()); # $a->getKundennummmer()
		$a->inhalt($text[5]);
	}
	else
	{
		$a->inhalt($text[0]);	
		if(!empty($_REQUEST['id']))
			$a->waehlen($_REQUEST['id'],$a->getKundennummmer());


		$a->anzeigen();
		$a->inhalt($text[1]);
	
	}
	$a->fuss();
?>