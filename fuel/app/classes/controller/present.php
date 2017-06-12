<?php

class Controller_Present extends Lib_Contents 
{
	public function action_index($page=1,$category = null , $id = null,$count = null,$charId = null) {

		$data = Input::param();
		if(isset($data['page']))
		{
			$page = $data['page'];
		}
		
		//初期設定
		$ModelPresent = new Model_Present($this->userData);
		$ModelWeapon = new Model_weapon($this->userData);
		$ModelArmor = new Model_armor($this->userData);
		$ModelAvatar = new Model_Avatar($this->userData);
		$ModelItem = new Model_Item($this->userData);
		$ModelRoom = new Model_Room($this->userData);
		$ModelMaterial = new Model_Material($this->userData);
		
		$goldMst = array(
						array(
							"id" => 0,
							"name" => "ゴールド",
							"thumbnail" => "material/goldcoin.png",
						),
					);
		
		//プレゼント取得
		$ctg = 0;
		if(isset($data['category']))
		{
			$ctg = $data['category'];
		}
		switch($ctg)
		{
			case 0: //全部
				$mstDataList = array(
									//1:お金
									array('mstData'=>$goldMst, 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>1, 'categoryKey'=>'categoryId'),
									)),
									
									//2:素材
									array('mstData'=>$ModelMaterial->getMaster(), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>2, 'categoryKey'=>'categoryId'),
									)),
									
									//3:武器
									array('mstData'=>$ModelWeapon->getMaster(1), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'1', 'categoryKey'=>'charId'),
										array('category'=>3, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelWeapon->getMaster(2), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'2', 'categoryKey'=>'charId'),
										array('category'=>3, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelWeapon->getMaster(3), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'3', 'categoryKey'=>'charId'),
										array('category'=>3, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelWeapon->getMaster(4), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'4', 'categoryKey'=>'charId'),
										array('category'=>3, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelWeapon->getMaster('e'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'e', 'categoryKey'=>'charId'),
										array('category'=>3, 'categoryKey'=>'categoryId'),
									)),
									
									//4:防具
									array('mstData'=>$ModelArmor->getMaster(), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>4, 'categoryKey'=>'categoryId'),
									)),
									
									//5:アバター
									array('mstData'=>$ModelAvatar->getAvatarByCode('a'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'a', 'categoryKey'=>'charId'),
										array('category'=>5, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelAvatar->getAvatarByCode('b'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'b', 'categoryKey'=>'charId'),
										array('category'=>5, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelAvatar->getAvatarByCode('c'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'c', 'categoryKey'=>'charId'),
										array('category'=>5, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelAvatar->getAvatarByCode('d'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'d', 'categoryKey'=>'charId'),
										array('category'=>5, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelAvatar->getAvatarByCode('e'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'e', 'categoryKey'=>'charId'),
										array('category'=>5, 'categoryKey'=>'categoryId'),
									)),
									
									//6:アイテム
									array('mstData'=>$ModelItem->getItems(1), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'1', 'categoryKey'=>'charId'),
										array('category'=>6, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelItem->getItems(2), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'2', 'categoryKey'=>'charId'),
										array('category'=>6, 'categoryKey'=>'categoryId'),
									)),
									array('mstData'=>$ModelItem->getItems(3), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'3', 'categoryKey'=>'charId'),
										array('category'=>6, 'categoryKey'=>'categoryId'),
									)),
									
									//8:部屋
									array('mstData'=>$ModelRoom->getRoomData(), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>8, 'categoryKey'=>'categoryId'),
									)),
								);
				break;
			case 1: //お金
				$mstDataList = array(
									array('mstData'=>$goldMst, 'key'=>'itemId', 'mstKey'=>'id'),
								);
				break;
			case 2: //素材
				$mstDataList = array(
									array('mstData'=>$ModelMaterial->getMaster(), 'key'=>'itemId', 'mstKey'=>'id'),
								);
				break;
			case 3: //武器
				$mstDataList = array(
									array('mstData'=>$ModelWeapon->getMaster(1), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'1', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelWeapon->getMaster(2), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'2', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelWeapon->getMaster(3), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'3', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelWeapon->getMaster(4), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'4', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelWeapon->getMaster('e'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'e', 'categoryKey'=>'charId'),
									)),
								);
				break;
			case 4: //防具
				$mstDataList = array(
									array('mstData'=>$ModelArmor->getMaster(), 'key'=>'itemId', 'mstKey'=>'id'),
								);
				break;
			case 5: //アバター
				$mstDataList = array(
									array('mstData'=>$ModelAvatar->getAvatarByCode('a'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'a', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelAvatar->getAvatarByCode('b'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'b', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelAvatar->getAvatarByCode('c'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'c', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelAvatar->getAvatarByCode('d'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'d', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelAvatar->getAvatarByCode('e'), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'e', 'categoryKey'=>'charId'),
									)),
								);
				break;
			case 6: //アイテム
				$mstDataList = array(
									array('mstData'=>$ModelItem->getItems(1), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'1', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelItem->getItems(2), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'2', 'categoryKey'=>'charId'),
									)),
									array('mstData'=>$ModelItem->getItems(3), 'key'=>'itemId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>'3', 'categoryKey'=>'charId'),
									)),
								);
				break;
			case 8: //部屋
				$mstDataList = array(
									array('mstData'=>$ModelRoom->getRoomData(), 'key'=>'itemId', 'mstKey'=>'id'),
								);
				break;
		}
		
		$presentList = $ModelPresent->getByUserId($ctg);
		$presentViewList = $this->dataMarge($presentList, $mstDataList);
		
		//画像パスの調整
		foreach($presentViewList as &$present)
		{
			if(($present['categoryId']==1)||($present['categoryId']==5)||($present['categoryId']==8))
			{
				continue;
			}
			Log::debug("presentCategory:".$present['categoryId']);
			$present['thumbnail'] = $present['img'];
		}
		
		Config::load('item', true);
		$this->viewData['messag_flag'] = Input::get('messag_flag');
		$this->viewData['categoryList'] = Config::get('item.presentCategory');
		$this->viewData['category'] = $ctg;
		
		if(!empty($presentViewList))
		{
			Log::debug('paging pass content = '.count($presentViewList));
			$pageData = $this->listPager($presentViewList, $page);
			$pagerText = $this->getPagerText($page, $pageData['maxPage'],  'changePage([page])', 1);
			
			Log::debug('dataList count = '.count($pageData['dataList']));
			$this->viewData['presentViewList'] = $pageData['dataList'];
			$this->viewData['page'] = $pageData['page'];
			$this->viewData['maxPage'] = $pageData['maxPage'];
			$this->viewData['pagerText'] = $pagerText;
		}
		else
		{
			$this->viewData['presentViewList'] = array();
			$this->viewData['page'] = $page;
		}

		switch($category)
			{
				case 100:
				{
					$this->viewData['msg'] = '一括受け取りしました';
					break;
				}
				case 1:
				{
					$this->viewData['msg'] = 'ゴールドを'.$count.'G受け取りました';
					break;
				}
				case 2:	//素材の名前を表示する
				{
					foreach($ModelMaterial->getMaster() as $mData)
					{
						if($mData['id'] == $id)
						{
							$this->viewData['msg'] = $mData['name'].'を'.$count.'個受け取りました';
						}
					}
					break;
				}
				case 3:
				{
					foreach($ModelWeapon->getMaster($charId) as $wData)
					{
						if($wData['id'] == $id)
						{
							$this->viewData['msg'] = $wData['name'].'を受け取りました';
						}
					}
					break;
				}
				case 4:
				{
					foreach($ModelArmor->getMaster() as $amData)
					{
						if($amData['id'] == $id)
						{
							$this->viewData['msg'] = $amData['name'].'を受け取りました';
						}
					}
					break;
				}
				case 5:
				{
					foreach($ModelAvatar->getAvatarByCode($charId) as $avData)
					{
						if($avData['id'] == $id)
						{
							$this->viewData['msg'] = $avData['name'].'を受け取りました';
						}
					}
					break;
				}
				case 6:
				{
					foreach($ModelItem->getItems($charId) as $iData)
					{
						if($iData['id'] == $id)
						{
							$this->viewData['msg'] = $iData['name'].'を受け取りました';
						}
					}
					break;
				}
				case 8:
				{
					foreach($ModelRoom->getRoomData() as $rData)
					{
						if($rData['id'] == $id)
						{
							$this->viewData['msg'] = $rData['name'].'を受け取りました';
						}
					}
					break;
				}
				default : 
				{
					$this->viewData['msg'] = '';
					break;
				}
			}
		
		View_Wrap::contents('present/top', $this->viewData);

	}

		
	/**
	 * 確認画面
	 */
	public function action_check() {
		$present_id = Input::post('id');

		$ModelPresent = new Model_present($this->userData);

		//$itemList = $ModelPresent->getAllItems();
		//$this->viewData['itemInfo'] = $itemList[$present_id];

		View_Wrap::contents('present/check', $this->viewData);
	}

	/**
	 * 受け取り
	 */
	public function action_getpresent() 
	{
		$presentNum = Input::post('id');
		$ModelPresent = new Model_Present($this->userData);
		$present = $ModelPresent->getById($presentNum);
		
		$this->getPresent($presentNum);

		Response::redirect(CONTENTS_URL.'present/index/1/'.$present['categoryId'].'/'.$present['itemId'].'/'.$present['count'].'/'.$present['charId']);
		
	}
	
	/**
	 * 受け取り
	 */
	public function action_getallpresent() 
	{
		$presentNums = Input::param();
		$flg = 0;
		foreach((array)$presentNums as $presentNum)
		{
			if($presentNum != 0)
			{
				$this->getPresent($presentNum);
				$flg = 1;
			}
		}
		if($flg == 1)
		{
			Response::redirect(CONTENTS_URL.'present/index/1/100');
		}
		else
		{
			Response::redirect(CONTENTS_URL.'present/index/1');
		}
		
	}

	//画面遷移なしの受け取り
	private function getPresent($id)
	{
		$ModelPresent = new Model_Present($this->userData);
		$present = $ModelPresent->getById($id);
		
		//カテゴリーごとに処理を分ける
		switch($present['categoryId'])
		{
			case 1:	//お金の場合
			{
				//追加する処理を呼び出す
				// $ModelPresent->addMoney($this->userData['id'],$present['count']);
				$ModelUser = new Model_User($this->userData);
				$ModelUser->changeDifferenceMoney($present['count']);
				break;
			}
			case 2:	//素材アイテムの場合
			{
				$ModelMaterial = new Model_Material($this->userData);
				$ModelMaterial->addMaterial($present['itemId'], $present['count']);
				break;
			}
			case 3:	//武器の場合
			{
				//追加する処理を呼び出す
				$ModelWeapon = new Model_weapon($this->userData);
				$ModelWeapon->insertWeapon($present['charId'], $present['itemId'], $present['value']);
				break;
			}
			case 4:	//防具の場合
			{
				//追加する処理を呼び出す
				$ModelArmor = new Model_armor($this->userData);
				$ModelArmor->insertArmor($present['itemId'], $present['value']);
				break;
			}
			case 5:	//アバターの場合
			{
				//追加する処理を呼び出す
				$ModelAvatar = new Model_Avatar($this->userData);
				$ModelAvatar->insertAvatar($present['charId'], $present['itemId']);
				break;
			}
			case 6:	//アイテムの場合
			{
				$ModelItem = new Model_Item($this->userData);
				$ModelItem->addItem((int)$present['charId'], $present['itemId'], $present['count']);
				break;
			}
			case 8:	//部屋の場合
			{
				//追加する処理を呼び出す
				$ModelRoom = new Model_Room($this->userData);
				$ModelRoom->insertRoom($this->userData['id'],$present['itemId']);
				break;
			}
			default: 
				return;
				break;
		}
		$ModelPresent->deleteById($present['id']);
	}
}
