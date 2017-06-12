<?php
class Controller_Weapon extends Lib_Contents
{
	/*	
	  武器選択画面
	  $result:装備変更結果フラグ
	*/
	public function action_index($result=0)
	{
		//初期設定
		$data = Input::param();
		$ModelWeapon = new Model_weapon();
		Config::load('weapon', true);
		Config::load('item', true);
		
		//データ取得
		$category = '0';
		if(isset($data['category']))
		{
			$category = $data['category'];
		}
		$sort = 0;
		if(isset($data['sort']))
		{
			$sort = $data['sort'];
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
		
		//データソート
		if(!empty($userWeapon))
		{
			switch($sort)
			{
				case 1:
					$userWeapon = $this->arraySortByKey($userWeapon, 'status', SORT_DESC);
					break;
				case 2:
					$userWeapon = $this->arraySortByKey($userWeapon, 'status');
					break;
				default:
					foreach($userWeapon as $key=>$row)
					{
						$tmpArrayCategory[$key] = $row['category'];
						$tmpArrayGrade[$key] = $row['grade'];
						$tmpArrayStrengthening[$key] = $row['strengthening'];
					}
					array_multisort($tmpArrayCategory, SORT_ASC, $tmpArrayGrade, SORT_DESC, $tmpArrayStrengthening, SORT_DESC, $userWeapon);
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
		$pageData = $this->listPager($userWeapon, $page);
		$pagerText = $this->getPagerText($page, $pageData['maxPage'], 'changePage([page])', 1);
		
		//データ出力
		$this->viewData['equipWeapon'] = $equipWeapon;
		$this->viewData['userWeapon'] = $pageData['dataList'];
		$this->viewData['pagerText'] = $pagerText;
		$this->viewData['categoryList'] = Config::get('weapon.category');
		$this->viewData['sortType'] = Config::get('weapon.sortType');
		$this->viewData['category'] = $category;
		$this->viewData['sort'] = $sort;
		$this->viewData['result'] = $result;
		
		//画面表示
		if($result)
		{
			View_Wrap::contents('weapon/index', $this->viewData, 'modal');
		}
		else
		{
			View_Wrap::contents('weapon/index', $this->viewData);
		}
	}
	
	//武器変更処理
	public function action_submit()
	{
		//初期設定
		$data = Input::param();
		$ModelWeapon = new Model_Weapon();
		
		//ブラウザバック対策用現在装備チェック
		if($this->checkEquip($data['newWeapon']))
		{
			Response::redirect(CONTENTS_URL.'weapon');
			return;
		}
		
		//武器変更処理
		$ModelWeapon->changeWeapon($data['nowWeapon'], $data['newWeapon']);
		
		//結果ページへのリダイレクト
		Response::redirect(CONTENTS_URL.'weapon/index/success');
	}
	
	/*
	  現在装備武器チェック関数
	  $id:チェックしたい武器のID
	  return:装備中(true)/未装備(false)
	*/
	private function checkEquip($id)
	{
		//初期設定
		$ModelWeapon = new Model_Weapon();
		
		if($id)
		{
			$weapon = $ModelWeapon->getById($id);
			$result = ($weapon['equipmentFlg'] == 1);
		}
		else
		{
			$weapon = $ModelWeapon->getByUserId($this->userData['id'], 1);
			$result = empty($weapon);
		}
		
		return $result;
	}
}

