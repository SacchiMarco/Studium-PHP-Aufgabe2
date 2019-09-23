<?php 
function xmlUpload($value)
{
	if($_FILES[$value]['size'] == 0)
		return $result = "<p style=\"color:#F30; font-weight:bold;\">>>! Die Datei die Sie hochladen wollen ist leer !<< </p>";

	if($_FILES[$value]['name'] != "artikeldaten.xml")
		return $result = "<p style=\"color:#F30; font-weight:bold;\">>>! Die Datei die Sie hochladen wollen heist nicht \"artikeldaten\" !<< </p>
											<p>Falls es die richtige Datei ist bitte umbenennen in artikeldaten </p>";
	
	if($_FILES[$value]['type'] == "text/xml")
	{
		$_FILES[$value]['name'] = "artikeldaten.xml";#wird eigentlich nicht benötigt, ist nur zur absicherung 
		$pfad = getcwd();
		move_uploaded_file($_FILES[$value]['tmp_name'],$pfad."/".$_FILES[$value]['name']);
		return $result = "<p style=\"color:#390; font-weight:bold;\">Die Datei: ".$_FILES[$value]['name']." wurde hochgeladen</p>";
	}
	else
	{
		return $result = "<p style=\"color:#F30; font-weight:bold;\">>>! Datei ist kein xml Format !<<</p>";
	}
		
}
?>