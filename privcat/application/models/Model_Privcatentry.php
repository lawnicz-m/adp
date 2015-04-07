<?php
class Model_Privcatentry extends Model {

	const FTP = 'ftp';

	protected $columns = array (
			'privcat' => Model::TYPE_RELATION_SIMPLE,
			'privcatcategory' => Model::TYPE_RELATION_SIMPLE,
			'phrase' => Model::TYPE_NORMAL,
			'client' => Model::TYPE_NORMAL,
			'uploaded' => Model::TYPE_BOOLEAN,
			'uploadedon' => Model::TYPE_NORMAL,
			'text' => Model::TYPE_RELATION_SIMPLE,
			'privcathistory' => Model::TYPE_RELATION_SIMPLE,
			'deleted' => Model::TYPE_BOOLEAN 
	);

	public function publish($mode) {
		if ($mode === self::FTP) {
			$this->publishFTP ();
		}
		
		$this->insertPublishedNote();
	}

	public function unpublish($mode) {
		if ($mode === self::FTP) {
			$this->unpublishFTP ();
		}
		
		$this->insertUnpublishedNote();
	}

	public function publishFTP() {
		$content = $this->genereateEntryPHP ();
		
		$privcat = $this->privcat;
		file_put_contents ( 'cache/privcat/tmp_entry', $content );
		
		$category = $this->privcatcategory;
		
		$connection = @ftp_connect ( $privcat->ftpaddress );
		@ftp_login ( $connection, $privcat->ftpuser, $privcat->ftppass );
		
		ftp_chdir ( $connection, "domains/" . $privcat->address . "/public_html" );
		
		$local_file = "cache/privcat/local";
		$server_file = "index.php";
		
		ftp_get ( $connection, $local_file, $server_file, FTP_ASCII );
		
		ftp_mkdir ( $connection, $category->name );
		
		ftp_put ( $connection, $category->name . "/" . $server_file, $local_file, FTP_ASCII );
		
		ftp_chdir ( $connection, $privcat->ftphash );
		
		ftp_mkdir ( $connection, $category->name );
		
		ftp_put ( $connection, $category->name . "/" . $this->client, 'cache/privcat/tmp_entry', FTP_ASCII );
		
		ftp_close ( $connection );
		
		// generujemy ponownie zawartosc katalogu
	 file_get_contents("http://$privcat->address/$category->name/");
		
		$history = $this->insertAddedHistoryRecrod ( $privcat );
		$this->privcathistory = $history;
		R::store ( $this );
	}

	// usun z ftp
	public function unpublishFTP() {
		$content = $this->genereateEntryPHP ();
		
		$privcat = $this->privcat;
		file_put_contents ( 'cache/privcat/tmp_entry', $content );
		
		$category = $this->privcatcategory;
		
		$connection = @ftp_connect ( $privcat->ftpaddress );
		@ftp_login ( $connection, $privcat->ftpuser, $privcat->ftppass );
		// usuwanie wpisu z /hash/kat/id
		ftp_chdir ( $connection, "domains/" . $privcat->address . "/public_html" );
		ftp_chdir ( $connection, $privcat->ftphash );
		ftp_chdir ( $connection, $category->name );
		ftp_delete ( $connection, $this->client );
		// ftp_close ( $connection );  // koniec bo tak szybciej
		// ktos nie dopisal usuwania, ale zrobimy to troche na okolo
ftp_cdup ( $connection );
ftp_cdup ( $connection );
// ftp_chdir ( $connection, "domains/" . $privcat->address . "/public_html" );
		
		$local_file = "cache/privcat/local";
		$server_file = "index.php";
		
		ftp_get ( $connection, $local_file, $server_file, FTP_ASCII );
		
		ftp_chdir($connection, $category->name);
$files = ftp_nlist($connection, ".");
foreach ($files as $file)
{
    ftp_delete($connection, $file);
}    
ftp_cdup ( $connection );
ftp_rmdir  ( $connection, $category->name );
		
		ftp_mkdir ( $connection, $category->name );
	
		ftp_put ( $connection, $category->name . "/" . $server_file, $local_file, FTP_ASCII );		
		
		// zamkniecie polaczenia
		ftp_close ( $connection );
		
		// generujemy ponownie zawartosc katalogu
		file_get_contents("http://$privcat->address/$category->name/");
		
		$this->updateHistoryRecrod ();
		
		$this->privcathistory = null;
		R::store ( $this );
	}

	public function insertAddedHistoryRecrod($privcat) {
		$history = R::dispense ( 'privcathistory' );
		$history->privcatentry = $this;
		$history->datefrom = date ( 'Y-m-d H:i:s' );
		$history->dateto = null;
		$history->phrase = $this->phrase;
		
		$phrase = new Model_Phrase ();
		$phrase->load ( $this->phrase );
		
		$client = new Model_Client ();
		$client->load ( $this->client );
		
		$clientURL = '';
		
		if ($phrase->fraza_link != null) {
			$clientURL = $phrase->fraza_link;
		} else {
			$clientURL = $client->adres_strony;
		}
		
		$history->link = $clientURL;
		$history->privcat = $privcat;
		
		R::store ( $history );
		
		return $history;
	}

	public function updateHistoryRecrod() {
		$history = $this->privcathistory;
		$history->dateto = date ( 'Y-m-d H:i:s' );
		
		R::store ( $history );
	}
	
	
	public function insertPublishedNote() {
		$phrase = new Model_Phrase ();
		$phrase->load ( $this->phrase );
		
		$client = new Model_Client ();
		$client->load ( $this->client );
		
			// koncowka adresu wpisu np strona-pl(.php)
	$urlwpisuphp=str_replace("http://","",$client->adres_strony); 
	$urlwpisuphp=str_replace("https://","",$urlwpisuphp); 
	$urlwpisuphp=str_replace(".","-",$urlwpisuphp);
	$urlwpisuphp=preg_replace('/\/.*/',"",$urlwpisuphp);
		
		$sql='INSERT INTO `klienci_notatki`(`data_utworzenia`, `id_klienta`, `tresc`) VALUES ';

		$date = date('Y-m-d');
		$clientId = $this->client;
		$content = 'PRIVKAT: Dodano frazę '.$phrase->nazwa.' do kategorii '.$this->privcatcategory->name.' na <a href="http://'.$this->privcat->address.'/'.$this->privcatcategory->name.'/'.$urlwpisuphp.'.php" target="_blank">'.$this->privcat->address.'/'.$this->privcatcategory->name.'/'.$urlwpisuphp.'.php</a>';
		
		$sql .= '( \''.$date.'\', '.$clientId.', \''.$content.'\' ) ';
				
		$dbh=new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$result = $dbh->exec($sql);
	}
	
	public function insertUnpublishedNote() {
		$phrase = new Model_Phrase ();
		$phrase->load ( $this->phrase );
		
		$client = new Model_Client ();
		$client->load ( $this->client );
		
			// koncowka adresu wpisu np strona-pl(.php)
	$urlwpisuphp=str_replace("http://","",$client->adres_strony); 
	$urlwpisuphp=str_replace("https://","",$urlwpisuphp); 
	$urlwpisuphp=str_replace(".","-",$urlwpisuphp);
	$urlwpisuphp=preg_replace('/\/.*/',"",$urlwpisuphp);
		
		$sql='INSERT INTO `klienci_notatki`(`data_utworzenia`, `id_klienta`, `tresc`) VALUES ';
		
		$date = date('Y-m-d');
		$clientId = $this->client;
		$content = 'PRIVKAT: Usunięto frazę '.$phrase->nazwa.' z kategorii '.$this->privcatcategory->name.' na <a href="http://'.$this->privcat->address.'/'.$this->privcatcategory->name.'/'.$urlwpisuphp.'.php" target="_blank">'.$this->privcat->address.'/'.$this->privcatcategory->name.'/'.$urlwpisuphp.'.php</a>';
		
		$sql .= '( \''.$date.'\', '.$clientId.', \''.$content.'\' ) ';
		
		$dbh=new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$dbh->exec($sql);
	}

	public function getPhrase() {
		$phrase = new Model_Phrase ();
		$phrase->load ( $this->phrase );
		
		return $phrase;
	}

	public function getHistory() {
		return R::findAll ( 'privcathistory', ' privcatentry_id = ? ', array (
				$this->id 
		) );
	}

	public function genereateEntryPHP() {
		$client = new Model_Client ();
		$client->load ( $this->client );
		
		$phrase = new Model_Phrase ();
		$phrase->load ( $this->phrase );
		
		$clientURL = '';
		
		if ($phrase->fraza_link != null) {
			$clientURL = $phrase->fraza_link;
		} else {
			$clientURL = $client->adres_strony;
		}
		
		$phrase = $phrase->nazwa;
		$text = $this->text->content;
		$name = $client->faktura_nazwa;
		$address = $client->faktura_adres;
		$zip = $client->faktura_kod_pocztowy;
		$city = $client->faktura_miejscowosc;
		$state = 'Województwo';
		$tel = $client->telefon;
		
		if (strpos ( $zip, '0' ) === 0) {
			$state = 'Mazowieckie';
		} else if (strpos ( $zip, '1' ) === 0) {
			$state = 'Warmińsko-Mazurskie';
		} else if (strpos ( $zip, '2' ) === 0) {
			$state = 'Lubelskie';
		} else if (strpos ( $zip, '3' ) === 0) {
			$state = 'Małoposkie';
		} else if (strpos ( $zip, '4' ) === 0) {
			$state = 'Śląskie';
		} else if (strpos ( $zip, '5' ) === 0) {
			$state = 'Dolnośląskie';
		} else if (strpos ( $zip, '6' ) === 0) {
			$state = 'Wielkopolskie';
		} else if (strpos ( $zip, '7' ) === 0) {
			$state = 'Zachodniopomorskie';
		} else if (strpos ( $zip, '8' ) === 0) {
			$state = 'Pomorskie';
		} else if (strpos ( $zip, '9' ) === 0) {
			$state = 'Łódźkie';
		}
		
		// patent zeby wysylalo z http://
		$cleanurl=str_replace("http://","",$clientURL); 
		$cleanurl=str_replace("https://","",$cleanurl); 
		// $cleanurl=preg_replace('/\/.*/',"",$cleanurl);
		
		$itemt='LocalBusiness';
		// tymczasowo itemtype domyslnie LocalBusiness, docelowo LocalBusiness/Organization/MedicalOrganization/Hotel itp
		
		$privklinki='1'; 
		/* na przyszłość: 
		0 - brak linków
		1 - link z frazą + link w adresie adresowy
		2 - tylko link z frazą
		3 - tylko link w adresie
		*/
		$nofollow='0';
		/* na przyszłość: nofollow linków wychodzących z privkata: 
		0 - wszystkie dofollow 
		1 - wszystkie nofollow
		2 - link z fraza dofollow 
		3 - link w danych adresowych dofollow */
		
		// data konca emisji linkow
		$deathline = date('Y-m-d',  strtotime('+666 years')); // tak za 666 lat \m/ od dzis
		
		
		$code = '<?php
	$itemtype="'.$itemt.'";	
	$url="http://' . $cleanurl . '";
	$key="' . $phrase . '";
	$opis="' . addslashes($text) . '";
	$nazwa="' . addslashes($name) . '";
	$adres="' . $address . '";
	$zip="' . $zip . '";
	$miasto="' . $city . '";
	$state="' . $state . '";
	$tel="' . $tel . '";
	$nofol="'.$nofollow.'";
	$linki="'.$privklinki.'";
	$datakonca="'.$deathline.'";
?>';
		
		return $code;
	}

}