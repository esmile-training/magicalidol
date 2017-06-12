<?php
class Controller_BattleApi extends Lib_Api
{
	/*
	  戦闘処理
	  連想配列をJson形式でPost
	  actionType(int):キャラクター行動設定(1:助言、2:スキル使用、3:アイテム使用)
	  advice(array):助言行動時データ(助言行動時のみ)
		type(int):助言タイプ
	  skill(array):スキル使用行動時データ(スキル使用時のみ)
		id(int):スキルID
	  item(array):アイテム使用行動データ(アイテム使用時のみ)
		type(int):アイテム種類
		id(int):アイテムID
	  
	  return:json
	  result(bool):エラー判定(true:正常終了、false:異常終了)
	  message(string):エラーメッセージ(異常終了時のみ)
	  battleFlg(int):戦闘継続フラグ(0:戦闘継続、1:戦闘勝利、2:戦闘敗北)
	  dropItem(array):敵撃破時ドロップアイテム(戦闘勝利時のみ)
		category(int):ドロップカテゴリー
		name(string):アイテム名
		count(int):個数
		id(int):アイテムID
	  log(array):戦闘ログ(二次元配列:新しい行動ほど添え字が大きい)
		actor(int):行動キャラクター(0:システムアナウンス、1:ユーザー, 2:敵)
		actionType(int):キャラクター行動種別(0:攻撃、1:助言、2:スキル使用、3:アイテム使用)
		isWin(bool):戦闘勝利判定(true:戦闘勝利、false:戦闘敗北/システムアナウンスかつ戦闘終了時のみ)
		advice(array):助言行動時データ(助言行動時のみ)
		  type(int):助言タイプ
		skill(array):スキル使用行動時データ(スキル使用時のみ)
		  id(int):スキルID
		  dropCategory(int):ドロップアイテムカテゴリ(「盗む」使用時のみ)
		  dropItem(int):ドロップアイテムID(「盗む」使用時のみ)
		  dropCount(int):ドロップアイテム個数(「盗む」使用時のみ)
		item(array):アイテム使用行動データ(アイテム使用時のみ)
		  type(int):アイテム種類
		  id(int):アイテムID
		  status(string):バフステータス(戦闘補助アイテムのみ)
		  value(int):バフステータス上昇量(戦闘補助アイテムのみ)
		recover(int):回復量
		damage(int):ダメージ
		message(string):ログメッセージ
	*/
	public function post_battle()
	{
		//初期設定
		Config::load('enemy', true);
		$ModelBattle = new Model_Battle();
		$ModelUser = new Model_User();
		$ModelWeapon = new Model_weapon();
		$ModelArmor = new Model_armor();
		$ModelAvatar = new Model_Avatar();
		$ModelItem = new Model_Item($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		$battleFlg = 0; //戦闘継続フラグ(0:戦闘継続、1:戦闘勝利、2:戦闘敗北)
		$logList = array();
		$adviceRate = 1.2; //助言時ステータス上昇率
		
		try
		{
			//データ取得
			$inputData = Input::json();
			if(empty($inputData))
			{
				throw new Exception("入力データが不正です。");
			}
			
			if( empty($this->userData) || $this->userData['id']==0)
			{
				throw new Exception("ユーザーIDが不正です。");
			}
			
			$userData = $ModelUser->getById($this->userData['id']);
			$battleData = $ModelBattle->getById($this->userData['id']);
			if(empty($battleData) || empty($userData))
			{
				throw new Exception("ユーザーIDが不正です。");
			}
			$userWeapon = $ModelWeapon->getMargeDataByUserId($this->userData['id'], 0, 1);
			$userWeapon = array_shift($userWeapon);
			if(empty($userWeapon))
			{
				throw new Exception("装備中の武器データが不正です。");
			}
			$userArmor = $ModelArmor->getByUserId($this->userData['id'], 1);
			$userArmor = array_shift($userArmor);
			if(empty($userArmor))
			{
				throw new Exception("装備中の防具データが不正です。");
			}
			$userAvatar = $ModelAvatar->getMargeDataByUserId($this->userData['id'], null, 1);
			if(empty($userAvatar))
			{
				throw new Exception("装備中のアバターデータが不正です。");
			}
			$itemMst = $ModelItem->getItems(3);
			
			//ユーザーのステータスを設定
			$userStatus['name'] = $userData['name'];
			$userStatus['hpMax'] = $userData['hpMax'];
			$userStatus['hp'] = $battleData['hpNow'];
			$userStatus['attack'] = $userWeapon['status'];
			$userStatus['diffence'] = $userArmor['status'];
			$userStatus['luckPoint'] = 0;
			foreach($userAvatar as $avatar)
			{
				$userStatus['luckPoint'] += $avatar['luckPoint'];
				if(($avatar['categoryId']=='e') && !empty($avatar['battleWords']))
				{
					$wordsList = $ModelBattle->getWordsMaster($avatar['battleWords']);
				}
				if(empty($wordsList) && ($avatar['categoryId']=='c'))
				{
					$wordsList = $ModelBattle->getWordsMaster($avatar['battleWords']);
				}
			}
			if(empty($wordsList))
			{
				$wordsList = $ModelBattle->getWordsMaster('normal');
			}
			//アイテム使用中チェック
			$itemFlg = $battleData['itemFlg'];
			if($itemFlg)
			{
				foreach($itemMst as $item)
				{
					if($itemFlg == $item['id'])
					{
						$useItem = $item;
						break;
					}
				}
				switch($useItem['status'])
				{
					case 'atk':
						$userStatus['attack'] *= $useItem['value'];
						break;
					case 'def':
						$userStatus['diffence'] *= $useItem['value'];
						break;
					case 'avd':
						$userStatus['luckPoint'] *= $useItem['value'];
						break;
					default:
						break;
				}
			}
			//スキル継続中チェック
			$skillFlg = $battleData['skillFlg'];
			if($skillFlg == 2)
			{
				$userStatus['attack'] *= 2;
				$skillFlg = 0;
			}
			
			//敵のステータスを設定
			$enemyStatus = Config::get('enemy.e'.$battleData['enemyId']);
			$enemyStatus['hp'] = $battleData['hpEnemy'];
			
			//台詞置換用配列設定
			$replace = array(
							'[userName]' => $userStatus['name'],
							'[enemyName]' => $enemyStatus['name'],
							'[skillName]' => '',
							'[itemName]' => '',
							'[damage]' => 0,
							'[recover]' => 0,
							'[count]' => 0,
							'[value]' => 0,
						);
			
			//ユーザーキャラクターの行動
			if(empty($inputData['actionType']))
			{
				throw new Exception("キャラクターの行動設定が不正です。");
			}
			switch($inputData['actionType'])
			{
				case 1: //助言
					if(empty($inputData['advice']['type']))
					{
						throw new Exception("助言タイプが不正です。");
					}
					$log['actor'] = 1;
					$log['actionType'] = 1;
					switch($inputData['advice']['type'])
					{
						case 1: //攻撃助言
							$userStatus['attack'] *= $adviceRate;
							$log['message'] = $this->getWords($wordsList, 'advAtk', $replace);
							break;
						case 2: //防御助言
							$userStatus['diffence'] *= $adviceRate;
							$log['message'] = $this->getWords($wordsList, 'advDef', $replace);
							break;
						case 3: //回避助言
							$userStatus['luckPoint'] *= $adviceRate;
							$log['message'] = $this->getWords($wordsList, 'advAvd', $replace);
							break;
						default:
							throw new Exception("助言タイプが不正です。");
							break;
					}
					$logList[] = $log;
					unset($log);
					
					//攻撃処理
					$log['actor'] = 1;
					$log['actionType'] = 0;
					if($this->checkAvoid($enemyStatus['luck']))
					{ //回避
						$log['message'] = $this->getWords($wordsList, 'avdEnm', $replace);
					}
					else
					{ //命中
						//ダメージ計算
						$damage = $this->calcDamage($userStatus['attack'], $enemyStatus['diffence']);
						$enemyStatus['hp'] -= $damage;
						$replace['[damage]'] = $damage;
						
						$log['damage'] = $damage;
						$log['message'] = $this->getWords($wordsList, 'dmgUsr', $replace);
					}
					$logList[] = $log;
					unset($log);
					break;
				case 2: //スキル
					if(empty($inputData['skill']['id']))
					{
						$skillId = $userWeapon['skillId'];
					}
					else
					{
						$skillId = $inputData['skill']['id'];
					}
					$ModelSkill = new Model_skill();
					$skillMst = $ModelSkill->getMaster();
					//スキル名の取得
					foreach($skillMst as $skill)
					{
						if($skill['id'] == $skillId)
						{
							$skillName = $skill['name'];
							$replace['[skillName]'] = $skillName;
							break;
						}
					}
					if(empty($skillName))
					{
						throw new Exception("スキルIDが不正です。");
					}
					
					$log['actor'] = 0;
					$log['message'] = $this->getWords($wordsList, 'sklUse', $replace);
					$logList[] = $log;
					unset($log);
					
					$log['actor'] = 1;
					$log['actionType'] = 2;
					$log['skill']['id'] = (int)$skillId;
					switch($skillId)
					{
						case 1: //突撃(攻撃力2倍・防御力0)
							$userStatus['attack'] *= 2;
							$userStatus['diffence'] = 0;
							if($this->checkAvoid($enemyStatus['luck']))
							{
								$log['message'] = $this->getWords($wordsList, 'skl01F', $replace);
							}
							else
							{
								$damage = $this->calcDamage($userStatus['attack'], $enemyStatus['diffence']);
								$enemyStatus['hp'] -= $damage;
								$replace['[damage]'] = $damage;
								
								$log['damage'] = $damage;
								$log['message'] = $this->getWords($wordsList, 'skl01S', $replace);
							}
							break;
							
						case 2: //ためる(次ターン攻撃力2倍)
							$log['message'] = $this->getWords($wordsList, 'skl02S', $replace);
							$userStatus['attack'] *= 2;
							$skillFlg = 2;
							break;
							
						case 3: //デス(確率で無条件勝利)
							$rate = $this->calcDamage($userStatus['attack'], $enemyStatus['diffence']);
							if(!$battleData['bossFlg'] && (mt_rand(0, 99) < $rate))
							{
								$damage = $enemyStatus['hp'];
								$enemyStatus['hp'] -= $damage;
								
								$log['damage'] = $damage;
								$log['message'] = $this->getWords($wordsList, 'skl03S', $replace);
							}
							else
							{
								$log['message'] = $this->getWords($wordsList, 'skl03F', $replace);
							}
							break;
							
						case 4: //盗む(確率で素材アイテムを獲得)
							$rate = $this->calcDamage($userStatus['attack'], $enemyStatus['diffence']) * 3;
							if(!$battleData['bossFlg'] && (mt_rand(0, 99) < $rate))
							{
								$drop = $this->getDrop($enemyStatus);
								$replace['[itemName]'] = $drop['name'];
								$replace['[count]'] = $drop['count'];
								
								$log['message'] = $this->getWords($wordsList, 'skl04S', $replace);
							}
							else
							{
								$log['message'] = $this->getWords($wordsList, 'skl04F', $replace);
							}
							break;
						case 5: //ドレイン(与えたダメージの30％HPを回復)
							if($this->checkAvoid($enemyStatus['luck']))
							{
								$log['message'] = $this->getWords($wordsList, 'skl05F', $replace);
							}
							else
							{
								$damage = $this->calcDamage($userStatus['attack'], $enemyStatus['diffence']);
								if($enemyStatus['hp'] < $damage)
								{
									$recover = floor($enemyStatus['hp']*0.3);
								}
								else
								{
									$recover = floor($damage*0.3);
								}
								if($recover<1)
								{
									$recover = 1;
								}
								$enemyStatus['hp'] -= $damage;
								$userStatus['hp'] += $recover;
								$replace['[damage]'] = $damage;
								$replace['[recover]'] = $recover;
								
								$log['damage'] = $damage;
								$log['recover'] = $recover;
								$log['message'] = $this->getWords($wordsList, 'skl05S', $replace);
							}
							break;
						default:
							throw new Exception("使用スキルが不正です。");
					}
					$logList[] = $log;
					unset($log);
					break;
				case 3: //アイテム
					if(empty($inputData['item']['type']))
					{
						throw new Exception("アイテム種類が不正です。");
					}
					if(empty($inputData['item']['id']))
					{
						throw new Exception("アイテムIDが不正です。");
					}
					
					$itemMst = $ModelItem->getItems($inputData['item']['type']);
					foreach($itemMst as $item)
					{
						if($inputData['item']['id'] == $item['id'])
						{
							$useItem = $item;
							break;
						}
					}
					if(empty($useItem))
					{
						throw new Exception("使用アイテムIDが不正です。");
					}
					$replace['[itemName]'] = $useItem['name'];
					
					$log['actor'] = 0;
					$log['message'] = $this->getWords($wordsList, 'itmUse', $replace);
					$logList[] = $log;
					unset($log);
					
					$log['actor'] = 1;
					$log['actionType'] = 3;
					$log['item']['type'] = $inputData['item']['type'];
					$log['item']['id'] = $inputData['item']['id'];
					switch($inputData['item']['type'])
					{
						case 1: //回復アイテム
							if(empty($useItem['value']))
							{
								throw new Exception("使用アイテムマスタが不正です。");
							}
							$recover = $useItem['value'];
							if($recover > ($userStatus['hpMax']-$userStatus['hp']))
							{
								$recover = $userStatus['hpMax']-$userStatus['hp'];
							}
							$userStatus['hp'] += $recover;
							$replace['[recover]'] = $recover;
							$log['recover'] = $recover;
							$log['message'] = $this->getWords($wordsList, 'itmRcv', $replace);
							break;
						case 3: //補助アイテム
							switch($useItem['status'])
							{
								case 'atk': //攻撃力上昇アイテム
									$replace['[value]'] = $useItem['value'];
									$userStatus['attack'] *= $useItem['value'];
									$log['message'] = $this->getWords($wordsList, 'itmAtk', $replace);
									break;
								case 'def': //防御力上昇アイテム
									$replace['[value]'] = $useItem['value'];
									$userStatus['diffence'] *= $useItem['value'];
									$log['message'] = $this->getWords($wordsList, 'itmDef', $replace);
									break;
								case 'avd': //回避力上昇アイテム
									$replace['[value]'] = $useItem['value'];
									$userStatus['luckPoint'] *= $useItem['value'];
									$log['message'] = $this->getWords($wordsList, 'itmAvd', $replace);
									break;
								default:
									throw new Exception("使用アイテムマスタが不正です。");
									break;
							}
							$log['item']['status'] = $useItem['status'];
							$log['item']['value'] = $useItem['value'];
							$itemFlg = $useItem['id'];
							break;
						default:
							throw new Exception("使用アイテム種類が不正です。");
					}
					$logList[] = $log;
					unset($log);
					break;
				default:
					throw new Exception("キャラクターの行動設定が不正です。");
			}
			
			//戦闘継続判定
			if($enemyStatus['hp']<=0)
			{
				$battleFlg = 1;
				$log['actor'] = 0;
				$log['message'] = $this->getWords($wordsList, 'winUsr', $replace);
				$log['isWin'] = true;
				$logList[] = $log;
				unset($log);
			}
			
			if(!$battleFlg)
			{
				//敵キャラクターの行動
				$log['actor'] = 0;
				$log['message'] = $this->getWords($wordsList, 'atkEnm', $replace);
				$logList[] = $log;
				unset($log);
				
				$log['actor'] = 2;
				$log['actionType'] = 0;
				if($this->checkAvoid($userStatus['luckPoint']))
				{ //回避
					$log['message'] = $this->getWords($wordsList, 'avdUsr', $replace);
				}
				else
				{ //命中
					//ダメージ計算
					$damage = $this->calcDamage($enemyStatus['attack'], $userStatus['diffence']);
					$userStatus['hp'] -= $damage;
					$replace['[damage]'] = $damage;
					
					$log['damage'] = $damage;
					$log['message'] = $this->getWords($wordsList, 'dmgEnm', $replace);
				}
				$logList[] = $log;
				unset($log);
				
				//戦闘継続判定
				if($userStatus['hp']<=0)
				{
					$battleFlg = 2;
					$log['actor'] = 0;
					$log['message'] = $this->getWords($wordsList, 'winEnm', $replace);
					$log['isWin'] = false;
					$logList[] = $log;
					unset($log);
				}
			}
			
			//debug
			// foreach($logList as $log)
			// {
				// Log::debug($log['message']);
			// }
			//アイテム消費
			if($inputData['actionType'] == 3)
			{
				$ModelItem = new Model_Item($this->userData);
				$ModelItem->useItem($inputData['item']['id'], $inputData['item']['type'], $this->userData['id']);
			}
			//結果をDBに反映
			switch($battleFlg)
			{
				case 1: //戦闘勝利
					$ModelDungeon = new Model_Dungeon($this->userData);
					$ModelDungeon->changeDungeonBossFlg();
					//Log::debug("Run updateBattle");
					$ModelBattle->updateBattle($this->userData['id'], $userStatus['hp'], $enemyStatus['hp'], $skillFlg, $itemFlg);
					//Log::debug("Run endBattle");
					$hpDifference = $ModelBattle->endBattle($this->userData['id']);
					//Log::debug("Run recover");
					$ModelUser->recover($hpDifference, 1, $this->userData['id']);
					//Log::debug("Run getDrop");
					$dropItem = $this->getDrop($enemyStatus);
					//Log::debug("Run setToPost");
					$ModelPresent->setToPost($dropItem['category'], $dropItem['id'], $dropItem['count'],$dropItem['value'],$dropItem['char']);
					break;
				case 2: //戦闘敗北
					$ModelBattle->endBattle($this->userData['id']);
					$ModelUser->changeHp(1);
					break;
				default:
					$ModelBattle->updateBattle($this->userData['id'], $userStatus['hp'], $enemyStatus['hp'], $skillFlg, $itemFlg);
					break;
			}
			
			//戦闘中獲得アイテム反映
			if(!empty($drop))
			{
				$ModelPresent->setToPost($drop['category'], $drop['id'], $drop['count'], $drop['value'], $drop['char']);
			}
			
			//レスポンスを作成
			$result = array(
							"result" => true,
							"battleFlg" => $battleFlg,
							"log" => $logList,
						);
			if($battleFlg == 1)
			{
				$result['dropItem'] = $dropItem;
			}
		}
		catch(Exception $e)
		{ //エラー処理
			$result = array(
							"result" => false,
							"message" => "ERROR:".$e->getMessage(),
						);
		}
		
		return $this->response($result);
	}
	
	/*
	  ダメージ計算
	  $attack(int):攻撃側の攻撃力
	  $diffence(int):防御側の防御力
	  return(int):ダメージ量
	*/
	private function calcDamage($attack, $diffence=0)
	{
		//ダメージ倍率(0.8倍～1.2倍)
		$damageRate = (double)mt_rand(8, 12)/10;
		
		$damage = round((double)($attack-$diffence)/5*$damageRate);
		if($damage<=0)
		{
			$damage = 1;
		}
		
		return $damage;
	}
	
	/*
	  回避チェック
	  $luck(int):回避力
	  return:bool(true:回避成功、false:回避失敗)
	*/
	private function checkAvoid($luck=0)
	{
		$rate = log(1+$luck/10, 10)*20;
		if(mt_rand(0, 99) < $rate)
		{
			$result = true;
		}
		else
		{
			$result = false;
		}
		
		return $result;
	}
	
	/*
	  ドロップアイテムデータ取得
	  $count(int):個数
	  $category(int):ドロップカテゴリー
	  $id(int):アイテムID(default:0)
	  return:array
	*/
	private function getDropItemMargeData($count, $category, $id=0, $char="", $value=0)
	{
		// Log::debug("Run getDropMargeData");
		$ModelMaterial = new Model_Material();
		$ModelWeapon = new Model_weapon($this->userData);
		
		$dropItem = array(
						'category' => $category,
						'id' => $id,
						'char' => $char,
						'value' => $value,
						'count' => $count,
					);
		
		switch($category)
		{
			case 1: //お金
				$dropItem['name'] = 'お金';
				break;
			case 2: //素材
				$flg = false;
				$materialMst = $ModelMaterial->getMaster();
				foreach($materialMst as $mst)
				{
					if($mst['id'] == $id)
					{
						$dropItem['name'] = $mst['name'];
						$flg = true;
						break;
					}
				}
				if(!$flg)
				{
					throw new Exception("ドロップアイテムIDが不正です。");
				}
				break;
			case 3: //武器
				$flg = false;
				if(empty($char))
				{
					throw new Exception("ドロップ武器カテゴリが不正です。");
				}
				$weaponMst = $ModelWeapon->getMaster($char);
				foreach($weaponMst as $mst)
				{
					if($mst['id'] == $id)
					{
						$dropItem['name'] = $mst['name'];
						$flg = true;
						break;
					}
				}
				if(!$flg)
				{
					throw new Exception("ドロップアイテムIDが不正です。");
				}
				break;
			default:
				throw new Exception("ドロップアイテムカテゴリが不正です。");
				break;
		}
		
		return $dropItem;
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
	
	/*
	  ドロップアイテムを取得
	  $enemyStatus(array):敵データ
	  return:array
	*/
	private function getDrop($enemyStatus)
	{
		$dropItem = array();
		$totalRate = 0;
		foreach($enemyStatus['drop'] as $drop)
		{
			$totalRate += $drop['rate'];
		}
		$random = mt_rand(0, $totalRate-1);
		// Log::debug("Random:$random totalRate:$totalRate");
		foreach($enemyStatus['drop'] as $drop)
		{
			if($random < $drop['rate'])
			{
				$dropItem = $drop;
				break;
			}
			else
			{
				$random -= $drop['rate'];
				// Log::debug("Random:$random");
			}
		}
		if(empty($dropItem))
		{
			throw new Exception("ドロップテーブルが不正です。");
		}
		$dropCount = mt_rand($dropItem['countMin'], $dropItem['countMax']);
		return $this->getDropItemMargeData($dropCount, $dropItem['category'], $dropItem['id'], $dropItem['char'], $dropItem['value']);
	}
}
