<?php

class Controller_Top extends Controller_Base_Game
{
	public function action_index($error_code = null)
	{
		\config::load('error');
		$this->view_data['error_msg'] = ($error_code)? config::get('msg.'.$error_code) : false;

		View_Wrap::contents('top', $this->view_data);
	}
	
	public function action_login()
	{
		$param = input::post();

		//ユーザデータ取得
		$this->view_data['user'] = Model_User::find('first', array(
			'where' => array(
				'name' => $param['name'],
				'password' => $param['password'],
			)
		));

		if(is_null($this->view_data['user'])){
			Response::redirect('top/index/1');
		}

		// SESSIONに格納
		session_start();
		$_SESSION['user_id'] = $this->view_data['user']->id;

		//ビュー表示
		Response::redirect('mypage');
	}
}
