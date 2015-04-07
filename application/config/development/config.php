<?php if(!defined('DINGO')){die('External Access to File Denied');}

/**
 * Dingo Framework Basic Configuration File
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 */

define('MYSQL_DEBUG', 0);
define('LICZBA_KLIENTOW_NA_STRONE', 2);

// Version
define('VERSION', time());

// E-mail
define('BASE_MAIL', 'anixa.pl@gmail.com');

// Application's Base URL
define('BASE_URL','http://localhost:8888/h/');

// Does Application Use Mod_Rewrite URLs?
define('MOD_REWRITE',FALSE);

// Turn Debugging On?
define('DEBUG',TRUE);

// Turn Error Logging On?
define('ERROR_LOGGING',TRUE);

// Error Log File Location
define('ERROR_LOG_FILE','log.txt');


/**
 * Your Application's Default Timezone
 * Syntax for your local timezone can be found at
 * http://www.php.net/timezones
 */
date_default_timezone_set('Europe/Warsaw');


/* Database Settings */
config::set('db',array(
	'driver'=>'mysql',          // Driver
	'host'=>'localhost',        // Host
	'username'=>'root',         // Username
	'password'=>'2kontoerge2a', // Password
	'database'=>'cons_art_crm'  // Database
));


/* Auto Load Libraries */
config::set('autoload_libraries',array('db', 'session', 'acl'));

/* Auto Load Helpers */
config::set('autoload_helpers',array('acl', 'url', 'base', 'anixa_texts', 'anixa_validate', 'forms', 'email', 'pagination'));


/* Sessions */
config::set('session',array(
	'table'=>'sesje',
	'cookie'=>array('path'=>'/','expire'=>'+1 months')
));

/* Notes */
config::set('notes',array('path'=>'/','expire'=>'+5 minutes'));


/* Application Folder Locations */
config::set('folder_views','views');             // Views
config::set('folder_controllers','controllers'); // Controllers
config::set('folder_models','models');           // Models
config::set('folder_helpers','helpers');         // Helpers
config::set('folder_structures','structures');   // Structures
config::set('folder_plugins','plugins');         // Plugins
config::set('folder_cache','cache');             // Cache
config::set('folder_languages','languages');     // Languages
config::set('folder_errors','errors');           // Errors