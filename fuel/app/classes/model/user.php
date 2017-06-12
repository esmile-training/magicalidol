<?php
class Model_User extends Model_Base_Db
{
	const TABLE_NAME = 'user';
	
	/*
	  idで取得
	  $id:ID
	  return:array
	*/
	public function getById($id)
	{
		return $this->getByIdBase(self::TABLE_NAME, $id);
	}
	
	//最終更新時間を更新
	public function updateUpdateTime()
	{
		$value = array(
			'updateTime' => $this->nowTime
		);
		$where = array(
			'id' => $this->userData['id']
		);
		$result = DB::update(self::TABLE_NAME)->set($value)->where($where)->execute();
		return $result;
	}
	
	/*
	  HP・APを回復
	  $value(int):回復量
	  $type(int):回復タイプ(1:HP, 2:AP)
	*/
	public function recover($value, $type, $userId=null){
		if(is_null($userId))
		{
			$userStatus = $this->userData;
		}
		else
		{
			$userStatus = $this->getById($userId);
		}
		
		switch ($type) {
		case 1:
			$target = "hp";
			$targetMax = "hpMax";
			break;
		case 2:
			$target = "ap";
			$targetMax = "apMax";
			break;
		default:
			return false;
			break;
		}
		$result = $userStatus[$target] + $value;
		if($result > $userStatus[$targetMax])
		{
			$result = $userStatus[$targetMax];
		}
		
		$sql = "UPDATE ".self::TABLE_NAME." SET `".$target."` = '".$result."' ";
		$sql .= "WHERE id = ".$userStatus['id'];
		return $this->fetchFirst($sql);
	}
	
	/**
		$type :: HP(1)、AP(2)のどちらを回復するか
		$diffTime :: 回復する時間間隔。分単位で指定
	*/
	public function recoverByTime($type,$diffTime)
	{
		//typeによってどちらの更新時間を取得するか
		switch($type)
		{
			case 1:	//HP
				$target = 'hp';
				$updateTime = $this->userData['hpUpdateTime'];
				break;
			case 2:	//AP
				$target = 'ap';
				$updateTime = $this->userData['apUpdateTime'];
				break;
			default : 
				return false;
				break;
		}
		
		//経過時間(現在時間 - 最新更新時間))
		$elapsedTime = strtotime($this->userData['nowTime']) - strtotime($updateTime);
		//回復量(経過時間 / (60秒 * 間隔時間))
		$recoverValue = floor($elapsedTime / (60 * $diffTime));
		
		if(0<$recoverValue)
		{
			//余剰時間(回復量の余り))
			$surplusTime = $elapsedTime % (60 * $diffTime);	
			//回復関数呼び出し
			$this->recover($recoverValue,$type);
			//更新時間の更新
			$newTime = strtotime($this->userData['nowTime']) - $surplusTime;
			$sql = 'UPDATE '.self::TABLE_NAME.' SET '.$target.'UpdateTime = "'.date("Y-m-d H:i:s",$newTime).'"';
			$sql .= ' WHERE id = '.$this->userData['id'].';';
			$this->fetchFirst($sql);
		}
	}
	/*
	  所持金を差分値で更新
	  $userId(int):ユーザーID
	  $value(int):所持金増減額
	*/
	public function changeDifferenceMoney($value, $userId=null)
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
		$sql = "UPDATE ".self::TABLE_NAME." SET money = money+$value";
		$sql .= " WHERE id=$userId;";
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  HPを変更
	  $userId(int):ユーザーID
	  $value(int):HP更新値(絶対値)
	*/
	public function changeHp($value, $userId=null)
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
		
		$sql = "UPDATE ".self::TABLE_NAME." SET hp=".$value;
		$sql .= " WHERE id = ".$userId;
		return $this->fetchFirst($sql);
	}
	
	/*
	  APを変更
	  $userId(int):ユーザーID
	  $value(int):AP更新値(絶対値)
	*/
	public function changeAp($value, $userId=null)
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
		$sql = "UPDATE ".self::TABLE_NAME." SET ap=".$value;
		$sql .= " WHERE id = ".$userId;
		return $this->fetchFirst($sql);
	}
	
	/*
	  名前を変更
	  $userId(int):ユーザーID
	  $newNmae(string):変更したい名前
	*/
	public function changeName($userId, $newNmae)
	{
		
		$sql = "UPDATE ".self::TABLE_NAME." SET name = '".$newNmae ."'";
		$sql .= " WHERE id = ".$userId;
		return $this->fetchFirst($sql);
	}
	
	/*
	  戦闘速度を変更
	  $speed(double):戦闘速度
	  $userId(int):ユーザーID
	*/
	public function changeBattleSpeed($speed, $userId=null)
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
		
		$sql = "UPDATE ".self::TABLE_NAME." SET battleSpeed=$speed";
		$sql .= " WHERE id=$userId;";
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  ユーザーデータを挿入
	  $userId:ユーザーID
	  $userName:ユーザー名
	*/
	public function insertUser($userId, $userName)
	{
		$sql = "INSERT INTO ".self::TABLE_NAME;
		$sql .= " SET id=$userId, name='$userName';";
		
		return $this->fetchFirst($sql);
	}
}