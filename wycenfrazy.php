<?php	
	require_once 'config.php';
	
	define('DEBUG_WYCEN', false);
	
	function debug($variable) {
		if(DEBUG_WYCEN) {
			echo '<pre>';
			var_dump($variable);
			echo '</pre>';
		}
	}
	
	$od = $_GET['od'];
	$do = $_GET['do'];
	$id_klienta = $_GET['id_klienta'];
	
	$begin = new DateTime( $od );
	$end = new DateTime( $do );
	$end->add(new DateInterval('P1D'));
	
	$interval = DateInterval::createFromDateString('1 day');
	$period = new DatePeriod($begin, $interval, $end);
	
	$dblink = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
	mysql_selectdb(DB_NAME, $dblink);
	
	$query = 'SELECT * FROM klienci WHERE id_klienta = ' . $id_klienta;
	
	$result = mysql_query($query, $dblink);
	$klient = mysql_fetch_assoc($result);
	
	$top10_1_od = (int)$klient['top_10_1_od'];
	$top10_1_do = (int)$klient['top_10_1_do'];
	$top10_2_od = (int)$klient['top_10_2_od'];
	$top10_2_do = (int)$klient['top_10_2_do'];
	$top10_3_od = (int)$klient['top_10_3_od'];
	$top10_3_do = (int)$klient['top_10_3_do'];
	
	$query = 'SELECT * FROM frazy WHERE id_klienta = ' . $id_klienta;
	
	$result = mysql_query($query, $dblink);
	$frazy = array();
	
	while ($row = mysql_fetch_assoc($result)) {
		$frazy[] = $row;
	}
	
	$kwota_top10 = (float)0;
	$kwota_ryczaltu = (float)0;
	
	$dodajRyczalt = false;
	
	foreach ( $period as $dt ) {
		$data = $dt->format( "Y-m-d" );
		$dniWMiesiacu = (float)$dt->format( "t" );
		$kwota_ryczaltu += (float)$klient['kwota_ryczaltu'] / (float)$dniWMiesiacu;
	
		debug($data);
// 		debug($dniWMiesiacu);
		debug($kwota_ryczaltu);
		debug($kwota_top10);
		
		foreach($frazy as $fraza) {
			if($fraza['typ'] == 2) { // ryczalt;
				$dodajRyczalt = true; // skoro jest przynajmniej
				// jedna fraza ryczałtowa to chcemy naliczyc ryczalt
				continue;
			}
			
// 			debug($fraza);
				
			$top10_1_kwota = (float)$fraza['top10_1_kwota'];
			$top10_2_kwota = (float)$fraza['top10_2_kwota'];
			$top10_3_kwota = (float)$fraza['top10_3_kwota'];
	
			if($fraza['top10_procentowo']) {
				$top10_1_kwota *= ($fraza['kwota_za_fraze'] / 100.0);
				$top10_2_kwota *= ($fraza['kwota_za_fraze'] / 100.0);
				$top10_3_kwota *= ($fraza['kwota_za_fraze'] / 100.0);
			}
				
			$query =	'SELECT * FROM frazy_wyniki '.
					'WHERE id_frazy = ' . $fraza['id_frazy'] .
					' AND data = \''.$data.'\'';
	
			$result = mysql_query($query, $dblink);
	
			if(!$result) {
				continue;
			}

			debug($fraza['nazwa']);
			
			while ($row = mysql_fetch_assoc($result)) {
				$wynik = (int)$row['wynik'];
				
				debug($row);
					
				$intFraza1Strona = (int)$fraza['top10_pierwsza_strona'];
				$intWynik1Strona = (int)$row['pierwsza_strona'];
					
				$naPierwszejStronie = false;
					
				if($intFraza1Strona == 1 && $intWynik1Strona == 1) {
					$naPierwszejStronie = true;
				}
				
				debug($naPierwszejStronie);
					
				$kwota_czastkowa = 0.0;
				if($wynik >= $top10_1_od && $wynik <= $top10_1_do) {
					$kwota_czastkowa = (float)$top10_1_kwota / (float)$dniWMiesiacu;
				} elseif($wynik >= $top10_2_od && $wynik <= $top10_2_do) {
					$kwota_czastkowa = (float)$top10_2_kwota / (float)$dniWMiesiacu;
				} elseif($wynik >= $top10_3_od && $wynik <= $top10_3_do) {
					$kwota_czastkowa = (float)$top10_3_kwota / (float)$dniWMiesiacu;
				} elseif($naPierwszejStronie) {
					$kwota_czastkowa = (float)$top10_3_kwota / (float)$dniWMiesiacu;
				}
					
				$kwota_top10 += $kwota_czastkowa;
			}
		}
	}
	
	mysql_close($dblink);
	
	$razem = $kwota_top10 + ($dodajRyczalt ? $kwota_ryczaltu : 0.0);
	
	echo round($razem, 2);
	
?>