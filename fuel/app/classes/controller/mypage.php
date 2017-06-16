<?php

class Controller_Mypage extends Controller_Basegame
{
	public function action_index()
	{
		// ライブラリをインスタンス化
		$this->viewData['libData'] = $this->Lib->exec();
		

		//データの整理
		$data=array(
			'name'=>'user3'
		);
		
		
		//モデルのインスタンス化(insert)
		//$new=Model_User::forge($data)->save();
		
		
		//
		$select=DB::query('SELECT * FROM `user` WHERE `name` = "user3"')->as_object('Model_User')->execute();
		foreach($select as $key => $val){
		    echo $val['id'] . '<br>';
		}
		
		// ヘッダーフッター付きのページを表示
		View_Wrap::admin('mypage', $this->viewData);
	}
	
	public function action_Sql()
	{
		
	}
}
