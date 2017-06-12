<?php
class Model_Battle extends Model_Base_DbCsv
{
	const TABLE_NAME = 'userBattle';
	
	/*
	  idで取得
	  $id:ID
	  return:array
	*/
	public function getById($id)
	{
		return $this->getByIdBase(self::TABLE_NAME, $id);
	}
	
	/*
	  戦闘中判定
	  $userId:ユーザーID
	  return:bool
	 */
	public function isBattle($userId=null)
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
		
		$result = true;
		$data = $this->getById($userId);
		
		if(empty($data))
		{
			$result = false;
		}
		
		return $result;
	}
	
	/*
	  戦闘開始時処理
	  $userId:ユーザーID
	  $hpUser:ユーザーのHP
	  $enemyID:遭遇エネミーID
	  $bossFlg:ボスフラグ
	*/
	public function startBattle($userId, $hpUser, $enemyId, $bossFlg=0)
	{
		if(!$this->isBattle($userId))
		{
			Config::load('enemy', true);
			$enemyStatus = Config::get("enemy.e".$enemyId);
			$hpEnemy = $enemyStatus['hp'];
			
			$sql = "INSERT INTO " . self::TABLE_NAME;
			$sql .= " SET id=$userId, hpStart=$hpUser, hpNow=$hpUser, enemyId='$enemyId', hpEnemy=$hpEnemy, bossFlg=$bossFlg;";
			$this->fetchFirst($sql);
		}
		
		return;
	}
	
	/*
	  戦闘継続時更新処理
	  $userId:ユーザーID
	  $hpNow:ユーザーの現在HP
	  $hpEnemy:敵の現在HP
	  $skillFlg:スキルフラグ
	  $itemFlg:アイテムフラグ
	*/
	public function updateBattle($userId, $hpNow, $hpEnemy, $skillFlg=NULL, $itemFlg=NULL)
	{
		$sql = "UPDATE " . self::TABLE_NAME;
		$sql .= " SET hpNow=$hpNow, hpEnemy=$hpEnemy";
		if(!is_null($skillFlg))
		{
			$sql .= ", skillFlg=$skillFlg";
		}
		if(!is_null($itemFlg))
		{
			$sql .= ", itemFlg=$itemFlg";
		}
		$sql .= " WHERE id=$userId;";
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  戦闘終了時処理
	  $userId(int):ユーザーID
	  return:int(戦闘開始時から戦闘終了時のHP差分)
	*/
	public function endBattle($userId)
	{
		//HP差分値を取得
		$battleData = $this->getById($userId);
		$hpDifference = $battleData['hpNow'] - $battleData['hpStart'];
		
		//DBを削除
		$sql = "DELETE FROM " . self::TABLE_NAME;
		$sql .= " WHERE id=$userId;";
		$this->fetchFirst($sql);
		
		return $hpDifference;
	}
	
	//台詞集の取得
	public function getWordsMaster($type)
	{
		$wordsList = $this->getAll('/battle/words/'.$type);
		
		return $wordsList;
	}
}