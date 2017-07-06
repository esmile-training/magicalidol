<?php
class Controller_Base_Game extends Controller
{
	public $view_data;
	public $user;

	public function __construct()
	{
		//ユーザ認証
		$this->view_data['user'] = $this->user_authentication();
		$this->view_data['user']['developer'] = $this->check_developer($this->view_data['user']); 
		$this->view_data['user']['nowtime'] = $this->set_time($this->view_data['user']['developer'] ); 
		
	}

	private function user_authentication()
	{
		//認証不要コントローラの検出
		Config::load('session');
		if(in_array(CONTROLLERNAME, Config::get('unauth_list.controller')))
		{
			return false;
		}

		//セッションが無ければタイトルに戻す
		session_start();
		if(!isset($_SESSION['user_id']))
		{
			Response::redirect('top');
		}
		//ユーザ確認
		$user = Model_User::find('first', array(
			'where' => array(
				'id' => $_SESSION['user_id']
			)
		));
		if(is_null($user))
		{
			Response::redirect('top');
		}
		return $user;
	}

	private function check_developer($user)
	{
		if(!$user) return false;
		
		//開発者とデバッグ日時の設定
		$developer = Model_Developer::find('first', array(
			'where' => array(
				'user_id' =>$user['id']
			)
		));
		return (is_null($developer))? false : $developer;
	}

	private function set_time($developer)
	{
		return ($developer && !is_null($developer->debug_time))
		? 
			$developer->debug_time
		:
			date(DATE_FORMAT, time())
		;
	}
}

