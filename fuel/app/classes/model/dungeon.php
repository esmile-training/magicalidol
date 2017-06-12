<?php
class Model_Dungeon extends Model_Base_DbCsv
{
	const TABLE_NAME = 'userDungeon';
	
	/*
	  ダンジョン探索開始地点と向きを取得
	  $rank:ダンジョンランク
	  $id:ダンジョンID
	  return:array(x:X座標、y:Y座標、direction:向き)
	*/
	private function getStart($rank, $id)
	{
		$dungeonMap = $this->getDungeonMap($rank, $id);
		$dungeonData = $this->getDungeonData($rank, $id);
		$pos = array();
		
		foreach($dungeonMap as $y=>$mapLine)
		{
			foreach($mapLine as $x=>$mapPos)
			{
				if($x == "id")
				{
					continue;
				}
				if($mapPos == 2)
				{
					$pos["x"] = $x;
					$pos["y"] = $y-1;
					$pos["direction"] = $dungeonData["startDirection"];
					break;
				}
			}
			if(!empty($pos))
			{
				break;
			}
		}
		
		return $pos;
	}
	
	/*
	  ランクマスターを取得
	  $isEvent(bool):イベントフラグ(true:イベントマスター、false:通常マスター/default:false)
	*/
	public function getRankMaster($isEvent=false)
	{
		if($isEvent)
		{
			$rankList = $this->getAll('/dungeon/eventRank');
		}
		else
		{
			$rankList = $this->getAll('/dungeon/rank');
		}
		
		return $rankList;
	}
	
	/*
	  ダンジョンマップを取得
	  $rank:ダンジョンランク
	  $id:ダンジョンID
	*/
	public function getDungeonMap($rank,$id)
	{
		if(substr($rank, 0, 1) == 'e')
		{
			$dungeon = $this->getAll('/dungeon/event'.substr($rank, 1).'/'.$id);
		}
		else
		{
			$dungeon = $this->getAll('/dungeon/stage'.$rank.'/'.$id);
		}
		
		return $dungeon;
	}
	
	/*
	  ランクコンフィグデータを取得
	  $rank:ダンジョンランク
	*/
	public function getRankData($rank)
	{
		if(substr($rank, 0, 1) == 'e')
		{
			$rank = substr($rank, 1);
			log::debug("rank=".$rank);
			Config::load('stage/event'.$rank,true);
			$stageData = Config::get('stage/event'.$rank);
		}
		else
		{
			Config::load('stage/rank'.$rank,true);
			$stageData = Config::get('stage/rank'.$rank);
		}
		return $stageData;
	}
	
	/*
	  ダンジョンコンフィグデータを取得
	  $rank:ダンジョンランク
	  $id:ダンジョンID
	*/
	public function getDungeonData($rank,$id)
	{
		$rankData = $this->getRankData($rank);
		
		return $rankData['stage'][$id];
	}
	
	//dungeonのデータべースの初期設定をする
	public function setDungeonDb($userId,$dungeonRank,$DungeonId,$x,$y,$direction)
	{
		$sql = "INSERT INTO ".self::TABLE_NAME."(userId,dungeonRank,DungeonId,x,y,direction)";
		$sql .= "VALUES ($userId,'$dungeonRank',$DungeonId,$x,$y,$direction)";
		
		$result = $this->fetchFirst($sql);
		return $result;
	}
	
	public function startDungeon($dungeonRank, $dungeonId, $userId=null)
	{
		//ユーザーIDを設定
		if(is_null($userId))
		{
			if(empty($this->userData['id']))
			{
				throw new Exception('ユーザーIDが取得できません。');
				return false;
			}
			$userId = $this->userData['id'];
		}
		
		$startPos = $this->getStart($dungeonRank, $dungeonId);
		if(empty($startPos))
		{
			return false;
		}
		
		return $this->setDungeonDb($userId, $dungeonRank, $dungeonId, $startPos["x"], $startPos["y"], $startPos["direction"]);
	}
	
	//dungeonのデータべースから情報を取得する
	public function getDungeonDb($userId=null)
	{
		//ユーザーIDを設定
		if(is_null($userId))
		{
			if(empty($this->userData['id']))
			{
				throw new Exception('ユーザーIDが取得できません。');
				return false;
			}
			$userId = $this->userData['id'];
		}
		$sql = "SELECT * FROM ".self::TABLE_NAME." ";
		$sql .= "WHERE userId = $userId";
		
		$result = $this->fetchFirst($sql);
		return $result;
	}
	//dungeonのデータべースを更新する
	public function updateDungeonDb($userId,$x,$y,$direction,$clear=0)
	{
		$sql = "UPDATE ".self::TABLE_NAME." ";
		$sql .= "SET x = $x,y = $y,direction = $direction,clear = $clear ";
		$sql .= "WHERE userId = $userId;";
		
		$result = $this->fetchFirst($sql);
		return $result;
	}
	//dungeonのデータベースを削除する
	public function deleteDungeonDb($userId=null)
	{
		//ユーザーIDを設定
		if(is_null($userId))
		{
			if(empty($this->userData['id']))
			{
				throw new Exception('ユーザーIDが取得できません。');
				return false;
			}
			$userId = $this->userData['id'];
		}
		$sql = "DELETE FROM ".self::TABLE_NAME." ";
		$sql .= "WHERE userId = $userId";
		
		$result = $this->fetchFirst($sql);
		return $result;
	}
	//ボス撃破フラグを更新
	public function changeDungeonBossFlg($userId=null)
	{
		//ユーザーIDを設定
		if(is_null($userId))
		{
			if(empty($this->userData['id']))
			{
				throw new Exception('ユーザーIDが取得できません。');
				return false;
			}
			$userId = $this->userData['id'];
		}
		$sql = "UPDATE ".self::TABLE_NAME;
		$sql .= " SET winBoss=1";
		$sql .= " WHERE userId=$userId;";
		
		$result = $this->fetchFirst($sql);
		return $result;
	}
	//台詞集の取得
	public function getWordsMaster($type)
	{
		$wordsList = $this->getAll('/stage/words/'.$type);
		
		return $wordsList;
	}
}