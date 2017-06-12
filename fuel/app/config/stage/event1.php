<?php
//大迷宮バフォメットの情報
return array(
	// 迷宮　敵出現レート
	'enemy' => array(
		// 0F
		0 => array(
		),
		// 1F
		1 => array(
			array(
				'enemyNum' => 'e1011',	//敵番号
				'rate' => 40,	//出現確率
			),
			array(
				'enemyNum' => 'e1021',
				'rate' => 40,
			),
			array(
				'enemyNum' => 'e1031',
				'rate' => 15,
			),
			array(
				'enemyNum' => 'e1041',
				'rate' => 70,
			),
			array(
				'enemyNum' => 'e1051',
				'rate' => 15,
			),
		),
		// 2F
		2 => array(
			array(
				'enemyNum' => 'e1012',	//敵番号
				'rate' => 70,
			),
			array(
				'enemyNum' => 'e1022',
				'rate' => 30,
			),
			array(
				'enemyNum' => 'e1032',
				'rate' => 60,
			),
			array(
				'enemyNum' => 'e1042',
				'rate' => 20,
			),
			array(
				'enemyNum' => 'e1052',
				'rate' => 30,
			),
		),
		// 3F
		3 => array(
			array(
				'enemyNum' => 'e1023',
				'rate' => 30,
			),
			array(
				'enemyNum' => 'e1033',
				'rate' => 60,
			),
			array(
				'enemyNum' => 'e1043',
				'rate' => 20,
			),
			array(
				'enemyNum' => 'e1053',
				'rate' => 30,
			),
		),

		// 4F
		4 => array(
			array(
				'enemyNum' => 'e1014',	//敵番号
				'rate' => 50,
			),
			array(
				'enemyNum' => 'e1024',
				'rate' => 50,
			),
			array(
				'enemyNum' => 'e1034',
				'rate' => 50,
			),
			array(
				'enemyNum' => 'e1044',
				'rate' => 50,
			),
			array(
				'enemyNum' => 'e1054',
				'rate' => 50,
			),
		),
	),
	
	//ボスの番号
	'boss' => array(
					'1'=>'',
					'2'=>'e106',	// 中ボス
					'3'=>'e107',	// 中ボス
					'4'=>'e105',	// ボス
	),
	
	//ランクごとのステージ配列
	'stage' => array(
		// 1F
		'1' => array(
			'name' => '大迷宮バフォメット第一層',	//ステージ名称
			'fee' => 0,					//そのステージに挑戦するのに必要な金額
			'startDirection' => 2,			//ダンジョンに入ったときの方位
			'event' => array(				//イベントの確率
				'none' => 60,				//何も起きない
				'drop' => 5,				//アイテムドロップ
				'encount' => 35,			//敵が出現
			),
			'goal' => array(				//ステージクリア報酬
				array(	//　バフォメットメダル
					'rate' => 80,
					'category' => 2,
					'id' => 101,
					'char' => '',
					'value' => 0,
					'countMin' => 10,
					'countMax' => 25,
				),
				array(	// お金
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 10,
					'countMax' => 100,
				),
			),
			'drop' => array( 				// 道中ドロップ
				array(	// 木
					'rate' => 50,
					'category' => 2,
					'id' => 1,
					'char' => '',
					'value' => 0,
					'countMin' => 4,
					'countMax' => 8,
				),
				array(	// 石
					'rate' => 50,
					'category' => 2,
					'id' => 2,
					'char' => '',
					'value' => 0,
					'countMin' => 4,
					'countMax' => 8,
				),
			),
		),
		// 2F
		'2' => array(
			'name' => '大迷宮バフォメット第二層',	//ステージ名称
			'fee' => 500,					//そのステージに挑戦するのに必要な金額
			'startDirection' => 0,			//ダンジョンに入ったときの方位
			'event' => array(				//イベントの確率
				'none' => 60,				//何も起きない
				'drop' => 5,				//アイテムドロップ
				'encount' => 35,			//敵が出現
			),
			'goal' => array(				//ステージクリア報酬
				array(	//　バフォメットメダル
					'rate' => 80,
					'category' => 2,
					'id' => 101,
					'char' => '',
					'value' => 0,
					'countMin' => 25,
					'countMax' => 45,
				),
				array(	// お金
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 300,
					'countMax' => 500,
				),
			),
			'drop' => array( 				// 道中ドロップ
				array(	// 木
					'rate' => 20,
					'category' => 2,
					'id' => 1,
					'char' => '',
					'value' => 0,
					'countMin' => 4,
					'countMax' => 8,
				),				
				array(	// 素材 石
					'rate' => 40,
					'category' => 2,
					'id' => 2,
					'char' => '',
					'value' => 0,
					'countMin' => 4,
					'countMax' => 8,
				),
				array(	// 素材　鉄
					'rate' => 40,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 4,
					'countMax' => 8,
				),
			),
		),
		// 3F
		'3' => array(
			'name' => '大迷宮バフォメット第三層',	//ステージ名称
			'fee' => 1000,					//そのステージに挑戦するのに必要な金額
			'startDirection' => 2,			//ダンジョンに入ったときの方位
			'event' => array(				//イベントの確率
				'none' => 50,				//何も起きない
				'drop' => 5,				//アイテムドロップ
				'encount' => 45,			//敵が出現
			),
			'goal' => array(				//ステージクリア報酬
				array(	//　バフォメットメダル
					'rate' => 80,
					'category' => 2,
					'id' => 101,
					'char' => '',
					'value' => 0,
					'countMin' => 75,
					'countMax' => 100,
				),
				array(	// お金
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 700,
					'countMax' => 1000,
				),
			),
			'drop' => array( 				// 道中ドロップ
				array(	// 素材　鉄
					'rate' => 30,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 2,
					'countMax' => 8,
				),				
				array(	// 素材 銅
					'rate' => 40,
					'category' => 2,
					'id' => 4,
					'char' => '',
					'value' => 0,
					'countMin' => 2,
					'countMax' => 8,
				),
				array(	// 素材　銀
					'rate' => 30,
					'category' => 2,
					'id' => 5,
					'char' => '',
					'value' => 0,
					'countMin' => 2,
					'countMax' => 8,
				),
			),
		),
		// 4F
		'4' => array(
			'name' => '大迷宮バフォメット第四層',	//ステージ名称
			'fee' => 10000,					//そのステージに挑戦するのに必要な金額
			'startDirection' => 2,			//ダンジョンに入ったときの方位
			'event' => array(				//イベントの確率
				'none' => 50,				//何も起きない
				'drop' => 5,				//アイテムドロップ
				'encount' => 45,			//敵が出現
			),
			'goal' => array(				//ステージクリア報酬
				array(	//　バフォメットメダル
					'rate' => 100,
					'category' => 2,
					'id' => 101,
					'char' => '',
					'value' => 0,
					'countMin' => 5000,
					'countMax' => 5000,
				),
			),
			'drop' => array( 				// 道中ドロップ
				array(	// 素材　石
					'rate' => 30,
					'category' => 2,
					'id' => 2,
					'char' => '',
					'value' => 0,
					'countMin' => 2,
					'countMax' => 8,
				),				
				array(	// 素材 鉄
					'rate' => 40,
					'category' => 2,
					'id' => 3,
					'char' => '',
					'value' => 0,
					'countMin' => 2,
					'countMax' => 8,
				),
				array(	// 素材　銅
					'rate' => 30,
					'category' => 2,
					'id' => 4,
					'char' => '',
					'value' => 0,
					'countMin' => 2,
					'countMax' => 8,
				),
			),
		),
	),
);
