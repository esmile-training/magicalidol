<?php

class Controller_Mypage extends Controller_Base_Game
{
	public function action_index()
	{
		// データベース接続・処理
		$user_data = Model_User::find('first', array(
			'where' => array(
				'id' => $_SESSION['id']
			)
		));
		
		// 連想配列化
		$this->view_data['user'] = ['id' => $user_data['id'], 'name' => $user_data['name']];
		
		View_Wrap::contents('mypage', $this->view_data);
	}
}
