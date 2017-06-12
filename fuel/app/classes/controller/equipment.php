<?php
class Controller_Equipment extends Lib_Contents
{
	public function action_index()
	{
		$dungeon = Session::get('dungeon');
		$data = Input::post();
		if(empty($dungeon) && !empty($data['dungeon']))
		{
			$dungeon = Session::set('dungeon',$data['dungeon']);
		}
		View_Wrap::contents('equipment/index', $this->viewData);
	}
	
	public function action_submit()
	{
		$dungeon = Session::get('dungeon');
		if(!empty($dungeon))
		{
			Session::delete('dungeon');
			Response::redirect(CONTENTS_URL.'stage/mainPage');
		}
		else
			Response::redirect(CONTENTS_URL.'mypage');
	}
}
