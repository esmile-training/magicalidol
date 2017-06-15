<?php

class Controller_Mypage extends Controller_Basegame
{
	public function action_index()
	{
		// インスタンス化
		$this->viewData['libData'] = $this->Lib->exec();
		/*
		$modelUser = $this->Model->newIns('User');
		$this->viewData['modelData'] = $modelUser->getData('id');
		*/

		//データの整理
		$data=array(
		'id'=>2,
		'name'=>'user2'
		);
		//モデルのインスタンス化
		$new=Model_User::forge($data);
		//データの保存
		$new->save();
		
		// ヘッダーフッター付きのページを表示
		View_Wrap::admin('mypage', $this->viewData);
	}
}
