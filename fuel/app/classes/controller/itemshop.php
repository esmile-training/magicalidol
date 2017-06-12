<?php
class Controller_Itemshop extends Lib_Contents
{
	public function action_index()
	{
		$this->action_select();
	}
	
	public function action_select($type=1,$result=null)
	{
		$ModelItem = new Model_Item($this->userData);
		
		//アイテムデータ
		$itemData = $ModelItem->getItems($type);
		
		//購入可能数の最大値を配列で持つ
		foreach($itemData as $item)
		{
			$buyNumMax = floor($this->userData['money']/$item['price']);
			if($buyNumMax > 20)
			{
				$buyNumMax = 20;
			}
			$maxCount[] = $buyNumMax;
		}
		
		//ビューに渡す
		$this->viewData['status'] = $this->userData;
		$this->viewData['itemType'] = $type;
		$this->viewData['itemData'] = $itemData;
		if(isset($maxCount))
		{
			$this->viewData['maxCount'] = $maxCount;
		}
		else
		{
			$this->viewData['maxCount'] = null;
		}
		
		if($result)
		{
			if($result == 0)
			{
				$this->viewData['itemmsg'] = '購入できません！';
				$this->viewData['itemmsg2'] = '';
			}
			else
			{
				$this->viewData['itemmsg'] = $itemData[$result]['name'].'を購入しました';
				$this->viewData['itemmsg2'] = '受け取り箱から受け取ってください';
			}
		}
		else
		{
			$this->viewData['itemmsg'] = '';
			$this->viewData['itemmsg2'] = '';
		}		
		
		//画面表示
		if($result)
		{
			View_Wrap::contents('itemshop/itemshop', $this->viewData, 'modal');
		}
		else
		{
			View_Wrap::contents('itemshop/itemshop', $this->viewData);
		}
		
	}
	
	public function action_buyresult()
	{
		$buyNum = Input::post('itemNum');
		$type = Input::post('itemType');
		$itemId = Input::post('itemId');
		
		$ModelUser = new Model_User($this->userData);
		$ModelItem = new Model_Item($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		
		//アイテムデータ
		$itemData = $ModelItem->getItems($type);
		
		$bought = false;
		//所持金と値段を比較し、買える場合はtrueにする
		$totalPrice = $itemData[$itemId]['price'] * $buyNum;
		if($this->userData['money'] >= $totalPrice)
		{
			$bought = true;
		}
		
		if($bought == true)
		{
			$ModelUser->changeDifferenceMoney(-$totalPrice);
			$ModelPresent->setToPost(6,$itemId,$buyNum,0,$type);
		}
		else
		{
			$itemId = 0;
		}
		
		Response::redirect(CONTENTS_URL . 'itemshop/select/'.$type.'/'.$itemId);
	}
	
}