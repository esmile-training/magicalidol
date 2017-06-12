<?php
class Controller_Option extends Lib_Contents
{
	public function action_index()
	{
		//戦闘速度の値
		$this->viewData['battleSpeed'] = array(0.5,1.0,1.5,2.0);
		
		//現在の倍率を取得
		$this->viewData['nowSpeed'] = 1/$this->userData['battleSpeed'];
		
		View_Wrap::contents('option/option', $this->viewData);
	}
	
	/**
		名前を変更する
	*/
	public function action_namechange()
	{
		//入力データの受け取り
		$newName = Input::post('aftername');
		
		//初期設定
		$ModelUser = new Model_User($this->userData);
		
		if(!empty($newName))
		{
			$ModelUser->changeName($this->userData['id'],$newName);
		}
		
		Response::redirect(CONTENTS_URL.'option');
	}
	
	/**
		戦闘速度を変更する
	*/
	public function action_speedchange()
	{
		//入力データの受け取り
		$newSpeed = Input::post();
		
		//初期設定
		$ModelUser = new Model_User($this->userData);
		
		if(!empty($newSpeed['changeSpeed']))
		{
			Log::debug('pass change');
			$speed = 1/$newSpeed['changeSpeed'];
			Log::debug('newSpeed : '.$newSpeed['changeSpeed'].'(speed : '.$speed.')');
			$ModelUser->changeBattleSpeed($speed,$this->userData['id']);
		}
		
		Response::redirect(CONTENTS_URL.'option');
	}
}
