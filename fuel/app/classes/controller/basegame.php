<?php
class Controller_Basegame extends Controller
{
	public function __construct()
	{
		// BaseGameLibインスタンス化
		$this->Lib = new Lib_Basegame();
		$path = ltrim($_SERVER["REQUEST_URI"], '/');
		var_dump(Config::get('fileCheck'));
		
		// ユーザ認証のないページの判定
		if(in_array($path, (array)Config::get('fileCheck')))
		{
			echo 'ok';
			return false;
		}
	}
}