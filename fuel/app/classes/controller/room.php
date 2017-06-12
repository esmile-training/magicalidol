<?php
class Controller_Room extends Lib_Contents
{
	public function action_index()
	{
		$this->action_list();
	}
	
	public function action_list($result=null)
	{
		$ModelRoom = new Model_Room($this->userData);
		
		$eqpRoom = $ModelRoom->getEqpRoomById($this->userData['id']);
		$noEqpRoom = $ModelRoom->getNoEqpRoomById($this->userData['id']);
		
		foreach((array)$noEqpRoom as $neRoom)
		{
			if($neRoom['apvalue'] == null)
			{
				$neRoom['apvalue'] = 0;
			}
			$neRoomData[] = $neRoom;
		}
		if(isset($neRoomData))
		{
			$noEqpRoom = $neRoomData;
		}
		
		$this->viewData['nowRoom'] = $eqpRoom;
		$this->viewData['otherRooms'] = $noEqpRoom;
		
		if($result)
		{
			$this->viewData['roommsg'] = $eqpRoom['name'].'に変更しました';
			View_wrap::contents('room/index',$this->viewData,'modal');
		}
		else
		{
			View_wrap::contents('room/index',$this->viewData);
		}
	}
	
	public function action_change()
	{
		//変更前と変更後の部屋番号を取得
		$nowRoomId = Input::post('nowRoomId');
		$newRoomId = Input::post('newRoomId');
		
		//モデルインスタンス生成
		$ModelRoom = new Model_Room($this->userData);
		
		//データチェック
		$userRoomData = $ModelRoom->getEqpRoomById($this->userData['id']);
		if($userRoomData['roomId'] == $newRoomId || $userRoomData['roomId'] != $nowRoomId)
		{
			Response::redirect(CONTENTS_URL.'room/list');
			return;
		}
		$roomData = $ModelRoom->getRoomData();
		$nowRoomAp = 0;
		$newRoomAp = 0;
		foreach($roomData as $data)
		{
			if($data['id'] == $nowRoomId)
			{
				$nowRoomAp = $data['apvalue'];
			}
			if($data['id'] == $newRoomId)
			{
				$newRoomAp = $data['apvalue'];
			}
		}
		
		$ModelRoom->changeRoom($this->userData['id'],$nowRoomId,$newRoomId,$nowRoomAp,$newRoomAp);
		
		Response::redirect(CONTENTS_URL.'room/list/'.$newRoomId);
	}
}
