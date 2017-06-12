<?php
class Controller_Avatar extends Lib_Contents
{
	//アバターカテゴリ選択画面
	public function action_index()
	{
		//初期設定
		Config::load('avatar',true);
		
		//カテゴリーリスト
		$this->viewData['categoryList'] = Config::get('avatar.category');
		
		View_Wrap::contents('avatar/category', $this->viewData);
	}
	
	/*
	  アバター選択画面
	  $categoryCode:アバターカテゴリーコード(config[avatar]参照)
	  $result:装備変更結果フラグ
	*/
	public function action_selectAvatar($categoryCode, $result=0)
	{
		//初期設定
		$data = Input::param();
		$ModelAvatar = new Model_Avatar();
		Config::load('avatar', true);
		
		//データ取得
		$userAvatar = $ModelAvatar->getMargeDataByUserId($this->userData['id'], $categoryCode);
		$sort = 0;
		if(isset($data['sort']))
		{
			$sort = $data['sort'];
		}
		//装備アバターを取得
		$avatarList = array();
		foreach($userAvatar as $avatar)
		{
			if($avatar['equipmentFlg'] == 1)
			{
				$equipAvatar = $avatar;
			}
			else
			{
				$avatarList[] = $avatar;
			}
		}
		$userAvatar = $avatarList;
		
		//データソート
		if(!empty($userAvatar))
		{
			switch($sort)
			{
				case 1:
					$userAvatar = $this->arraySortByKey($userAvatar, 'hitPoint', SORT_DESC);
					break;
				case 2:
					$userAvatar = $this->arraySortByKey($userAvatar, 'hitPoint');
					break;
				case 3:
					$userAvatar = $this->arraySortByKey($userAvatar, 'luckPoint', SORT_DESC);
					break;
				case 4:
					$userAvatar = $this->arraySortByKey($userAvatar, 'luckPoint');
					break;
				default:
					break;
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
		$pageData = $this->listPager($userAvatar, $page);
		$pagerText = $this->getPagerText($page, $pageData['maxPage'], 'changePage([page])', 1);
		
		//データ出力
		$this->viewData['categoryCode'] = $categoryCode;
		$this->viewData['equipAvatar'] = $equipAvatar;
		$this->viewData['userAvatar'] = $pageData['dataList'];
		$this->viewData['pagerText'] = $pagerText;
		$this->viewData['sortType'] = Config::get('avatar.sortType');
		$this->viewData['sort'] = $sort;
		$this->viewData['result'] = $result;
		
		//画面表示
		if($result)
		{
			View_Wrap::contents('avatar/select', $this->viewData, 'modal');
		}
		else
		{
			View_Wrap::contents('avatar/select', $this->viewData);
		}
	}
	
	//アバター変更確認画面
	public function action_confirm()
	{
		//初期設定
		$data = Input::param();
		$ModelAvatar = new Model_Avatar();
		$userAvatar = $ModelAvatar->getMargeDataByUserId($this->userData['id'], $data['categoryCode']);
		
		//データ取得
		$data['userAvatar'] = $userAvatar;
		
		//データ出力
		View_Wrap::contents('avatar/confirm', $data);
	}
	
	//アバター変更処理
	public function action_submit()
	{
		//初期設定
		$data = Input::param();
		$ModelAvatar = new Model_Avatar();
		
		//ブラウザバック対策用現在装備チェック
		if($this->checkEquip($data['newAvatar']))
		{
			Response::redirect(CONTENTS_URL.'avatar/selectAvatar/'.$data['categoryCode']);
			return;
		}
		
		//アバター変更処理
		$ModelAvatar->changeAvatar($this->userData['id'], $data['nowAvatar'], $data['newAvatar'], $data['nowHp'], $data['newHp']);
		
		//結果ページへのリダイレクト
		Response::redirect(CONTENTS_URL.'avatar/selectAvatar/'.$data['categoryCode'].'/success');
	}
	
	/*
	  現在装備アバターチェック関数
	  $id:チェックしたいアバターのID
	  return:装備中(true)/未装備(false)
	*/
	private function checkEquip($id)
	{
		//初期設定
		$ModelAvatar = new Model_Avatar();
		
		$avatar = $ModelAvatar->getById($id);
		$result = ($avatar['equipmentFlg'] == 1);
		
		return $result;
	}
}
