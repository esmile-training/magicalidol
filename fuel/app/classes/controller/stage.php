<?php
class Controller_Stage extends Lib_Contents
{

	public function action_selectLevel($feeluck = false)
	{
		$ModelDungeon = new Model_Dungeon($this->userData);
		$ModelEvent = new Model_Event($this->userData);
		
		$rank = $ModelDungeon->getRankMaster();
		$count = count($rank);
		
		//イベントデータを取得
		$eventData = $ModelEvent->getMargeDataBycurrentTime(1);
		if(!empty($eventData))
		{
			foreach($eventData as &$event)
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
		
		//中断したデータがあるかどうかを確認
		$userDungeonData = $ModelDungeon->getDungeonDb($this->userData['id']);
		if(!empty($userDungeonData))
		{
			$this->viewData['dungeonFlag'] = true;
			$this->viewData['dungeonData'] = $userDungeonData;
		}
		else
		{
			$this->viewData['dungeonFlag'] = false;
		}
		
		$this->viewData['rankData'] = $rank;
		$this->viewData['count'] = $count;
		$this->viewData['eventData'] = $eventData;
		$this->viewData['feeluck'] = $feeluck;
		
		if(!empty($userDungeonData) || $feeluck)
		{
			View_Wrap::contents('stage/selectLevel', $this->viewData,'modal');
		}
		else
		{
			View_Wrap::contents('stage/selectLevel', $this->viewData);
		}
	}
	//中断ダンジョンを再開するかあきらめるかのアクション
	public function action_resume()
	{
		//POSTからデータを受け取る
		$resume = (bool)(Input::post('resume'));
		
		//モデルを読み込む
		$ModelDungeon = new Model_Dungeon($this->userData);
		
		//受け取ったデータが「再開」だった場合はmainPageへ遷移
		//そうでない場合はselectLevelへ遷移する
		if($resume)
		{
			//DBからデータを取得する
			$dungeon = $ModelDungeon->getDungeonDb($this->userData['id']);
			Response::redirect(CONTENTS_URL . 'stage/mainPage');
		}
		else
		{
			//遷移前に、既に存在するカラムを削除する
			$ModelDungeon->deleteDungeonDb($this->userData['id']);
			Response::redirect(CONTENTS_URL . 'stage/selectLevel');
		}
		
	}
	
	public function action_mainPage()
	{
		//初期設定
		$ModelDungeon = new Model_Dungeon($this->userData);
		$database = $ModelDungeon->getDungeonDb($this->userData['id']);
		$ModelItem = new Model_Item($this->userData);
		
		if(empty($database))
		{
			Response::redirect(CONTENTS_URL . 'mypage');
		}
		$rank = $database["dungeonRank"];
		$id = $database["dungeonId"];
		$dungeonMap = $ModelDungeon->getDungeonMap($rank,$database["dungeonId"]);
		$dungeonData = $ModelDungeon->getDungeonData($rank,$id);
		$userItem['recover'] = $ModelItem->getByUserId(1);
		$userItem['ap'] = $ModelItem->getByUserId(2);
		
		//アイテムデータを結合
		$mstDataList['recover'] = array(
										array('mstData'=>$ModelItem->getItems(1), 'key'=>'itemId', 'mstKey'=>'id'),
									);
		$mstDataList['ap'] = array(
										array('mstData'=>$ModelItem->getItems(2), 'key'=>'itemId', 'mstKey'=>'id'),
									);
		$itemList['recover'] = $this->dataMarge($userItem['recover'], $mstDataList['recover']);
		$itemList['ap'] = $this->dataMarge($userItem['ap'], $mstDataList['ap']);
		//map
		$copyMap = array();
		foreach($dungeonMap as $dungeonLine)
		{
			$copyLine = $dungeonLine;
			unset($copyLine['id']);
			$copyMap[] = $copyLine;
		}
		
		$dungeonMap = $copyMap;
		$ap = $this->userData["ap"];
		
		
		if(!isset($database))
		{
			Response::redirect(CONTENTS_URL . 'stage/selectLevel');
		}
		else
		{
			$x = $database["x"];
			$y = $database["y"];
			$direction = $database["direction"];
			$ModelDungeon->updateDungeonDb($this->userData['id'],$x,$y,$direction);
		}
		
		if(substr($rank, 0, 1) == 'e')
		{
			$rankInfo = $ModelDungeon->getRankMaster(true);
			$rank = substr($rank, 1);
		}
		else
		{
			$rankInfo = $ModelDungeon->getRankMaster(false);
		}
		$stageData = $rankInfo[$rank];
		
		Config::load('enemy',true);
		$bossInfo = Config::get('enemy.e'.$ModelDungeon->getRankData($rank)['boss'][$id]);
		
		//アバター画像取得
		$ModelAvatar = new Model_Avatar();
		$userAvatar = $ModelAvatar->getMargeDataByUserId($this->userData['id'], null, 1);
		$avatarImg = array();
		$avatarImg[1] = 'avatar/body.png';
		foreach($userAvatar as $avatar)
		{
			switch($avatar['categoryId'])
			{
				case 'a':
					$avatarImg[0] = $avatar['img'];
					$avatarImg[5] = $avatar['img2'];
					break;
				case 'b':
					$avatarImg[2] = $avatar['img'];
					break;
				case 'c':
					$avatarImg[3] = $avatar['img'];
					if(empty($wordsList))
					{
						$wordsList = $ModelDungeon->getWordsMaster($avatar['battleWords']);
					}
					break;
				case 'd':
					$avatarImg[4] = $avatar['img'];
					break;
				case 'e':
					$avatarImg[6] = $avatar['img'];
					if(!empty($avatar['stageWords']))
					{
						$wordsList = $ModelDungeon->getWordsMaster($avatar['battleWords']);
					}
					break;
			}
		}
		if(empty($wordsList))
		{
			$wordsList = $ModelDungeon->getWordsMaster('normal');
		}
		//台詞置換用配列設定
		$replace = array(
						'[userName]' => $this->userData['name'],
					);
		//初期ログを設定
		$log = $this->getWords($wordsList, 'start', $replace);
		
		
		$this->viewData['log'] = $log;
		//アイテムviewdata
		$this->viewData['itemList'] = $itemList;
		//ダンジョンviewdata
		$this->viewData['dungeonMap'] = $dungeonMap;
		$this->viewData['userId'] = $this->userData['id'];
		$this->viewData['id'] = $id;
		$this->viewData['x'] = $x;
		$this->viewData['y'] = $y;
		$this->viewData['direction'] = $direction;
		$this->viewData['stageData'] = $stageData;
		$this->viewData['bossInfo'] = $bossInfo;
		$this->viewData['avatarImg'] = $avatarImg;
		$this->viewData['mapEvent'] = 0;
		$this->viewData['ap'] = $ap;
		
		
		View_Wrap::contents('stage/mainPage', $this->viewData);
		
	}

	//指定したランクのステージデータを読み込む
	public function action_selectRank($feeluck=false)
	{
		$ModelDungeon = new Model_Dungeon($this->userData);
		$ModelEvent = new Model_Event($this->userData);
		
		//ランク取得
		$rank = Input::post('dungeonRank');
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
		
		//ランクからステージデータを読み込む
		$rankData = $ModelDungeon->getRankData($rank);
		
		$this->viewData['stageData'] = $rankData['stage'];
		$this->viewData['rank'] = $rank;
		$this->viewData['feeluck'] = $feeluck;
		$this->viewData['progress'] = $progress;
		if($feeluck)
		{
			$rank = $ModelDungeon->getRankMaster();
			$count = count($rank);
			$this->viewData['rankData'] = $rank;
			$this->viewData['eventData'] = $ModelDungeon->getRankMaster(true);
			$this->viewData['count'] = $count;
			View_Wrap::contents('stage/selectLevel', $this->viewData,'modal');
		}
		else
		{
			View_Wrap::contents('stage/selectDungeon', $this->viewData);
		}
		
	}
	
	public function action_submit()
	{
		$ModelDungeon = new Model_Dungeon($this->userData);
		$database = $ModelDungeon->getDungeonDb($this->userData['id']);
		$ModelDungeon->updateDungeonDb($this->userData['id'],$database["x"],$database["y"],$database["direction"],1);
		
		//イベント進行度の更新
		if(substr($database['dungeonRank'], 0, 1) == 'e')
		{
			$ModelEvent = new Model_Event($this->userData);
			$eventId = substr($database['dungeonRank'], 1);
			$category = 1;
			
			$eventData = $ModelEvent->getByEventId($category, $eventId);
			if($eventData['isProgress'])
			{
				if(!$ModelEvent->getUserEvent($category, $eventId))
				{
					$ModelEvent->createUserEvent($category, $eventId);
				}
				$ModelEvent->updateUserEvent($category, $eventId, $database['dungeonId']);
			}
		}
		
		Response::redirect(CONTENTS_URL . 'stageclear');
	}

	public function action_dungeonStart($rank,$id,$death = 0)
	{
		$ModelDungeon = new Model_Dungeon($this->userData);
		$ModelUser = new Model_User($this->userData);
		
		$database = $ModelDungeon->getDungeonDb($this->userData['id']);
		$dungeonData = $ModelDungeon->getDungeonData($rank,$id);
		
		if(empty($database))
		{
			if($this->userData['money'] >= $dungeonData['fee'])
			{
				Config::load('stage/rank'.$rank,true);
				$fee = Config::get('stage/rank'.$rank.'.stage.'.$id.'.fee');
				$ModelUser->changeDifferenceMoney($fee*-1);
				$ModelDungeon->startDungeon($rank, $id);
				
				Response::redirect(CONTENTS_URL . 'stage/mainPage');
			}
			else
			{
				Response::redirect(CONTENTS_URL . 'stage/selectLevel/'.true);
			}
		}
		else
		{
			Response::redirect(CONTENTS_URL . 'stage/mainPage/');
		}
	}
	
	public function action_battle()
	{
		$pData = Input::post();
		$ModelDungeon = new Model_Dungeon($this->userData);
		$database = $ModelDungeon->getDungeonDb($this->userData['id']);
		$rank = $database["dungeonRank"];
		$level = $database["dungeonId"];
		$stageData = $ModelDungeon->getRankData($rank);
		
		//出現する敵データを取得
		if(empty($stageData['enemy'][0]))
		{
			$enemyList = array();
		}
		else
		{
			$enemyList = $stageData['enemy'][0];
		}
		if(!empty($stageData['enemy'][$level]))
		{
			$enemyList = array_merge($enemyList, $stageData['enemy'][$level]);
		}
		
		$totalRate = 0;
		if(empty($pData["bossFlg"]))
		{
			foreach($enemyList as $data)
			{
				$totalRate += $data['rate'];
			}
			$randomRate = mt_rand(0,$totalRate-1);
		
			foreach($enemyList as $data)
			{
				if($randomRate < $data['rate'])
				{
					$enemyData = $data;
					break;
				}
				else
				{
					$randomRate -= $data['rate'];
				}
			}
			$encountEnemy = $enemyData["enemyNum"];
			$boss = 0;
		}
		else
		{
			$encountEnemy = $stageData["boss"][$level];
			$boss = 1;
		}
		
		$model_Battle = new Model_Battle();

		$model_Battle->startBattle($this->userData['id'],$this->userData['hp'],$encountEnemy,$boss);
		Response::redirect(CONTENTS_URL . 'battle');
	}
	
	private function getWords($wordsList, $type, $replace)
	{
		foreach($wordsList as $words)
		{
			if($words['type'] == $type)
			{
				$result = $this->strReplaceAssoc($replace, $words['words']);
				break;
			}
		}
		if(empty($result))
		{
			throw new Exception("台詞が取得できません。");
		}
		
		return $result;
	}
}