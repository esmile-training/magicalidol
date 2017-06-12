<?php
class Controller_Battle extends Lib_Contents
{
	public function action_index()
	{
		//初期設定
		$ModelBattle = new Model_Battle();
		$ModelDungeon = new Model_Dungeon();
		$ModelAvatar = new Model_Avatar();
		$ModelItem = new Model_Item($this->userData);
		Config::load('enemy', true);
		
		//戦闘中でない場合はマイページにリダイレクト
		if(!$ModelBattle->isBattle($this->userData['id']))
		{
			Response::redirect(CONTENTS_URL.'mypage');
			return;
		}
		
		//データ取得
		$battleData = $ModelBattle->getById($this->userData['id']);
		$stageData = $ModelDungeon->getDungeonDb($this->userData['id']);
		$enemyData = Config::get("enemy.e".$battleData['enemyId']);
		$userAvatar = $ModelAvatar->getMargeDataByUserId($this->userData['id'], null, 1);
		$userItem['recover'] = $ModelItem->getByUserId(1);
		$userItem['battle'] = $ModelItem->getByUserId(3);
		
		//ダンジョンデータが存在しない場合は戦闘を強制終了してマイページにリダイレクト
		if(empty($stageData))
		{
			$ModelBattle->endBattle($this->userData['id']);
			Response::redirect(CONTENTS_URL.'mypage');
			return;
		}
		
		if(substr($stageData['dungeonRank'], 0, 1) == 'e')
		{
			$stageData['dungeonRank'] = substr($stageData['dungeonRank'], 1);
			$rankMst = $ModelDungeon->getRankMaster(true);
		}
		else
		{
			$rankMst = $ModelDungeon->getRankMaster(false);
		}
		
		//背景画像取得
		foreach($rankMst as $mst)
		{
			if($stageData['dungeonRank'] == $mst['rank'])
			{
				$bgImg = $mst['passImage'];
				break;
			}
		}
		if(empty($bgImg))
		{
			//エラー処理
			$ModelBattle->endBattle($this->userData['id']);
			Response::redirect(CONTENTS_URL.'mypage');
		}
		
		//アバター画像取得
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
						$wordsList = $ModelBattle->getWordsMaster($avatar['battleWords']);
					}
					break;
				case 'd':
					$avatarImg[4] = $avatar['img'];
					break;
				case 'e':
					$avatarImg[6] = $avatar['img'];
					if(!empty($avatar['battleWords']))
					{
						$wordsList = $ModelBattle->getWordsMaster($avatar['battleWords']);
					}
					break;
			}
		}
		if(empty($wordsList))
		{
			$wordsList = $ModelBattle->getWordsMaster('normal');
		}
		
		//アイテムデータを結合
		$mstDataList['recover'] = array(
										array('mstData'=>$ModelItem->getItems(1), 'key'=>'itemId', 'mstKey'=>'id'),
									);
		$mstDataList['battle'] = array(
										array('mstData'=>$ModelItem->getItems(3), 'key'=>'itemId', 'mstKey'=>'id'),
									);
		$itemList['recover'] = $this->dataMarge($userItem['recover'], $mstDataList['recover']);
		$itemList['battle'] = $this->dataMarge($userItem['battle'], $mstDataList['battle']);
		//使用中アイテムデータを取得
		$useItem = null;
		foreach($ModelItem->getItems(3) as $item)
		{
			if($battleData['itemFlg'] == $item['id'])
			{
				$useItem = $item;
				switch($useItem['status'])
				{
					case 'atk':
						$useItem['buffImg'] = 'battle/buff_attack.png';
						break;
					case 'def':
						$useItem['buffImg'] = 'battle/buff_defence.png';
						break;
					case 'avd':
						$useItem['buffImg'] = 'battle/buff_avoidance.png';
						break;
				}
				break;
			}
		}
		
		//使用中スキルのバフデータを設定
		$skillBuff = null;
		switch($battleData['skillFlg'])
		{
			case 2: //ためる
				$skillBuff = array(
					'value' => 2,
					'buffImg' => 'battle/buff_attack.png',
				);
				break;
		}
		
		//敵ﾃﾞｰﾀ取得
		$enemyImg = $enemyData['file'];
		$enemyName = $enemyData['name'];
		
		//台詞置換用配列設定
		$replace = array(
						'[userName]' => $this->userData['name'],
						'[enemyName]' => $enemyData['name'],
						'[skillName]' => '',
						'[itemName]' => '',
						'[damage]' => 0,
						'[recover]' => 0,
						'[count]' => 0,
						'[value]' => 0,
					);
		//初期ログを設定
		$log = $this->getWords($wordsList, 'encEnm', $replace);
		
		$this->viewData['bgImg'] = $bgImg;
		$this->viewData['enemyImg'] = $enemyImg;
		$this->viewData['log'] = $log;
		$this->viewData['hpNow'] = $battleData['hpNow'];
		$this->viewData['hpMax'] = $this->userData['hpMax'];
		$this->viewData['skillFlg'] = $battleData['skillFlg'];
		$this->viewData['skillBuff'] = $skillBuff;
		$this->viewData['useItem'] = $useItem;
		$this->viewData['avatarImg'] = $avatarImg;
		$this->viewData['itemList'] = $itemList;
		$this->viewData['battleSpeed'] = $this->userData['battleSpeed'];
		
		View_Wrap::noheader('battle/top', $this->viewData);
	}
	
	public function action_end($battleFlg)
	{
		$ModelDungeon = new Model_Dungeon($this->userData);
		$stageData = $ModelDungeon->getDungeonDb($this->userData['id']);
		
		if(empty($stageData))
		{
			Response::redirect(CONTENTS_URL.'mypage');
		}
		else
		{
			if($battleFlg == 2)
			{
				$ModelDungeon->deleteDungeonDb($stageData['userId']);
				$ModelDungeon->startDungeon($stageData['dungeonRank'], $stafeData['dungeonId']);
			}
			Response::redirect(CONTENTS_URL.'stage/mainpage');
		}
	}
	
	/*
	  台詞集から台詞を取得
	  $wordsList(array):台詞集
	  $type(string):台詞種類
	  $replace(array):置き換え文字配列
	  return:string
	*/
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
