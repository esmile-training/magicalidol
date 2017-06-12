<?php
class Controller_Compound extends Lib_Contents
{
	//トップページに飛ぶ。
	//$resultに0以外が入っていたらページロードでmodalを出す。
	public function action_index($page=1, $result=null)
	{
		$ModelEvent = new Model_Event($this->userData);
		//武器情報取得
		$this->viewData = Input::param();
		$ModelWeapon = new Model_weapon();
		//武器強化確率変動のイベントデータを取得
		$eventCompoundData = $ModelEvent->getMargeDataBycurrentTime(3);
		//$userWeapon = $ModelWeapon->getMargeDataByUserId($this->userData['id']);
		$this->viewData['result'] = $result;
		Config::load('weapon', true);
		Config::load('item', true);

		$category = '0';
		if(isset($this->viewData['category']))
		{
			$category = $this->viewData['category'];
		}
		//装備武器を取得
		$equipWeapon = $ModelWeapon->getMargeDataByUserId($this->userData['id'], 0, 1);
		if(empty($equipWeapon))
		{
			$equipWeapon = Config::get('item.noEquip');
		}
		else
		{
			$equipWeapon = $equipWeapon[0];
		}
		//非装備武器を取得
		$userWeapon = $ModelWeapon->getMargeDataByUserId($this->userData['id'], $category, 0);
		//条件に合った武器を探す
		foreach($userWeapon as $weapon)
		{
			if($weapon['strengthening'] < 20)
			{
				$weaponList[] = $weapon;
			}
		}
		//ページング
		if(isset($this->viewData['page']))
		{
			$page = $this->viewData['page'];
		}
		else
		{
			$page = 1;
		}
		
		//表示する武器カテゴリに従って武器配列データを再構成
		if($category)
		{
			$categoryWeaponList = array();
			foreach($userWeapon as $weapon)
			{
				if($weapon['category'] == $category)
				{
					$categoryWeaponList[] = $weapon;
				}
			}
			$weaponList = $categoryWeaponList;
		}
		if(isset($weaponList))
		{
			$pageData = $this->listPager($weaponList, $page);
			$pagerText = $this->getPagerText($page, $pageData['maxPage'],  'changePage([page])', 1);
			
			$this->viewData['userWeapon'] = $pageData['dataList'];
			$this->viewData['page'] = $pageData['page'];
			$this->viewData['maxPage'] = $pageData['maxPage'];
			$this->viewData['pagerText'] = $pagerText;
		}
		$this->viewData['category'] = $category;
		$this->viewData['categoryList'] = Config::get('weapon.category');
		$this->viewData['userData'] = $this->userData;
		$this->viewData['equipWeapon'] = $equipWeapon;
		
		//イベント武器強化確立アップ
		if(!empty($eventCompoundData))
		{
			$this->viewData['eventCompoundData'] = array_shift($eventCompoundData);
		}

		//画面表示
		if($result)
		{
			//表示するメッセージ
			if($result == 'success')
			{
				$msg = "成功しました";
				$this->viewData['msg'] = $msg;
			}
			else if($result == 'woops')
			{
				$msg = "失敗しました";
				$this->viewData['msg'] = $msg;
			}
			View_Wrap::contents('compound/top', $this->viewData, 'modal');
		}
		else
		{
			View_Wrap::contents('compound/top', $this->viewData);
		}
	}
	
	//セレクトページ
	public function action_select()
	{
		//データ取得
		$data = Input::param();
		$ModelWeapon = new Model_weapon();
		$userWeapon = $ModelWeapon->getMargeDataByUserId($this->userData['id'],$data['category']);
		$successRate = 100.0;
		$Model_Event = new Model_Event($this->userData);
		$eventData = $Model_Event->getMargeDataBycurrentTime(3);

		//イベントデータの取得
		$progress = null;
		if(substr($rank, 0, 1) == 'e')
		{
			$eventId = substr($rank, 1);
			$category = 1;
			
			$eventData = $ModelEvent->getByEventId($category, $eventId);
			if($eventData['isProgress'])
			{
				$userEvent = $ModelEvent->getUserEvent($category, $eventId);
				if(empty($userEvent))
				{
					$ModelEvent->createUserEvent($category, $eventId);
					$progress = 0;
				}
				else{
					$progress = $userEvent['progress'];
				}
			}
		}

		//イベント中なら成功率2倍
		if(!empty($eventData))
		{
			//ベースになる武器を探す
			foreach($userWeapon as $weapon)
			{
				if($weapon['id'] == $data['id'])
				{
					//強化の成功確率
					for($cnt=0; $cnt<$weapon['strengthening']; $cnt++)
					{
						$successRate *= 0.9;
						$successRate = floor($successRate);
					}
					if($successRate < 2)
					{
						$successRate = 2;
					}
					
					$successRate *= 2;
					
					if($successRate > 100)
					{
						$successRate = 100;
					}

				}
				else if($weapon['weaponId'] == $data['weaponId'] && !$weapon['equipmentFlg'])
				{
					
					$weaponList[] = $weapon;
					
				}
			}
		}
		//通常の時
		else if(empty($eventData))
		{
			//ベースになる武器を探す
			foreach($userWeapon as $weapon)
			{
				if($weapon['id'] == $data['id'])
				{
					//強化の成功確率
					for($cnt=0; $cnt<$weapon['strengthening']; $cnt++)
					{
						$successRate *= 0.9;
						$successRate = floor($successRate);
					}
					if($successRate < 2)
					{
						$successRate = 2;
					}
				}
				else if($weapon['weaponId'] == $data['weaponId'] && !$weapon['equipmentFlg'])
				{
					
					$weaponList[] = $weapon;
					
				}
			}
		}

		//ページング
		if(isset($data['page']))
		{
			$page = $data['page'];
		}
		else
		{
			$page = 1;
		}
		if(isset($weaponList))
		{
			$pageData = $this->listPager($weaponList, $page);
			$pagerText = $this->getPagerText($page, $pageData['maxPage'], 'changePage([page])', 1);
			
			$data['weaponList'] = $weaponList;
			$data['pageList'] = $pageData['dataList'];
			$data['page'] = $pageData['page'];
			$data['maxPage'] = $pageData['maxPage'];
			$data['pagerText'] = $pagerText;
		}
		
		$data['userWeapon'] = $userWeapon;
		$data['successRate']= $successRate;
		$data['userData'] = $this->userData;
		
		View_Wrap::contents('compound/select', $data);
	}
	
	//武器強化の成功判定をしてその結果とデータベースの更新をかける
	public function action_submit($baseWeaponId=0,$materialWeaponId=0,$successRate=0)
	{
		
		$ModelWeapon = new Model_weapon();
		
		$materialWeapon = $ModelWeapon->getById($materialWeaponId);
		if(empty($materialWeapon))
		{
			Response::redirect(CONTENTS_URL.'compound');
			return;
		}
		//武器強化の成功判定
		if(mt_rand(0,99) < $successRate)
		{
			$result= 'success';
			$ModelWeapon->compoundWeapon($baseWeaponId);
		}
		else
		{
			$result= 'woops';
		}
		$ModelWeapon->deleteById($materialWeaponId);
		Response::redirect(CONTENTS_URL.'compound/index/1/'.$result);
	}
}
