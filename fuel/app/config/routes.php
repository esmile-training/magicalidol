<?php
/*
 *	rootパスを指定
 */
return array(
	'_root_'  => 'codesample/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
);