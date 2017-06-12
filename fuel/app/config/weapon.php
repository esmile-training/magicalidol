<?php

return array(
	'category' => array(
		'0' => '全て',
		'1' => '斧',
		'2' => '剣',
		'3' => '鎌',
		'4' => 'ブーメラン',
		'e' => 'イベント武器',
	),
	
	'sortType' => array(
		0 => '種類順',
		1 => '攻撃力が高い順',
		2 => '攻撃力が低い順',
	),
	
	'baseStatus' => array(
		1 => 10,
		2 => 40,
		3 => 70,
		4 => 100,
		5 => 130,
		6 => 160,
	),
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
	'weaponGacha' => array(
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