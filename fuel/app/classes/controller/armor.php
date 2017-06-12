<?php
class Controller_Armor extends Lib_Contents
{
	/*
	  防具選択画面
	  $result:装備変更結果フラグ
	*/
	public function action_index($result=0)
	{
		//初期設定
		$data = Input::param();
		$ModelArmor = new Model_armor();
		Config::load('armor', true);
		Config::load('item', true);
		
		//データ取得
		$userArmor = $ModelArmor->getMargeDataByUserId($this->userData['id']);
		$sort = 0;
		if(isset($data['sort']))
		{
			$sort = $data['sort'];
		}
		//装備防具を取得
		$equipArmor = Config::get('item.noEquip');
		$armorList = array();
		foreach($userArmor as $armor)
		{
			if($armor['equipmentFlg'] == 1)
			{
				$equipArmor = $armor;
			}
			else
			{
				$armorList[] = $armor;
			}
		}
		$userArmor = $armorList;
		
		//データソート
		if(!empty($userArmor))
		{
			switch($sort)
			{
				case 1:
					$userArmor = $this->arraySortByKey($userArmor, 'status', SORT_DESC);
					break;
				case 2:
					$userArmor = $this->arraySortByKey($userArmor, 'status');
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
		$pageData = $this->listPager($userArmor, $page);
		$pagerText = $this->getPagerText($page, $pageData['maxPage'], 'changePage([page])', 1);
		
		//データ出力
		$this->viewData['equipArmor'] = $equipArmor;
		$this->viewData['userArmor'] = $pageData['dataList'];
		$this->viewData['pagerText'] = $pagerText;
		$this->viewData['sortType'] = Config::get('armor.sortType');
		$this->viewData['sort'] = $sort;
		$this->viewData['result'] = $result;
		
		//画面表示
		if($result)
		{
			View_Wrap::contents('armor/index', $this->viewData, 'modal');
		}
		else
		{
			View_Wrap::contents('armor/index', $this->viewData);
		}
	}
		
	//防具変更処理
	public function action_submit()
	{
		//初期設定
		$data = Input::param();
		$ModelArmor = new Model_armor();
		
		//ブラウザバック対策用現在装備チェック
		if($this->checkEquip($data['newArmor']))
		{
			Response::redirect(CONTENTS_URL.'armor');
			return;
		}
		
		//防具変更処理
		$ModelArmor->changeArmor($data['nowArmor'], $data['newArmor']);
		
		//結果ページへのリダイレクト
		Response::redirect(CONTENTS_URL.'armor/index/success');
	}
	
	/*
	  現在装備防具チェック関数
	  $id:チェックしたい防具のID
	  $return:装備中(true)/未装備(false)
	*/
	private function checkEquip($id)
	{
		//初期設定
		$ModelArmor = new Model_Armor();
		
		if($id)
		{
			$armor = $ModelArmor->getById($id);
			$result = ($armor['equipmentFlg'] == 1);
		}
		else
		{
			$armor = $ModelArmor->getByUserId($this->userData['id'], 1);
			$result = empty($armor);
		}
		
		return $result;
	}
}

