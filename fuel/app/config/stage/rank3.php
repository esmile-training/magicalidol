<?php
//お城ステージの情報
return array(	//各項目詳細はrank1.phpを参照のこと
	'enemy' => array(
		0 => array(
			array(
				'enemyNum' => 301,
				'rate' => 40,
			),
			array(
				'enemyNum' => 302,
				'rate' => 30,
			),
			array(
				'enemyNum' => 303,
				'rate' => 30,
			),
		),
	),
	//'boss' => 304,
	'boss' => array(
					'1'=>'',
					'2'=>'',
					'3'=>'',
					'4'=>'',
					'5'=>'304',
	),
	'stage' => array(
		'1' => array(
			'name' => '巨大な門',
			'fee' => 170,
			'startDirection' => 0,
			'event' => array(
				'none' => 70,
				'drop' => 5,
				'encount' => 25,
			),
			'goal' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 3,
					'countMax' => 6,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 300,
					'countMax' => 300,
				),
			),
			'drop' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 2,
					'countMax' => 5,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 110,
					'countMax' => 120,
				),
			),
		),
		'2' => array(
			'name' => '長い回廊',
			'fee' => 190,
			'startDirection' => 1,
			'event' => array(
				'none' => 70,
				'drop' => 5,
				'encount' => 25,
			),
			'goal' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 2,
					'countMax' => 5,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 300,
					'countMax' => 320,
				),
			),
			'drop' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 1,
					'countMax' => 4,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 120,
					'countMax' => 130,
				),
			),
		),
		'3' => array(
			'name' => 'ダンスホール',
			'fee' => 210,
			'startDirection' => 3,
			'event' => array(
				'none' => 70,
				'drop' => 5,
				'encount' => 25,
			),
			'goal' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 2,
					'countMax' => 4,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 320,
					'countMax' => 340,
				),
			),
			'drop' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 1,
					'countMax' => 4,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 130,
					'countMax' => 140,
				),
			),
		),
		'4' => array(
			'name' => '謁見の間',
			'fee' => 230,
			'startDirection' => 0,
			'event' => array(
				'none' => 70,
				'drop' => 5,
				'encount' => 25,
			),
			'goal' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 3,
					'countMax' => 5,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 340,
					'countMax' => 360,
				),
			),
			'drop' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 4,
					'countMax' => 5,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 140,
					'countMax' => 150,
				),
			),
		),
		'5' => array(
			'name' => '城の主の部屋',
			'fee' => 250,
			'startDirection' => 0,
			'event' => array(
				'none' => 70,
				'drop' => 5,
				'encount' => 25,
			),
			'goal' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 3,
					'countMax' => 10,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 360,
					'countMax' => 380,
				),
			),
			'drop' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 3,
					'countMax' => 6,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 150,
					'countMax' => 160,
				),
			),
		),
	),
);
