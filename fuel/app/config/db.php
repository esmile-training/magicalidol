<?php
/**
 * Base Database Config.
 *
 * See the individual environment DB configs for specific config information.
 */
return array(
	

	'active' => 'default',

	/**
	 * Base config, just need to set the DSN, username and password in env. config.
	 */
	'default' => array(
	    'type'           => 'mysqli',
	    'connection'     => array(
	        'hostname'       => 'mysql300.db.sakura.ne.jp',
	        'port'           => '3306',
	        'database'       => 'esmile-sys_magicalidol',
	        'username'       => 'esmile-sys',
	        'password'       => 'esmile00',
	        'persistent'     => false,
	        'compress'       => false,
	    ),
	    'identifier'   => '`',
	    'table_prefix'   => '',
	    'charset'        => 'utf8',
	    'enable_cache'   => true,
	    'profiling'      => false,
		'readonly'       => false,
	),

	'admin' => array(
	    'type'           => 'mysqli',
	    'connection'     => array(
	        'hostname'       => 'mysql300.db.sakura.ne.jp',
	        'port'           => '3306',
	        'database'       => 'esmile-sys_magicalidol',
	        'username'       => 'esmile-sys',
	        'password'       => 'esmile00',
	        'persistent'     => false,
	        'compress'       => false,
	    ),
	    'identifier'   => '`',
	    'table_prefix'   => '',
	    'charset'        => 'utf8',
	    'enable_cache'   => true,
	    'profiling'      => false,
		'readonly'       => false,
	),

	'redis' => array(
		'type'           => 'mysqli',
		'table_prefix'   => '',
		'default' => array(
			'hostname'  => '192.168.33.10',
			'port'      => 6379,
			'timeout'	=> null,
		)
	),

);
