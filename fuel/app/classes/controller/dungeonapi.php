<?php
class Controller_DungeonApi extends Lib_Api
{
	public function post_walk()
	{
		try
		{
			log::debug("データ取得");
			//データ取得
			$inputData = Input::json();
			
			//初期設定
			$userData = $this->userData;
			$ModelDungeon = new Model_Dungeon($userData);
			$ModelUser = new Model_User($userData);
			$ModelBattle = new Model_Battle($userData);
			$ModelAvatar = new Model_Avatar();
			$userAvatar = $ModelAvatar->getMargeDataByUserId($this->userData['id'], null, 1);
			$userStatus['name'] = $userData['name'];
			
			$wall = false;
			
			if(empty($this->userData['id']))
			{
				throw new Exception("入力データが不正です。errorId3");
			}
			else
			{
				$userId = $this->userData['id'];
			}
			
			$isBattle = $ModelBattle->isBattle();
			if($isBattle)
			{
				throw new Exception("戦闘中です。");
			}
			
			if($inputData["direction"] > 4 || $inputData["direction"] < 0)
			{
				throw new Exception("入力データが不正です。errorId4");
			}
			else
			{
				$direction = $inputData["direction"];
				if(empty($direction))
				{
					$direction = 0;
				}
			}
			
			$database = $ModelDungeon->getDungeonDb($userData['id']);
			
			$level = $database["dungeonRank"];
			$id = $database["dungeonId"];
			$dungeonMap = $ModelDungeon->getDungeonMap($level,$id);
			$dungeonData = $ModelDungeon->getDungeonData($level,$id);
			if(substr($level, 0, 1) == 'e')
			{
				$rankInfo = $ModelDungeon->getRankMaster(true);
				$level = substr($level, 1);
			}
			else
			{
				$rankInfo = $ModelDungeon->getRankMaster(false);
			}
			$copyMap = array();
			foreach($dungeonMap as $dungeonLine)
			{
				$copyLine = $dungeonLine;
				unset($copyLine['id']);
				$copyMap[] = $copyLine;
			}
			
			$dungeonMap = $copyMap;
			
			$x = $database['x'];
			$y = $database['y'];
			switch($direction)
			{
				case 0:
				{
					if($dungeonMap[$y-1][$x] !=0 )
					{
						$y-=1;
					}
					else
					{
						$wall = true;
						throw new Exception("壁です。");
					}
					break;
				}
				case 1:
				{
					if($dungeonMap[$y][$x+1] !=0 )
					{
						$x+=1;
					}
					else
					{
						$wall = true;
						throw new Exception("壁です。");
					}
					break;
				}
				case 2:
				{
					if($dungeonMap[$y+1][$x] !=0 )
					{
						$y+=1;
					}
					else
					{
						$wall = true;
						throw new Exception("壁です。");
					}
					break;
				}
				case 3:
				{
					if($dungeonMap[$y][$x-1] !=0 )
					{
						$x-=1;
					}
					else
					{
						$wall = true;
						throw new Exception("壁です。");
					}
					break;
				}
				
				default:break;
			}
			//Apを減らす
			$ap = $userData["ap"] -1;
			
			if($ap < 0)
			{
				throw new Exception("Apが足りません。");
			}
			
			$item = 0;
			$battle = 0;
			if($database['x'] != $x || $database['y'] != $y )
			{
				
				if($dungeonMap[$y][$x] == 1)
				{
					$event = $ModelDungeon->getDungeonData($level,$id);
					
					$totalRate = 0;
					foreach($event['event'] as $rate)
					{
						$totalRate += $rate;
					}
					$randomRate = mt_rand(0,$totalRate-1);
				
					
					$count = 0;
					foreach($event['event'] as $rate)
					{
						if($randomRate < $rate)
						{
							$mapEvent = $count;
							break;
						}
						else
						{
							$randomRate -= $rate;
							$count++;
						}
					}
					switch($mapEvent)
					{
						//アイテムを入手した時
						case 1: $item = 1; break;
						//バトルに入ったとき
						case 2: $battle = 1;break;
						
						default: break;
					}
				}
					//ゴール判定
				if($dungeonMap[$y][$x] == 3)
				{
					$goalFlg = 1;
					$battle = 0;
				}
				else
				{
					$goalFlg = 0;
				}
				//ボス判定
				if($dungeonMap[$y][$x] >= 4 && $database["winBoss"] == 1)
				{
					$boss = 1;
					$battle = 1;
				}
				else
				{
					$boss = 0;
				}
				if($item > 0)
				{
					$this->getItem($userId,$level,$id);
				}
				
				$ModelUser->changeAp($ap);
				Config::load('enemy',true);
				$bossInfo = Config::get('enemy.e'.$ModelDungeon->getRankData($database["dungeonRank"])['boss'][$id]);
				//log::debug(Config::get('enemy.e' + $ModelDungeon->getRankData($level)['boss'][$id]));
				//歩いた情報をDBに保存しておく
				$ModelDungeon->updateDungeonDb($inputData["userId"],$x,$y,$direction,$goalFlg);
				
			}
			
			//log
			if(empty($userAvatar))
			{
				throw new Exception("装備中のアバターデータが不正です。");
			}
				//台詞置換用配列設定
			$replace = array(
					'[userName]' => $this->userData['name'],
				);
			foreach($userAvatar as $avatar)
			{
				if(($avatar['categoryId']=='e') && !empty($avatar['battleWords']))
				{
					$wordsList = $ModelDungeon->getWordsMaster($avatar['battleWords']);
				}
				if(empty($wordsList) && ($avatar['categoryId']=='c'))
				{
					$wordsList = $ModelDungeon->getWordsMaster($avatar['battleWords']);
				}
			}
			if(empty($wordsList))
			{
				$wordsList = $ModelDungeon->getWordsMaster('normal');
			}
			//$logList = array();
			$wordNum = mt_rand(0, 8);
			switch($wordNum)
			{
				case 0:
					$word = $this->getWords($wordsList, 'wlkDun0', $replace);
					break;
				case 1:
					$word = $this->getWords($wordsList, 'wlkDun1', $replace);
					break;
				case 2:
					$word = $this->getWords($wordsList, 'wlkDun2', $replace);
					break;
				case 3:
					$word = $this->getWords($wordsList, 'wlkDun3', $replace);
					break;
				case 4:
					$word = $this->getWords($wordsList, 'wlkDun4', $replace);
					break;
				default:
					$word = $this->getWords($wordsList, 'default', $replace);
					break;
			}
			
			$result = array(
							"result" => true,//
							"north" => $dungeonMap[$y-1][$x],//
							"east" => $dungeonMap[$y][$x+1],//
							"south" => $dungeonMap[$y+1][$x],//
							"west" => $dungeonMap[$y][$x-1],//
							"goalFlg" => $goalFlg,
							"ap" => $ap,
							"passImg"=>$rankInfo[$level]["passImage"],
							"notPassImg"=>$rankInfo[$level]["notpassImage"],
							"goalImg"=>$rankInfo[$level]["goal"],
							"battle" => $battle,
							"boss" => $boss,
							"getItem" => $item,
							"startImg"=>"dungeonBack/start.png",
							"bossImg"=>$bossInfo["file"],
							"log" => $word,
						);
			return $this->response($result);
		}
		catch(Exception $e)
		{
			$result = array(
							"result" => false,
							"wall" => $wall,
							"isBattle" => $isBattle,
							"message" => $e->getMessage(),
						);
			return $this->response($result);
		}
	}
	
	public function getItem($userId,$level,$id)
	{
		$ModelDungeon = new Model_Dungeon($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		
		$drop = $ModelDungeon->getDungeonData($level,$id);
		$totalRate = 0;
		foreach($drop['drop'] as $data)
		{
			$totalRate += $data['rate'];
		}
		$randomRate = mt_rand(0,$totalRate-1);
		foreach($drop['drop'] as $data)
		{
			if($randomRate < $data['rate'])
			{
				$item = $data;
				break;
			}
			else
			{
				$randomRate -= $data['rate'];
			}
		}
		
		$ModelPresent->setToPost($item['category'],$item['id'],mt_rand($item['countMin'],$item['countMax']));
	}
	
	public function post_useItem()
	{
		try
		{
			//データ取得
			$inputData = Input::json();
			
			//初期設定
			$userData = $this->userData;
			$ModelItem = new Model_Item($userData);
			$ModelUser = new Model_User($userData);
			$ModelBattle = new Model_Battle($userData);
			
			$isBattle = $ModelBattle->isBattle();
			if($isBattle)
			{
				throw new Exception("戦闘中です。");
			}
			if($inputData['type'] == 1)
			{
				$value = $userData["hp"] + $inputData['value'];
				$ModelUser->changeHp($value);
			}
			else if($inputData['type'] == 2)
			{
				$value = $userData["ap"] +$inputData['value'] ;
				$ModelUser->changeAp($value);
			}
			$ModelItem->useItem($inputData['id'], $inputData['type'], $userData['id']);
			$result = array(
							"result" => true,
							"type" => $inputData['type'],
							"value" =>$value,
						);
			return $this->response($result);
		}
		catch(Exception $e)
		{
			$result = array(
							"result" => false,
							"isBattle" => $isBattle,
							"message" => $e->getMessage(),
						);
			return $this->response($result);
		}
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