<?php
class Controller_Mypage extends Lib_Contents
{
	public function action_index()
	{
		View_Wrap::contents('mypage/index', $this->viewData);
	}
}
