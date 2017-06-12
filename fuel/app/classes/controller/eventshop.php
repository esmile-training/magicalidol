<?php

class Controller_Eventshop extends Lib_Contents 
{
	public function action_index()
	{
		$this->action_list();
	}
	
	public function action_list($category=1)
	{
		$ModelEvent = new Model_Event($this->userData);
		$currentEvent = $ModelEvent->getMargeDataBycurrentTime($category,true);
		if(!empty($currentEvent))
		{
			foreach($currentEvent as &$event)
			{
				if(!empty($event['start']))
				{
					$event['start'] = date('n月j日', strtotime($event['start']));
				}
				if(!empty($event['end']))
				{
					$event['end'] = date('n月j日', strtotime($event['end']));
				}
			}
		}
		
		$this->viewData['eventData'] = $currentEvent;
		
		View_Wrap::contents('eventshop/top', $this->viewData);
	}
	
	public function action_shop($categoryId,$eventId,$result=null)
	{
		
		$ModelMaterial = new Model_Material($this->userData);
		
		//イベント素材の所持数をデータベースから取得
		$userMaterial = $ModelMaterial->getMargeDataByUserId($this->userData['id']);
		$eventMaterial = 0;
		foreach((array)$userMaterial as $material)
		{
			if($material['eventId'] == $eventId)
			{
				$eventMaterial = $material['count'];
			}
		}
		
		$eventshopList = $this->getEventGoods($eventId);
		
		$this->viewData['materialName'] = $this->getEventMaterialName();
		$this->viewData['categoryId'] = $categoryId;
		$this->viewData['eventId'] = $eventId;
		$this->viewData['eventshopList'] = $eventshopList;
		$this->viewData['eventMaterial'] = $eventMaterial;
		
		if($result)
		{
			if($result == 0)
			{
				$this->viewData['msg'] = '交換できません';
				$this->viewData['msg2'] = '';
			}
			else
			{
				foreach($eventshopList as $list)
				{
					if($list['id'] == $result)
					{
						$exchangeName = $list['name'];
					}
				}
				$this->viewData['msg'] = $exchangeName.'を入手しました';
				$this->viewData['msg2'] = '受け取り箱から受け取ってください';
			}
		}
		else
		{
			$this->viewData['msg'] = '';
			$this->viewData['msg2'] = '';
		}
		if($result)
		{
			View_Wrap::contents('eventshop/shop', $this->viewData,'modal');
		}
		else
		{
			View_Wrap::contents('eventshop/shop', $this->viewData);
		}
	}
	
	function getMaterialName($materialId)
	{
		$ModelMaterial = new Model_Material($this->userData);
		
		$materialData =  $ModelMaterial->getAllMaterial();
		
		$materialName = '';
		foreach((array)$materialData as $data)
		{
			if($data['id'] == $materialId)
			{
				$materialName = $data['name'];
			}
		}
		return $materialName;
	}
	
	//現在開催されているイベントの素材アイテムを取得
	function getEventMaterialName()
	{
		$ModelMaterial = new Model_Material($this->userData);
		$ModelEvent = new Model_Event($this->userData);
		
		$currentEvent = $ModelEvent->getByCurrentTime();
		$materialData = $ModelMaterial->getMaster();
		
		$materialName = '';
		
		foreach((array)$currentEvent as $event)
		{
			foreach((array)$materialData as $data)
			{
				if($event['category'] == $data['categoryId'] && $event['eventId'] == $data['eventId'])
				{
					$materialName = $data['name'];
				}
			}
		}
		return $materialName;
	}
	
	public function action_exchangeresult()
	{
		//postデータを取得
		$exchangeItemId = Input::post('itemId');
		$categoryId = Input::post('categoryId');
		$eventId = Input::post('eventId');
		
		$ModelMaterial = new Model_Material($this->userData);
		$ModelEvent = new Model_Event($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		
		//イベント情報を取得
		$eventData = $ModelEvent->getByCurrentTime();
		//イベントの交換用アイテムを取得
		$materialData =  $ModelMaterial->getMaster();
		foreach((array)$eventData as $event)
		{
			if($event['category'] == $categoryId)
			{
				$nowEvent = $event;
				foreach((array)$materialData as $data)
				{
					if($data['eventId'] == $event['eventId'])
					{
						$eventMaterial = $data;
					}
				}
			}
		}
		
		//イベント素材の所持数をデータベースから取得
		$userMaterial = $ModelMaterial->getMargeDataByUserId($this->userData['id']);
		$eventMaterialNum = 0;
		foreach((array)$userMaterial as $material)
		{
			if($material['eventId'] == $nowEvent['eventId'])
			{
				$eventMaterialNum = $material['count'];
			}
		}
		
		//交換するアイテムを特定
		$itemList = $this->getEventGoods($nowEvent['eventId']);
		foreach($itemList as $item)
		{
			if($exchangeItemId == $item['id'])
			{
				$buyItem = $item;
			}
		}
		
		//アイテムが交換できるか確認
		$bought = true;
		if($eventMaterialNum < $buyItem['exchangeNum'])
		{
			$bought = false;
		}
		
		//交換処理　メダルを減らし、プレゼントに送る
		if($bought)
		{
			$ModelMaterial->reduceMaterial($this->userData['id'],$eventMaterial['id'],$buyItem['exchangeNum']);
			$ModelPresent->setToPost($buyItem['categoryId'],$buyItem['itemId'],$count='1',$buyItem['value'],$buyItem['charId']);
			$result = $exchangeItemId;
		}
		else
		{
			$result = 0;
		}
		
		//リダイレクト
		Response::redirect(CONTENTS_URL.'eventshop/shop/'.$categoryId.'/'.$eventId.'/'.$result);
	}
	
	/**
		指定イベントの交換所アイテムを取得
		@eventId : 開催中のイベントID
	*/
	public function getEventGoods($eventId)
	{
		$ModelEvent = new Model_Event($this->userData);
		$eventGoods = $ModelEvent->getEventShopMaster();
		
		//カテゴリーなどの情報からデータを特定し、name,thumbnailを追加する
		//武器取得
		$ModelWeapon = new Model_weapon($this->userData);
		//防具取得
		$ModelArmor = new Model_armor($this->userData);
		$armorData = $ModelArmor->getMaster();
		//アバター取得
		$ModelAvatar = new Model_Avatar($this->userData);
		//アイテム取得
		$ModelItem = new Model_Item($this->userData);
		//素材取得
		$ModelMaterial = new Model_Material($this->userData);
		$materialData = $ModelMaterial->getMaster();
		//部屋取得
		$ModelRoom = new Model_Room($this->userData);
		$roomData = $ModelRoom->getRoomData();
		
		$goodsList = array();
		foreach($eventGoods as $goods)
		{
			if($goods['eventId'] == $eventId)
			{
				switch($goods['categoryId'])
				{
					case 1:{	break;	}
					case 2:
					{
						foreach($materialData as $mData)
						{
							if($goods['itemId'] == $mData['id'])
							{
								$goods['name'] = $mData['name'];
								$goods['thumbnail'] = $mData['img'];
							}
						}
						$goodsList[] = $goods;
						break;
					}
					case 3:
					{
						$weaponData = $ModelWeapon->getMaster($goods['charId']);
						foreach($weaponData as $wData)
						{
							if($goods['itemId'] == $wData['id'])
							{
								$goods['name'] = $wData['name'];
								$goods['thumbnail'] = $wData['img'];
							}
						}
						$goodsList[] = $goods;
						break;
					}
					case 4:
					{
						foreach($armorData as $amData)
						{
							if($goods['itemId'] == $amData['id'])
							{
								$goods['name'] = $amData['name'];
								$goods['thumbnail'] = $amData['img'];
							}
						}
						$goodsList[] = $goods;
						break;
					}
					case 5:
					{
						$avatarData = $ModelAvatar->getAvatarByCode($goods['charId']);
						foreach($avatarData as $avData)
						{
							if($goods['itemId'] == $avData['id'])
							{
								$goods['name'] = $avData['name'];
								$goods['thumbnail'] = $avData['thumbnail'];
							}
						}
						$goodsList[] = $goods;
						break;
					}
					case 6:
					{
						$itemData = $ModelItem->getItems($goods['charId']);
						foreach($itemData as $iData)
						{
							if($goods['itemId'] == $iData['id'])
							{
								$goods['name'] = $iData['name'];
								$goods['thumbnail'] = $iData['img'];
							}
						}
						$goodsList[] = $goods;
						break;
					}
					case 8:
					{
						foreach($roomData as $rData)
						{
							if($goods['itemId'] == $rData['id'])
							{
								$goods['name'] = $rData['name'];
								$goods['thumbnail'] = $rData['thumbnail'];
							}
						}
						$goodsList[] = $goods;
						break;
					}
					default : 
					{
						break;
					}
				}
			}
		}
		
		return $goodsList;
	}
}
