<?php

class Controller_Mypage extends Controller_Base_Game
{
	public function action_index()
	{
		View_Wrap::contents('mypage', $this->view_data);
	}
	
	public function action_user_login()
	{
		$param = input::get();
		
		//ユーザデータ取得
		$this->view_data['user'] = Model_User::find('first', array(
			'where' => array(
				'id' => $param['user_id']
			)
		));
		
		if(is_null($this->view_data['user'])){
			Response::redirect('top/login_exit');
		}
		//ビュー表示
		return View_Wrap::contents('mypage', $this->view_data);
	}
}
