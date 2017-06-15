<?php

class Model_User extends Orm\Model
{
	public $userData;
	
	//使用するフィールド名をセット
	protected static $_properties = array(
	'id',
	'name',
	);
	//テーブル名がモデル名の複数形なら省略可
	protected static $_table_name = 'user';
	//プライマリーキーがidなら省略可
	protected static $_primariy = array('id');

}