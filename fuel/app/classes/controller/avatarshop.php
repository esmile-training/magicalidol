<?php
class Controller_Avatarshop extends Lib_Contents
{
	public function action_index($category,$result=null)
	{
		$pageNumData = Input::post();
		
		$ModelAvatar = new Model_Avatar($this->userData);
		$ModelEvent = new Model_Event($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		
		//shopのイベントデータを取得
		$eventData = $ModelEvent->getByCurrentTime(2);
		//アバターのデータを取得
		$avatarData = $ModelAvatar->getAvatarByCode($category);
		//0行目を引き抜く
		$avatarList = array();
		foreach($avatarData as $avatar)
		{
			//購入可能かどうかの判定
			if(empty($avatar['buyFlg']))
			{
				continue;
			}
			$eventBuy = true;
			//イベント期間の判定
			foreach($eventData as $event)
			{
				if(!empty($avatar['eventId']) && $event['eventId'] != $avatar['eventId'] )
				{
					$eventBuy = false;
				}
			}
			if(!$eventBuy)
			{
				continue;
			}
			
			$avatarList[] = $avatar;
		}
		$avatarData = $avatarList;
		
		//
		//ユーザーが持つアバターデータ
		$userAvatarData = $ModelAvatar->getByUserId($this->userData['id'],$category);
		//贈り物の中にあるアバターデータ
		$userPresentData = $ModelPresent->getByUserId(5, $category);
		
		if($result)
		{
			if($result == 0)
			{
				$this->viewData['avatarmsg'] = '購入できません！';
				$this->viewData['avatarmsg2'] = '';
			}
			else
			{
				foreach($avatarData as $avatar)
				{
					if($result == $avatar['id'])
					{
						$this->viewData['avatarmsg'] = $avatar['name'].'を購入しました';
					}
				}
				$this->viewData['avatarmsg2'] = '受け取り箱から受け取ってください';
			}
		}
		else
		{
			$this->viewData['avatarmsg'] = '';
			$this->viewData['avatarmsg2'] = '';
		}	
		
		//ページング
		if(isset($pageNumData['page']))
		{
			$page = $pageNumData['page'];
		}
		else
		{
			$page = 1;
		}
		$pageData = $this->listPager($avatarData, $page);
		$pagerText = $this->getPagerText($page, $pageData['maxPage'], 'changePage([page])', 1);
		
		//買えない,もしくはユーザーがすでに持っているアバターは表示しない
		foreach($pageData['dataList'] as $data)
		{
			$userPossess = false;
			foreach((array)$userAvatarData as $userAvatar)
			{
				if($data['id'] == $userAvatar['avatarId'])
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
			$canBuyAvatar[$data['id']] = $userPossess;
		}
		
		$this->viewData['canBuyAvatar'] = $canBuyAvatar;
		$this->viewData['categoryCode'] = $category;
		//$this->viewData['avatarData'] = $avatarData;
		$this->viewData['avatarData'] = $pageData;
		$this->viewData['pagerText'] = $pagerText;
		$this->viewData['status'] = $this->userData;
		
		//画面表示
		if($result)
		{
			View_Wrap::contents('avatarshop/avatarshop', $this->viewData, 'modal');
		}
		else
		{
			View_Wrap::contents('avatarshop/avatarshop', $this->viewData);
		}
	}
	
	public function action_buyresult($category,$avatarId,$eventId = 0)
	{
		$ModelAvatar = new Model_Avatar($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		$ModelUser = new Model_User($this->userData);
		
		//購入可能かどうか
		//ユーザーデータ取得
		$status = $this->userData;
		//アバターのデータを取得
		$avatarData = $ModelAvatar->getAvatarByCode($category);
		
		//贈り物の中にあるアバターデータ
		$userPresentData = $ModelPresent->getByUserId(5, $category);
		
		$bought = false;
		log::debug($avatarId);
		//所持金と値段を比較し、買える場合はtrueにする
		foreach($avatarData as $data)
		{
			if($data['id'] == $avatarId)
			{
				if($status['money'] >= $data['price'])
				{
					$bought = true;
				}
			}
		}
		//購入済みの場合は購入不可
		foreach((array)$userPresentData as $presentData)
		{
			if($presentData['itemId'] == $avatarId)
			{
				$bought = false;
			}
		}
		
		
		if($bought == true)
		{
			foreach($avatarData as $data)
			{
				if($data['id'] == $avatarId)
				{
					$ModelUser->changeDifferenceMoney(-$data['price']);
					$ModelPresent->setToPost(5,$avatarId,1,null,$category);
				}
			}
		}
		else
		{
			$avatarId = 0;
		}
		
		Response::redirect(CONTENTS_URL . 'avatarshop/index/'.$category.'/'.$avatarId);
	}
	
	public function action_select()
	{
		//コンフィグデータを取得
		Config::load('avatar',true);
		$this->viewData['avatarCategory'] = Config::get('avatar.category');
		
		View_Wrap::contents('avatarshop/partsselect', $this->viewData);
	}
	
}