<?php

class Controller_Mypage extends Controller_Base_Game
{
	public function action_index()
	{
		View_Wrap::contents('mypage', $this->view_data);
	}
}
