<?php
class Model_weapon extends Model_Base_DbCsv
{
	const TABLE_NAME = 'userWeapon';
	
	/*
	  武器のマスターデータを取得
	  $category:武器カテゴリー(1:斧、2:剣、3:鎌、4:ブーメラン)
	  return:array
	*/
	public function getMaster($category){
		$weaponList = $this->getAll('/weapon/mst'.$category);
		return $weaponList;
	}
	
	/*
	  スキルのマスターデータを取得
	  return:array
	*/
	public function getSkillMaster()
	{
		$skillList = $this->getAll('/skill/mst');
		return $skillList;
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
	  $category:武器カテゴリー(0:指定なし、1:斧、2:剣、3:鎌、4:ブーメラン)
	  $equip:装備中フラグ(null:指定なし、0:非装備武器、1:装備中武器)
	  return:array
	*/
	public function getByUserId($id, $category=0, $equip=null)
	{
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE userId = '$id'";
		if($category)
		{
			$sql .= " AND category='$category'";
		}
		if(!is_null($equip))
		{
			$sql .= " AND equipmentFlg='$equip'";
		}
		$sql .= " ORDER BY weaponId,strengthening DESC;";
		return $this->fetchAll($sql);
	}
	
	/*ユーザーIDでリストの取得
	  $id:ユーザーID
	  $category:武器カテゴリー(0:指定なし、1:斧、2:剣、3:鎌、4:ブーメラン)
	  $equip:装備中フラグ(null:指定なし、0:非装備武器、1:装備中武器)
	  return:array
	*/
	public function getMargeDataByUserId($id, $category=0, $equip=null)
	{
		//ユーザが所持している武器（db）
		$userWeaponList = $this->getByUserId($id, $category, $equip);
		if(empty($userWeaponList))
		{
			return array();
		}
		
		//スキルリスト（csv）
		$skillMst = $this->getSkillMaster();
		//配列のカラム名を変更
		$changeKeyList = array(
							array('key'=>'name', 'changeKey'=>'skillName'),
							array('key'=>'description', 'changeKey'=>'skillDescription'),
						);
		$skillMst = $this->changeArrayKey($skillMst, $changeKeyList);
		
		//配列を結合
		if($category)
		{
			$mstDataList = array(
							array('mstData'=>$this->getMaster($category), 'key'=>'weaponId', 'mstKey'=>'id'),
							);
		}
		else
		{
			$mstDataList = array(
								array('mstData'=>$this->getMaster('1'), 'key'=>'weaponId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'1', 'categoryKey'=>'category'),
								)),
								array('mstData'=>$this->getMaster('2'), 'key'=>'weaponId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'2', 'categoryKey'=>'category'),
								)),
								array('mstData'=>$this->getMaster('3'), 'key'=>'weaponId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'3', 'categoryKey'=>'category'),
								)),
								array('mstData'=>$this->getMaster('4'), 'key'=>'weaponId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'4', 'categoryKey'=>'category'),
								)),
								array('mstData'=>$this->getMaster('e'), 'key'=>'weaponId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'e', 'categoryKey'=>'category'),
								)),
							);
		}
		$userWeapon = $this->dataMarge($userWeaponList, $mstDataList);
		$mstDataList = array(
						array('mstData'=>$skillMst, 'key'=>'skillId', 'mstKey'=>'id'),
						);
		$userWeapon = $this->dataMarge($userWeapon, $mstDataList);
		
		return $userWeapon;
	}
	
	/*
	  装備武器を変更
	  $nowWeapon:現在装備している防具のID
	  $newWeapon:新しく装備する防具のID
	  return:bool
	*/
	public function changeWeapon($nowWeapon, $newWeapon)
	{
		if($newWeapon)
		{
			$sql = "UPDATE ".self::TABLE_NAME." SET equipmentFlg = 1 WHERE id = '$newWeapon';";
			$result = $this->fetchFirst($sql);
		}
		if($nowWeapon)
		{
			$sql = "UPDATE ".self::TABLE_NAME." SET equipmentFlg = 0 WHERE id = '$nowWeapon';";
			$result = $this->fetchFirst($sql);
		}
		return $result;
	}
	
	/*
	  武器強化
	  $id:ID
	  return:bool
	*/
	public function compoundWeapon($id)
	{
		$sql = "UPDATE ".self::TABLE_NAME." SET status = status+1,strengthening = strengthening+1 WHERE id = $id;";
		return $this->fetchFirst($sql);
	}
	
	/*
	  武器を挿入
	  $category:武器カテゴリー
	  $weaponId:武器ID
	  $status:武器ステータス
	  $equipment:装備中フラグ(0:非装備、1:装備中/default:0)
	  $userId:ユーザーID
	  return:bool
	*/
	public function insertWeapon($category, $weaponId, $status=null, $equipment=0, $userId=null)
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
			Config::load('weapon',true);
			$status = Config::get('weapon.baseStatus.'.$weaponId);
		}
		
		$sql = "INSERT INTO ".self::TABLE_NAME;
		$sql .= " SET userId=$userId, category='$category', weaponId=$weaponId, status=$status, equipmentFlg=$equipment";
		
		return $this->fetchFirst($sql);
	}
}