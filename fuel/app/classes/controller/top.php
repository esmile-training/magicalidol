<?php

class Controller_Top extends Controller_Base_Game
{
	public function action_index()
	{
		View_Wrap::contents('top', $this->view_data);
	}
}