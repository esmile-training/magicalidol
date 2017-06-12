<?php
//森林ステージの情報
return array(
	'enemy' => array(	//出現する敵の番号一覧
		0 => array( //各ステージ共通敵
			array(
				'enemyNum' => 101,	//敵番号
				'rate' => 50,	//出現確率
			),
			array(
				'enemyNum' => 102,
				'rate' => 50,
			),
			array(
				'enemyNum' => 103,
				'rate' => 50,
			),
		),
		1 => array( //ステージ1専用敵
		),
	),
	//'boss' => 104,	//ボスの番号
	'boss' => array(
					'1'=>'',
					'2'=>'',
					'3'=>'',
					'4'=>'',
					'5'=>'104',
	),
	'stage' => array(		//ランクごとの全ステージ配列
		'1' => array(
			'name' => '林道',	//ステージ名称
			'fee' => 0,		//そのステージに挑戦するのに必要な金額
			'startDirection' => 0,	//ダンジョンに入ったときの方位
			'event' => array(	//イベントの確率
				'none' => 70,	//何も起きない
				'drop' => 5,	//アイテムドロップ
				'encount' => 25,	//敵が出現
			),
			'goal' => array(	//ステージクリア報酬一覧
				array(	//素材アイテム「木」、presentDBにINSERTするための情報を書く
					'rate' => 80,	//報酬の出現レート
					'category' => 2,	//アイテムカテゴリ(config/itemを参照)
					'id' => 1,	//カテゴリごとのid(各カテゴリのcsvファイルを参照)
					'char' => '',	//charId、素材アイテムのため空を入れる
					'value' => 0,	//素材アイテムのため、空を入れる
					'countMin' => 1,	//最低数
					'countMax' => 4,	//最大数
				),
				array(	//お金
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 100,	//ランダムで固定値を出したい場合は
					'countMax' => 100,	//最低値と最大値に同じ数値を入れる
				),
			),
			'drop' => array(	//森林の第1ステージでドロップするアイテム一覧の配列
				array(	//素材アイテム「木」をドロップ、presentDBにINSERTするための情報を書く
					'rate' => 80,	//ドロップレート
					'category' => 2,	//アイテムカテゴリ(config/itemを参照)
					'id' => 1,	//カテゴリごとのid(各カテゴリのcsvファイルを参照)
					'char' => '',	//charId、素材アイテムのため空を入れる
					'value' => 0,	//素材アイテムのため、空を入れる
					'countMin' => 1,	//最低数
					'countMax' => 4,	//最大数
				),
				array(	//お金をドロップ
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 10,
					'countMax' => 20,
				),
			),
		),
		'2' => array(
			'name' => '薄暗い山道',
			'fee' => 20,
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
					'id' => 1,
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
					'countMin' => 100,
					'countMax' => 120,
				),
			),
			'drop' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 1,
					'char' => '',
					'value' => 0,
					'countMin' => 1,
					'countMax' => 3,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 20,
					'countMax' => 30,
				),
			),
		),
		'3' => array(
			'name' => '葉が生い茂る森',
			'fee' => 30,
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
					'id' => 1,
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
					'countMax' => 140,
				),
			),
			'drop' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 1,
					'char' => '',
					'value' => 0,
					'countMin' => 1,
					'countMax' => 3,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 30,
					'countMax' => 40,
				),
			),
		),
		'4' => array(
			'name' => '樹海',
			'fee' => 40,
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
					'id' => 1,
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
					'countMin' => 140,
					'countMax' => 160,
				),
			),
			'drop' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 1,
					'char' => '',
					'value' => 0,
					'countMin' => 1,
					'countMax' => 3,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 40,
					'countMax' => 50,
				),
			),
		),
		'5' => array(
			'name' => '旧古代林',
			'fee' => 50,
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
					'id' => 1,
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
					'countMin' => 160,
					'countMax' => 180,
				),
			),
			'drop' => array(
				array(
					'rate' => 80,
					'category' => 2,
					'id' => 1,
					'char' => '',
					'value' => 0,
					'countMin' => 1,
					'countMax' => 2,
				),
				array(
					'rate' => 20,
					'category' => 1,
					'id' => 0,
					'char' => '',
					'value' => 0,
					'countMin' => 50,
					'countMax' => 60,
				),
			),
		),
	),
);
