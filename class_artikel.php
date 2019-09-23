<?php 
require_once("class_seite.php");

class artikel extends seite
{
	protected $artikelArray = array();
	private $DB = array('database' =>'ws_webshop',
											'host'     =>'localhost',
											'user'     =>'root',
											'password' =>'');
	protected $dbh;
	
	public function __construct()
	{
		parent::__construct();
		if(!is_array($this->DB) && empty($this->DB['database']))
			throw new Exception("Daten für Datenbankverbindung fehlen!");
		else
		{
			$connectString = "mysql:dbname=". $this->DB['database'].
											 ";host=". $this->DB['host'];
			try
			{
				$this->dbh = new PDO($connectString,$this->DB['user'],$this->DB['password']);
				$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT 
				       		a_artikelnr,
									a_name as a_veranstalltung,
									a_menge as a_kartenvorrat,
									a_preis,
									DATE_FORMAT(a_datum ,'%d - %m - %Y') as a_konzerttermin 
							  FROM 
									ws_artikel
								WHERE
									a_menge > 0";
				$result = $this->dbh->query($sql);
				$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
				
				foreach($tmp as $key => $value)
				{
					foreach($value as $key2 => $value2)
					{
						$name = explode("_",$key2);
						if($key2 != 'a_artikelnr')
							$this->artikelArray[$value['a_artikelnr']][$name[1]] = $value2;
					}
				}
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
	}
	
	public function anzeigen()
	{
	 $sql = "SELECT 
				DATE_FORMAT(a_datum ,'%d. %m. %Y') as a_konzerttermin, 
				a_name as a_veranstaltung,
				a_menge as a_kartenvorrat,
				a_preis ,
				a_artikelnr
			FROM 
				ws_artikel
			WHERE
				a_menge > 0";
		$result = $this->dbh->query($sql);
		$temp = $result->fetchAll(PDO::FETCH_ASSOC);
		$anzahl = 1;
		$tmp = array_keys($temp);
		$padding =  "style=\"padding: 0 5px 0 5px\"";
		
		print "<table>\n";
		print "<tr>\n";	
		/*
		$i = 0;
		foreach($temp[$i] as $k => $v)
		foreach($temp[0] as $k => $v)
		*/
		foreach($temp[$tmp[0]] as $k => $v)
		{
			$x = explode("_",$k);
			if($k != "a_artikelnr")		
			print "<th>". ucwords($x[1]) ."</th>\n";
		}
		print "</tr>\n";
		
		foreach($temp as $key => $value)
		{
			if($anzahl % 2)
			{
				$anzahl++;
				$farbe = "#CCCCCC";
			}
			else
			{
				$anzahl++;
				$farbe = "#FFFFFF";
			}
			
			print "<tr bgcolor=".$farbe.">\n";
			foreach($value as $subKey => $subValue)
			{
				switch ($subKey)
				{
					case 'a_konzerttermin':	
					case 'a_veranstaltung':
						print "<td $padding>".$subValue."</td>";
						break;
					case 'a_kartenvorrat':
						print "<td $padding align=\"center\">".$subValue."</td>";
						break;
					case 'a_preis':
						print "<td $padding>".$subValue." &euro;</td>";
						break;
					case 'a_artikelnr':
						print"<td $padding><a href=\"".$_SERVER['PHP_SELF']."?id=".$subValue."\">In den Warenkorb</a></td>\n";
						break;
					default:
						break;				
				}
			}
			print "</tr>\n";
		}
		print "</table>\n";
	}
	
	public function waehlen($artikelnummer, $kunde)
	{
		if(!empty($artikelnummer) && !empty($kunde))
		{
			try
			{
				$sql = "UPDATE 
									ws_warenkorb
								SET 
									w_menge = w_menge + 1
								WHERE 
									w_artikelnr = :nummer
								AND 
									w_kunde = :kunde";
				$result = $this->dbh->prepare($sql);
				$result->bindParam(':nummer', $artikelnummer, PDO::PARAM_INT);
				$result->bindParam(':kunde',$kunde, PDO::PARAM_INT);
				$result->execute();
				if($result->rowCount() == 1)
				{
					echo "Artikel hinzugefügt";
					return true;
				}
					
				$sql = "INSERT INTO
									ws_warenkorb
										(w_artikelnr, w_kunde, w_menge)
								VALUES
										(:nummer, :kunde, 1)";
				$result = $this->dbh->prepare($sql);
				$result->bindParam(':nummer', $artikelnummer, PDO::PARAM_INT);
				$result->bindParam(':kunde',$kunde,PDO::PARAM_INT);
				$result->execute();
				if($result->rowCount() == 1)
				{
					echo "Datensatz wurde eingetragen";
					return true;	
				}
				return false;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
	}
	
	public function bestellen($kunde)
	{
		$error = false;
		if(!is_int($kunde))
		{
			throw new Exception('Keine Kundennummer');
		}
		else
		{
			try
			{
				#in Datenbank schreiben
				$sql = "SELECT w_kunde, w_artikelnr, w_menge
								FROM   
									ws_warenkorb
								WHERE
									w_kunde = :kunde";
				$result = $this->dbh->prepare($sql);
				$result->bindParam(':kunde', $kunde, PDO::PARAM_INT);
				$result->execute();
				$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
				
				foreach($tmp as $key => $value)
				{
					$sql = "INSERT INTO ws_bestellung
					        	(b_kunde, b_artikelnr, b_menge)
									VALUES
										(:kunde, :artikel, :menge)";
					$result = $this->dbh->prepare($sql);
					$result->execute( array(':kunde' => (int)$value['w_kunde'],
																	':artikel' => (int)$value['w_artikelnr'],
																	':menge' => (int)$value['w_menge']));
					if($result->rowCount() == 1) 
					{
						$sql1 = "UPDATE ws_artikel
						        SET
											a_menge = a_menge - :anzahl
										WHERE
											a_artikelnr = :artikel";
						$result1 = $this->dbh->prepare($sql1);
						$result1->bindParam(':anzahl', $value['w_menge'], PDO::PARAM_INT);
						$result1->bindParam(':artikel',$value['w_artikelnr'],PDO::PARAM_INT);
						$result1->execute();
						if($result1->rowCount() == 1)
						{
							$sql2 = "DELETE FROM ws_warenkorb
							         WHERE
											 	w_kunde = :kunde
											 AND
											 	w_artikelnr = :artikel";
							$sth2 = $this->dbh->prepare($sql2);
							$sth2->execute( array(':kunde' => (int)$kunde,
							                      ':artikel' => (int)$value['w_artikelnr']));
						}
						$error = true;
					}
				}
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
		session_destroy();
		return $error;
	}
}
?>