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

}