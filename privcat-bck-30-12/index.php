<?php

require_once 'bootstrap.php';


if(DEBUG || TESTING) {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	

// 	session_start();
	
// 	$_SESSION['id'] = 1;
// 	$_SESSION['login'] = 1;
// 	$_SESSION['typ'] = 'admin';
// 	$_SESSION['haslo'] = 1;
}

if(DEBUG) {
	$queryLogger = RedBean_Plugin_QueryLogger::getInstanceAndAttach(
			R::getDatabaseAdapter()
	);
}

if(TESTING) {
}

R::freeze();

$frontController = new FrontController();
$frontController->dispatch();

if(DEBUG) {
	echo '<pre>';
	foreach($queryLogger->getLogs() as $log) {
		echo $log . "\n";
	}
	echo '</pre>';
}