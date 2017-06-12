<?php
class Controller_Mypage extends Lib_Contents
{
	public function action_index()
	{
		$this->action_list();
	}
	
	public function action_list()
	{
		$ModelWeapon = new Model_weapon($this->userData);
		$ModelArmor = new Model_armor($this->userData);
		$ModelAvatar = new Model_Avatar($this->userData);
		$ModelRoom = new Model_Room($this->userData);
		
		config::load('item', true);
		$totalLuckPoint = 0;
		
		//装備中アバターデータ取得
		$userAvatar = $ModelAvatar->getMargeDataByUserId($this->userData['id'], null, 1);
		foreach($userAvatar as $avatar)
		{
			switch($avatar['categoryId'])
			{
				case "a":
					$this->viewData['avatar']['a'] = $avatar;
					break;
				case "b":
					$this->viewData['avatar']['b'] = $avatar;
					break;
				case "c":
					$this->viewData['avatar']['c'] = $avatar;
					break;
				case "d":
					$this->viewData['avatar']['d'] = $avatar;
					break;
				case "e":
					$this->viewData['avatar']['e'] = $avatar;
					break;
			}
			
			$totalLuckPoint += $avatar['luckPoint'];
		}
		$this->viewData['avatar']['total']['luckPoint'] = $totalLuckPoint;
		
		//装備中武器取得
		$userWeapon = $ModelWeapon->getMargeDataByUserId($this->userData['id'], 0, 1);
		if(empty($userWeapon))
		{
			$equipWeapon = config::get('item.noEquip');
		}
		else
		{
			$equipWeapon = $userWeapon[0];
		}
		
		//装備中防具取得
		$userArmor = $ModelArmor->getMargeDataByUserId($this->userData['id'], 1);
		if(empty($userArmor))
		{
			$equipArmor = config::get('item.noEquip');
		}
		else
		{
			$equipArmor = $userArmor[0];
		}
		
		$this->viewData['status'] = $this->userData;
		$this->viewData['room'] = $ModelRoom->getEqpRoomById($this->userData['id']);
		$this->viewData['weapon'] = $equipWeapon;
		$this->viewData['armor'] = $equipArmor;
		
		View_Wrap::contents('mypage', $this->viewData);
	}
	
	public function action_idSet()
	{
		if(isset($_POST['userId'])) {
			if ($_POST['userId'] != ''){
				$this->userData['id'] = Input::post('userId');
			}
		}
		$this->action_list();
	}
}
