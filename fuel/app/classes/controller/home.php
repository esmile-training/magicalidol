<?php
class Controller_Home extends Controller_Basegame
{
	public function action_index()
	{
		View_Wrap::admin('home/top');
	}
}
