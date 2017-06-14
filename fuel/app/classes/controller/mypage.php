<?php
use \Model\User;

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

		$shop_data = User::find('first',  array(
			'where' => array(
				array('id', 1)
			)
		));
		
		var_dump($shop_data);exit;
		
		
		// ヘッダーフッター付きのページを表示
		View_Wrap::admin('mypage', $this->viewData);
	}
}
