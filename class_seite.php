<?php 
class seite
{
	private $titeltext;
	protected $content = array();
	
	public function __construct()
	{
		session_start();		
	}
	
	public function setTitel($titel)
	{
		$this->titeltext = $titel;
	}
	
	public function kopf()
	{
		print"<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">\n";
		print"<html>\n";
		print"<head>\n";
		print"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
		if($this->titeltext) print"<title>". $this->titeltext ."</title>\n";
		print"</head>\n";
		print"<body bgcolor=\"#333333\" >\n";
		print'<div align="center" style=" width: 800px;
		                                  margin: 20px auto;
																			padding: 5px 8px 5px 8px;
																			background-color: #FFFFFF;
		                                ">';
		print'<div  align="center" style=" width: 800px; 
																			 margin: 0 auto; 
																			 border: solid 1px #CCCCCC; 
																			 background-color: #DFF3F5; 
																			">';
	}
	
	public function inhalt($daten)
	{
		foreach ($daten as $value)
    {
       print $value."\n";
    }
	}
	public function fuss()
	{
		print"<hr>\n";
		print'<div style="font-size: 14px; padding: 3px 0 10px 0;">';
		print date("d D-m-Y",time())." - ".date("H :i :s",time());
		print'</div>';
		print'</div>';
		print'</div>';
		print"</body>\n";
		print"</html>\n";
	}
	
	public function loginform()
	{
		$phpself = $_SERVER['PHP_SELF'];
		#Ich wollte EOT ausprobieren 
		$form = 
<<<form
		<form name="form1" method="post" action="{$phpself}">
		<table border="1" cellspacing="0" cellpadding="1">
			<tr>
				<td>Benutzername/Passwort: </td>
				<td><input type="text" name="user" id="user">
					<input type="password" name="pwd" id="pwd">
					<input name="Senden" type="submit" value="Login"></td>
			</tr>
		</table>
		</form>
form;
		return $form;
	}
	
	public function uploadform($knr)
	{
		$phpself = $_SERVER['PHP_SELF'];
		$form = <<<form
		<form action="{$phpself}" method="post" enctype="multipart/form-data" name="form2">
		<table border="1" cellspacing="0" cellpadding="1">
			<tr>
				<td>Kundennummer: {$knr}&nbsp;</td>
				<td style="padding:0 5px 0 5px;"><a href="?abmelden={$knr}"> Abmelden</a></td>
			</tr>
		</table>
		</form>
form;
		return $form;
	}
	
}
?>