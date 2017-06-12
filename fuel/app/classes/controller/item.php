<?php
class Controller_Item extends Lib_Contents
{
	public function action_index()
	{
		$this->action_list();
	}
	
	//引数(アイテムカテゴリー, ページ,文字を表示するか,アイテムのId)
	public function action_list($type = 1,$page=1, $msgId = null, $itemId = null)
	{
		$ModelItem = new Model_Item($this->userData);
	
		//渡されたタイプによって取得するCSV判断させています
		$this->viewData['itemList'] = $ModelItem->getItems($type);
		//アイテムのカテゴリーが欲しかったので追加
		$userItem = $ModelItem->getByUserId($type);
		
		if($msgId){
			//itemNameのviewデータにviewデータのitemList[アイテムのID]を入れる
			$this->viewData['itemName'] = $this->viewData['itemList'][$itemId];
			//itemNameのIDの中にあるNameを表示させてる
			$this->viewData['msg'] = $this->viewData['itemName']['name']."を使用しました。";
		}else{
			 $this->viewData['msg'] = "";
		}
		
		//ページャー
		$pageData = $this->listPager($userItem, $page);
		$pagerText = $this->getPagerText($page, $pageData['maxPage'], CONTENTS_URL.'item/list/'.$type.'/[page]');
		
		//HP.APが最大の時回復できないようにする
		if($type == 1)
		{
			if($this->userData['hpMax'] == $this->userData['hp'])
			{
				$this->viewData['useFlag'] = false;
			}
			else
			{
				$this->viewData['useFlag'] = true;
			}
		}
		else
		{
			if($this->userData['apMax'] == $this->userData['ap'])
			{
				$this->viewData['useFlag'] = false;
			}
			else
			{
				$this->viewData['useFlag'] = true;
			}
		}
		
		$this->viewData['userItemList'] = $pageData['dataList'];
		$this->viewData['pagerText'] = $pagerText;
		
		$this->viewData['type'] = $type;
 		View_Wrap::contents('item/userItemList', $this->viewData);
	}
	
	public function action_excute()
	{
		$itemId = Input::post('itemId');
		$categoryId = Input::post('categoryId');

		$ModelItem = new Model_Item($this->userData);
		$ModelItem->useItem($itemId, $categoryId);
		
		
		//itemMstとってくる
		$ModelItem = new Model_Item($this->userData);
		$itemList = $ModelItem->getItems($categoryId);
		foreach($itemList as $val){
			if($itemId == $val['id'])
			{
				$item_data = $val;
				break;
			}
		}
		//ユーザテーブル更新
		$ModelUser = new Model_User($this->userData);
		$ModelUser->recover($item_data['value'],$categoryId);

		Response::redirect(CONTENTS_URL.'item/list/'.$categoryId."/1/1/".$itemId);
	}
}
