<?php
class Model_Room extends Model_Base_DbCsv
{
	const TABLE_NAME = 'userRoom';
	
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
	  idで削除
	*/
	public function deleteById($id)
	{
		return $this->deleteByIdBase(self::TABLE_NAME, $id);
	}
	
	/*
	  ユーザーが所持している部屋を取得
	  $userId:ユーザーID
	  $equip:装備フラグ
	*/
	public function getByUserId($userId=null, $equip=null)
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
		
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE userId=$userId";
		if(!is_null($equip))
		{
			$sql .= " AND roomFlg=$equip";
		}
		
		return $this->fetchAll($sql);
	}
	
	/** 指定したユーザーが現在設定している部屋を1つ取得 */
	public function getEqpRoomById($userId=null)
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
		
		$roomData = $this->getByUserId($userId, 1);
		
		$mstData = $this->getRoomData();
		$mstDataList = array(
			array('mstData'=>$mstData, 'key'=>'roomId', 'mstKey'=>'id'),
		);
		$roomData = $this->dataMarge($roomData,$mstDataList);
		foreach($roomData as $data)
		{
			$result = $data;
			break;
		}
		return $result;
		
	}
	
	/** 指定したユーザーが設定していない部屋を取得 */
	public function getNoEqpRoomById($userId=null)
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
		
		$roomData = $this->getByUserId($userId, 0);
		
		$mstData = $this->getRoomData();
		$mstDataList = array(
			array('mstData'=>$mstData, 'key'=>'roomId', 'mstKey'=>'id'),
		);
		return $this->dataMarge($roomData,$mstDataList);
	}
	
	/** 部屋の情報をCSVから取得 */
	public function getRoomData()
	{
		$roomMst = $this->getAll('/room/mst');
		$eventMst = $this->getAll('/event/shop/room/mst');
		if(!empty($eventMst))
		{
			$roomMst = array_merge($eventMst,$roomMst);
		}
		return $roomMst;
	}
	
	/** プレゼントの中の部屋データを取得 */
	public function getRoomFromPresentByUserId($userId)
	{
		$sql = "SELECT * FROM present WHERE userid = $userId AND categoryId = '8' ORDER BY itemId;";
		return $this->fetchAll($sql);
	}
	
	/** データベースに部屋を追加 */
	public function insertRoom($userId,$roomId,$flg=0)
	{
		$sql = "INSERT INTO ".self::TABLE_NAME."(userId,roomId,roomFlg) VALUES ('$userId','$roomId','$flg');";
		$this->fetchFirst($sql);
	}
	
	/** 部屋の変更 */
	public function changeRoom($userId,$nowRoom, $newRoom,$nowRoomAp,$newRoomAp)
	{
		//ユーザーの現在APの取得
		$sql = "SELECT * FROM user WHERE id=$userId";
		$user = $this->fetchFirst($sql);
		
		//更新後のユーザーのAPを計算
		$newMaxAp = $user['apMax'] - $nowRoomAp + $newRoomAp;
		$newAp = $user['ap'];
		//ユーザーの現在HPが最大APを上回った場合、現在APを最大APに合わせる
		if($newMaxAp<$newAp)
		{
			$newAp = $newMaxAp;
		}
		
		//部屋更新SQLの実行
		$sql = "UPDATE ".self::TABLE_NAME." SET roomFlg = 1 WHERE roomId = '$newRoom' AND userId = '$userId';";
		$this->fetchFirst($sql);
		$sql = "UPDATE ".self::TABLE_NAME." SET roomFlg = 0 WHERE roomId = '$nowRoom' AND userId = '$userId';";
		$this->fetchFirst($sql);
		$sql = "UPDATE user SET ap = '$newAp',apMax = '$newMaxAp' WHERE id = '$userId';";
		return $this->fetchFirst($sql);
	}
	
	/*
	  部屋の初期化
	*/
	public function resetRoom($userId=null)
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
		
		Config::load('userBase', true);
		
		//装備中の部屋を取得
		$equipRoom = $this->getByUserId($userId, 1);
		
		//初期部屋を取得
		$initialRoomId = Config::load('userBase.defaultEquipId.room');
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE userId=$userId";
		$sql .= " AND roomId=$initialRoomId";
		$initialRoom = $this->fetchAll($sql);
		
		//設定中の部屋の設定を解除
		foreach((array)$equipRoom as $Room)
		{
			$sql = "UPDATE ".self::TABLE_NAME." SET roomFlg=0 WHERE id=".$room['id'];
			$this->fetchFirst($sql);
		}
		
		//初期アバターをすべて削除
		foreach((array)$initialRoom as $room)
		{
			$this->deleteById($room['id']);
		}
		//初期アバターを再登録・装備
		$this->insertRoom($userId, $initialRoomId, 1);
		
		//APをリセット
		$hp = Config::get('userBase.defaultAp');
		$sql = "UPDATE user SET ap='$ap',apMax='$ap' WHERE id='$userId';";
		return $this->fetchFirst($sql);
	}
}
?>