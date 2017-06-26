<?php

class Model_User extends Model_Basegame
{
	protected static $_table_name = 'user';     // テーブル名がモデル名の複数形なら省略可
	protected static $_primariy = array('id');  // プライマリーキーがidなら省略可
	
	//使用するフィールド名をセット
	protected static $_properties = array(
		'id',
		'name',
		'weaponId'
	);
	
	/*
	 *	リレーション：一対多
	 *	
	 */
	protected static $_has_many = array(
		'uShop'	=>	array(
			'model_to'          => 'Model_Ushop',   // 連結モデル名
			'key_from'          => 'id',            // 連携させる値
			'key_to'            => 'userId',        // 連結する値
			'cascade_save'      => false,           // ターゲットモデルも更新するかどうか
			'cascade_delete'    => false,           // ターゲットモデルも削除するかどうか
		),
	);

}