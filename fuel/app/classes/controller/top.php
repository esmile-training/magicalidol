<?php

class Controller_Top extends Controller_Base_Game
{
	public function action_index()
	{
		$this->view_data['msg'] = true;
		View_Wrap::contents('top', $this->view_data);
	}
	
	public function action_login_exit()
	{
		$this->view_data['msg'] = false;
		View_Wrap::contents('top', $this->view_data);
	}
}
