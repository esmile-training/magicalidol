<?php

class Controller_test extends Lib_Contents {
	
	public function action_index($page = 0) {
		
		//プレゼント取得
		// $ModelPresent = new Model_PresentTest();
		// $this->viewData['userPresent'] = $ModelPresent->getPresentByUserId($this->userData['id']);
		
		$ModelAvatar = new Model_Avatar();
		$this->viewData['equipAvatar'] = $ModelAvatar->getMargeDataByUserId($this->userData['id'], null, 1);
		
		$ModelBattle = new Model_Battle();
		$isBattle = $ModelBattle->isBattle($this->userData['id']);
		$this->viewData['isBattle'] = $isBattle;
		
		$wordsList = array(
							'normal' => '通常',
							'cat' => 'ぬこ',
							'sister' => '妹',
							'queen' => '女王様',
						);
		$this->viewData['wordsList'] = $wordsList;
		
		$this->viewData['URI'] = $_SERVER["REQUEST_URI"];
		$this->viewData['URI2'] = '/'.ENVIRONMENT.'/battle';
		
		View_Wrap::contents('test/top', $this->viewData);
	}
	
	public function action_start()
	{
		$ModelBattle = new Model_Battle();
		if(!$ModelBattle->isBattle($this->userData['id']))
		{
			$ModelBattle->startBattle($this->userData['id'], $this->userData['hp'], 16);
		}
		
		Response::redirect(CONTENTS_URL.'test');
	}
	public function action_end()
	{
		$ModelBattle = new Model_Battle();
		
		$ModelBattle->endBattle($this->userData['id']);
		
		Response::redirect(CONTENTS_URL.'test');
	}
}
