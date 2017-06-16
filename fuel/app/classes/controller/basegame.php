<?php
class Controller_Basegame extends Controller
{
	public $viewData;
	
	public function __construct()
	{
		// BaseGameLibインスタンス化
		$this->Lib = new Lib_Basegame();
		
		// 現在のディレクトリ名を取得し、configのディレクトリ名を取得
		$path = ltrim($_SERVER['REQUEST_URI'], '/');
		$file = Config::load('fileCheck');

		// ユーザ認証のないページの判定
		if(in_array($path, $file))
		{
			echo '以後の処理を無効化';
			return false;
		}
		
		/*
		// 仮置き
		$userId = 1234;

		// ユーザー情報取得
		$userModel = new Model_User();
		$commonData['user'] =  $userModel->getById($userId);
		
		$this->Model->user = $commonData['user'];
		
		// 汎用変数セット
		foreach( $commonData as $key => $val )
		{
			$this->viewData[$key] = $this->$key = $val;   
		}
		*/
	}
}