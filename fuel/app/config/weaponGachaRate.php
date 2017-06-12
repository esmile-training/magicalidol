<?php

return array(
	'gachaRate' => array(
		1 => array(
			'name' => '斧',
			'rate' => 40,
		),
		2 => array(
			'name' => '剣',
			'rate' => 30,
		),
		3 => array(
			'name' => '鎌',
			'rate' => 20,
		),
		4 => array(
			'name' => 'ブーメラン',
			'rate' => 10,
		),
	),
	'eventGachRateAx' => array(
		1 => array(
		'name' => '斧',
		'rate' => 100,
		),
		2 => array(
			'name' => '剣',
			'rate' =>0,
		),
		3 => array(
			'name' => '鎌',
			'rate' => 0,
		),
		4 => array(
			'name' => 'ブーメラン',
			'rate' => 0,
		)
	),
	'eventGachaRateSword' => array(
		1 => array(
		'name' => '斧',
		'rate' => 0,
		),
		2 => array(
			'name' => '剣',
			'rate' =>100,
		),
		3 => array(
			'name' => '鎌',
			'rate' => 0,
		),
		4 => array(
			'name' => 'ブーメラン',
			'rate' => 0,
		),
	),
	'eventGachaRateSickle' => array(
		1 => array(
		'name' => '斧',
		'rate' => 0,
		),
		2 => array(
			'name' => '剣',
			'rate' =>0,
		),
		3 => array(
			'name' => '鎌',
			'rate' => 100,
		),
		4 => array(
			'name' => 'ブーメラン',
			'rate' => 0,
		),
	),
	'eventGachaRateBoomerang' => array(
		1 => array(
		'name' => '斧',
		'rate' => 0,
		),
		2 => array(
			'name' => '剣',
			'rate' =>0,
		),
		3 => array(
			'name' => '鎌',
			'rate' => 0,
		),
		4 => array(
			'name' => 'ブーメラン',
			'rate' => 100,
		),
	),
	'weaponGachaMaterial' => array(
		1 => array(
			'gold' => 200,	/** 必要金額 */
			'material' => array(	/** どの素材がいくつ必要か */
				1 => 10,
			),
			'rate' => array(	/** どの素材ができるか */
				1 => 100,
			),
		),
		2 => array(
			'gold' => 500,
			'material' => array(
				1 => 3,
				2 => 6,
			),
			'rate' => array(
				1 => 30,
				2 => 70,
			),
		),
		3 => array(
			'gold' => 800,
			'material' => array(
				1 => 5,
				2 => 7,
				3 => 10,
			),
			'rate' => array(
				1 => 5,
				2 => 25,
				3 => 70,
			),
		),
		4 => array(
			'gold' => 1200,
			'material' => array(
				3 => 10,
				4 => 15,
			),
			'rate' => array(
				3 => 33,
				4 => 67,
			),
		),
		5 => array(
			'gold' => 1500,
			'material' => array(
				2 => 15,
				4 => 10,
				5 => 8,
			),
			'rate' => array(
				2 => 10,
				4 => 40,
				5 => 50,
			),
		),
		6 => array(
			'gold' => 2000,
			'material' => array(
				4 => 3,
				5 => 2,
				6 => 6,
			),
			'rate' => array(
				4 => 35,
				5 => 40,
				6 => 25,
			),
		),
	),
);