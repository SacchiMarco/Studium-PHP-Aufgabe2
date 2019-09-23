<?php 
class kunde
{
	private $KndNr;
	private $dbh;
	
	public function __construct(&$dbh)
	{
		if (is_object($dbh) && $dbh instanceof PDO)
			$this->dbh = $dbh;
		else
			$this->KndNr = time();
		if(isset($_SESSION['kunde']))
			$this->KndNr = $_SESSION['kunde'];
	}
	
	public function __destruct()
	{
		$_SESSION['id'] = $this->KndNr;
	}
	
	public function setKundenNummer($kennung, $passwort)
	{
		$this->KndNr = 0;
		if(!empty($kennung) && !empty($passwort))
		{
			try
			{
				$sql = "SELECT k_kundennummer
				        FROM ws_kunden
								WHERE
									k_kennung = :kennung
								AND
									k_passwort = :passwort";
				$result = $this->dbh->prepare($sql);
				$result->bindParam(':kennung', $kennung, PDO::PARAM_STR, 20);
				$result->bindParam(':passwort', md5($passwort), PDO::PARAM_STR, 32);
				$result->execute();
				
				$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
				if(isset($tmp[0]['k_kundennummer']) && !empty($tmp[0]['k_kundennummer']))
				{
					$this->KndNr = (int)$tmp[0]['k_kundennummer'];
				}
				$_SESSION['kunde'] = $this->KndNr;
				return $this->KndNr;
			}
			catch(PDOExcaption $e)
			{
				echo $e->getMessage();
			}
		}
	}
	
	public function setKundenDaten($daten)
	{
		if(!is_array($daten)) return false; 
		$erg = true;
		foreach($daten as $k => $v)
		{
			if(empty($daten[$k]))
			{
				$erg = false;
			}
		}
		if($erg == false)
			return $erg;
		try
		{
			$sql = "INSERT INTO ws_kunden
			        	(k_name, k_vorname, k_plz , k_ort, k_strasse, k_mail, k_passwort, k_kennung)
							VALUES
								(:name, :vorname, :plz, :ort, :strasse, :mail, :passwort, :kennung)";
			$result = $this->dbh->prepare($sql);
			$result->bindParam(':name',$daten['name'],PDO::PARAM_INT, 30);
			$result->bindParam(':vorname',$daten['vorname'],PDO::PARAM_INT, 30);
			$result->bindParam(':plz',$daten['plz'],PDO::PARAM_INT, 6);
			$result->bindParam(':ort',$daten['ort'],PDO::PARAM_INT, 20);
			$result->bindParam(':strasse',$daten['strasse'],PDO::PARAM_INT, 30);
			$result->bindParam(':mail',$daten['mail'],PDO::PARAM_INT, 30);
			$result->bindParam(':passwort',md5($daten['passwort']),PDO::PARAM_INT, 32);
			$result->bindParam(':kennung',$daten['kennung'],PDO::PARAM_INT, 30);
			$result->execute();
			if($result->rowCount() == 1)
			{
				print "Datensatz wurde eingetragen.";
				return true;
			}
			else
				return false;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function getKundennummmer()
	{
		return $this->KndNr;
	}
	#Admin logout
	public function abmelden()
	{
		$this->KndNr = '';
		header("Location: webshop.php");
		session_destroy();
		
	}
}
?>