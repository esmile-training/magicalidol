<?php

class Controller_Top extends Controller_Base_Game
{
	public function action_index()
	{
		View_Wrap::contents('top', $this->view_data);
	}
	
	public function action_login()
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
		
		// SESSIONに格納
		$_SESSION['user_id'] = $this->view_data['user']->id;

		//ビュー表示
		Response::redirect('mypage');
	}
	
	public function action_login_exit()
	{
		$this->view_data['unauth_login'] = false;
		View_Wrap::contents('top', $this->view_data);
	}
}
