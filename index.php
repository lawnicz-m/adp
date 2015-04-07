<?php

include 'config.php';

session_start();

error_reporting(E_STRICT|E_ALL);

// Application configuration
//----------------------------------------------------------------------------------------------

// Dingo Location
$system = 'system';

// Application Location
$application = 'application';

// Config Directory Location (in relation to application location)
$config = 'config';

// Allowed Characters in URL
$allowed_chars = '/^[ \!\,\~\&\.\:\+\@\-_a-zA-Z0-9]+$/';



// End of configuration
//----------------------------------------------------------------------------------------------
define('DINGO',1);
require_once("$system/core/DingoBoot.php");
bootstrap::run();