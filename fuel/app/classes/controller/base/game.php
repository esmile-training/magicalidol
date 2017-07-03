<?php
class Controller_Base_Game extends Controller
{
	public $view_data;

	public function __construct()
	{
		session_start();
		Config::load('session');
		$unauth_controller_list = Config::get('unauth_list.controller');
		
		if(!in_array(CONTROLLERNAME, $unauth_controller_list))
		{
			if(!isset($_SESSION['id']))
			{
				Response::redirect('top');
			}
		}
	}
}

