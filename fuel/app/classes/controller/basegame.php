<?php
class Controller_Basegame extends Controller
{
	public $viewData;
	
	public function __construct()
	{
		// BaseGameLibインスタンス化
		$this->Lib = new Lib_Basegame();
		
		// 現在のディレクトリ名を取得し、configのディレクトリ名を取得
		$path = ltrim($_SERVER['REQUEST_URI'], '/magicalidol');
		$file = Config::load('fileCheck');

		// ユーザ認証のないページの判定
		if(in_array($path, $file))
		{
			return false;
		}
		
		
	}
}