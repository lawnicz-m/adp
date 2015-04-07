<?php




$plik_lokalny='serwery2.php';//tutaj zostanie zapisany plik z drugiego serwera/*
$plik_zdalny='serwery.txt';//stad zostanie pobrany plik
$connect=ftp_connect('onesite.home.pl');//serwer pliku zdalnego
ftp_login($connect,'include','q1w2e3r4');//logujemy sie do serwera
if(!file_exists($plik_lokalny)||ftp_mdtm($connect,$plik_zdalny)>filemtime($plik_lokalny)){//sprawdzamy czy trzeba sciagnac plik, czyli: jesli nie istnieje lub jesli jest starszy niz na drugim serwerze
  
  ftp_get ( $connect, $plik_lokalny, $plik_zdalny, FTP_BINARY );//sciagamy/uaktualniamy plik
}else{

}*/


include_once ('serwery2.php');

$serwery_ip = array();
	
$serwery_ip[] = array('ip' => 'www.google.pl', 'nazwa' => 'Polska');
$serwery_ip[] = array('ip' => 'www.google.com', 'nazwa' => 'USA');
$serwery_ip[] = array('ip' => 'www.google.de', 'nazwa' => 'Niemcy');
$serwery_ip[] = array('ip' => 'www.google.se', 'nazwa' => 'Szwecja');
$serwery_ip[] = array('ip' => '208.117.224.114', 'nazwa' => 'Anglia');						  
						  
?>
