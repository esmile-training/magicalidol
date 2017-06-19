<?php

class Model_Ushop extends Model_Basegame
{
	protected static $_table_name = 'uShop';	//テーブル名がモデル名の複数形なら省略可
	protected static $_primariy = array('id');	//プライマリーキーがidなら省略可
	
	//使用するフィールド名をセット
	protected static $_properties = array(
		'id',
		'userId',
		'productName',
	);
	
	protected static $_has_many = array(
        // リレーションの関係性を示す名前を指定
        'user' => array(
            'model_to' => 'Model_User',
            'key_from' => 'userId',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
}