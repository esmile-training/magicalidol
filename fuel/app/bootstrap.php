<?php

// Load in the Autoloader
require COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php';
class_alias('Fuel\\Core\\Autoloader', 'Autoloader');

// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';


Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
));

// Register the autoloader
Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : Fuel::DEVELOPMENT);

// Initialize the framework with the config file.
Fuel::init('config.php');
//URL定数
$script_path_array = explode('/', $_SERVER["REQUEST_URI"]);
define('ENVIRONMENT', $script_path_array[1]);
define('INDIVIDUALL', $script_path_array[2]);
define('CONTROLLERNAME', $script_path_array[3]);
define('DOMAIN_URL', 'http://'.$_SERVER['SERVER_NAME'].'/');
define('CONTENTS_URL', 'http://'.$_SERVER['SERVER_NAME'].'/'.ENVIRONMENT.'/'.INDIVIDUALL.'/');	//URL
define('ADMIN_URL', CONTENTS_URL.'admin/');
define('IMG_URL', CONTENTS_URL.'public/assets/img/');

//その他定数
define('DATE_FORMAT', 'Y-m-d H:i:s');