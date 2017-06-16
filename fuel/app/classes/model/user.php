<?php

class Model_User extends Model_Basegame
{
	protected static $_table_name = 'user';		//テーブル名がモデル名の複数形なら省略可
	protected static $_primariy = array('id');	//プライマリーキーがidなら省略可
	
	//使用するフィールド名をセット
	protected static $_properties = array(
		'id',
		'name',
	);
	
	/**********************************
	* リレーション：一対多
	*/
	protected static $_has_many = array(
		'uShop' => array(
			'model_to' => 'Model_UShop',
			'key_from' => 'id',
			'key_to' => 'userId',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

}