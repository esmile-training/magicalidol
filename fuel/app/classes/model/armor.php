<?php
class Model_armor extends Model_Base_DbCsv
{
	const TABLE_NAME = "userArmor";
	
	/*
	  防具のマスターデータを取得
	  return:array
	*/
	public function getMaster(){
		$armorlist = $this->getAll('/armor/mst');
		return $armorlist;
	}
	
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
	  ユーザーidで取得
	  $id:ユーザーID
	  $equip:装備中フラグ(null:指定なし、0:非装備防具、1:装備中防具)
	  return:array
	*/
	public function getByUserId($id, $equip=null)
	{
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE userid=$id";
		if($equip)
		{
			$sql .= " AND equipmentFlg='$equip'";
		}
		$sql .= " ORDER BY armorId";
		return $this->fetchAll($sql);
	}
	
	/*
	  ユーザーIDでリストの取得
	  $id:ユーザーID
	  $equip:装備中フラグ(null:指定なし、0:非装備防具、1:装備中防具)
	  return:array
	*/
	public function getMargeDataByUserId($id, $equip=null)
	{
		//防具リスト（csv）
		$armorMst = $this->getMaster();
		
		//ユーザが所持している防具（db）
		$userArmorList = $this->getByUserId($id, $equip);
		
		//配列を結合
		$mstDataList = array(
						array('mstData'=>$armorMst, 'key'=>'armorId', 'mstKey'=>'id'),
						);
		$userArmor = $this->dataMarge($userArmorList, $mstDataList);
		
		return $userArmor;
	}
	
	/*
	  装備防具変更処理
	  $nowArmor:現在装備している防具のID
	  $newArmor:新しく装備する防具のID
	  return:bool
	*/
	public function changeArmor($nowArmor, $newArmor)
	{
		if($newArmor)
		{
			$sql = "UPDATE ".self::TABLE_NAME." SET equipmentFlg = 1 WHERE id = '$newArmor';";
			$result = $this->fetchFirst($sql);
		}
		if($nowArmor)
		{
			$sql = "UPDATE ".self::TABLE_NAME." SET equipmentFlg = 0 WHERE id = '$nowArmor';";
			$result = $this->fetchFirst($sql);
		}
		return $result;
	}
	
	/*
	  防具を挿入
	  $armorId:防具ID
	  $status:防具ステータス
	  $equipment:装備中フラグ(0:非装備、1:装備中/default:0)
	  $userId:ユーザーID
	  return:bool
	*/
	public function insertArmor($armorId, $status=null, $equipment=0, $userId=null)
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
		
		//ステータス設定
		if(is_null($status))
		{
			$armorMst = $this->getMaster();
			foreach($armorMst as $mst)
			{
				if($armorId == $mst['id'])
				{
					$status = $mst['status'];
					break;
				}
			}
		}
		
		$sql = "INSERT INTO ".self::TABLE_NAME;
		$sql .= " SET userId=$userId, armorId=$armorId, status=$status, equipmentFlg=$equipment";
		
		return $this->fetchFirst($sql);
	}
}
