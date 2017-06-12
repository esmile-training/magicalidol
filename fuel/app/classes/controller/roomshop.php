<?php
class Controller_Roomshop extends Lib_Contents
{
	public function action_index()
	{
		$this->action_list();
	}
	
	public function action_list($roomId=null)
	{
		$ModelRoom = new Model_Room($this->userData);
		$ModelEvent = new Model_Event($this->userData);
		
		//部屋データ
		$roomData = $ModelRoom->getRoomData();
		//ユーザーが持つ部屋データ
		$userRoomData = $ModelRoom->getByUserId($this->userData['id']);
		//贈り物の中にある部屋データ
		$userPresentData = $ModelRoom->getRoomFromPresentByUserId($this->userData['id']);
		//shopのイベントデータを取得
		$eventData = $ModelEvent->getByCurrentTime(2);
		//イベント判定
		$roomlist = array();
		$eventBuy = true;
		foreach($roomData as $key=>$room)
		{
			foreach($eventData as $event)
			{
				if(!empty($room['eventId']) && $event['eventId'] != $room['eventId'] )
				{
					$eventBuy = false;
				}
			}
			if(!$eventBuy)
			{
				$eventBuy = true;
				continue;
			}
			$roomlist[] = $room;
		}
		$roomData = $roomlist;
		
		//ユーザーがすでに持っている部屋はsold out表示
		foreach($roomData as $data)
		{
			$userPossess = false;
			foreach((array)$userRoomData as $userRoom)
			{
				if($data['id'] == $userRoom['roomId'])
				{
					$userPossess = true;
				}
			}
			foreach((array)$userPresentData as $userPresent)
			{
				if($data['id'] == $userPresent['itemId'])
				{
					$userPossess = true;
				}
			}
			
			$possession[$data['id']] = $userPossess;
		}
		
		if($roomId)
		{
			if($roomId == 0)
			{
				$this->viewData['roommsg'] = '購入できません！';
				$this->viewData['roommsg2'] = '';
			}
			else
			{
				foreach($roomData as $room)
				{
					if($roomId == $room['id'])
					{
						$this->viewData['roommsg'] = $room['name'].'を購入しました';
					}
				}
				$this->viewData['roommsg2'] = '受け取り箱から受け取ってください';
			}
		}
		else
		{
			$this->viewData['roommsg'] = '';
			$this->viewData['roommsg2'] = '';
		}	
		
		//ビューデータに渡す
		//購入済みかどうか
		$this->viewData['possession'] = $possession;
		//部屋データ
		$this->viewData['roomData'] = $roomData;
		//ユーザーデータ
		$this->viewData['status'] = $this->userData;
		
		if($roomId)
		{
			View_Wrap::contents('roomshop/roomshop', $this->viewData, 'modal');
		}
		else
		{
			View_Wrap::contents('roomshop/roomshop', $this->viewData);
		}
		
	}
	
	public function action_buyresult()
	{
		$roomId = Input::post('roomId');
		
		$ModelRoom = new Model_Room($this->userData);
		$ModelUser = new Model_user($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		
		//購入可能かどうか
		//アバターのデータを取得
		$roomData = $ModelRoom->getRoomData();
		//贈り物の中にあるアバターデータ
		$userPresentData = $ModelRoom->getRoomFromPresentByUserId($this->userData['id']);
		
		$bought = false;
		//所持金と値段を比較し、買える場合はtrueにする
		foreach($roomData as $data)
		{
			if($data['id'] == $roomId)
			{
				if($this->userData['money'] >= $data['price'])
				{
					$bought = true;
				}
			}
		}
		
		//購入済みの場合は購入不可
		foreach((array)$userPresentData as $presentData)
		{
			if($presentData['itemId'] == $roomId)
			{
				$bought = false;
			}
		}
		if($bought == true)
		{
			foreach($roomData as $data)
			{
				if($data['id'] == $roomId)
				{
					$ModelUser->changeDifferenceMoney(-($data['price']));
					$ModelPresent->setToPost(8,$roomId);
				}
			}
		}
		else
		{
			$roomId = 0;
		}
		
		Response::redirect(CONTENTS_URL . 'roomshop/list/'.$roomId);
	}
}