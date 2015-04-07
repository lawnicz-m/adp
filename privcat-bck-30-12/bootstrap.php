<?php

require_once 'config.php';
include '../config.php';

require_once 'lib/gloowa/Autoloader.php';
Autoloader::registerBasePath('lib');
Autoloader::registerBasePath('application/controllers');
Autoloader::registerBasePath('application/models');
Autoloader::registerBasePath('application/lib');

spl_autoload_register(array ('Autoloader', 'autoload'));


require_once 'lib/redbean/rb.php';
R::setup(DB_TYPE.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASS);
R::debug(FALSE);

if(isset($_GET['nuke']) &&  $_GET['nuke'] == 'gloowa178') {
	//R::nuke();
}

