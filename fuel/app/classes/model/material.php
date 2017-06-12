<?php
class Model_Material extends Model_Base_DbCsv
{
	const TABLE_NAME = 'userMaterial';
	
	/*
	  素材のマスターデータを取得
	  return:array
	*/
	public function getMaster($isEvent=true){
		$materialList = $this->getAll('/gacha/material');
		if($isEvent){
			$eventMaterial = $this->getEventMaterialMst();
			$materialList = array_merge($materialList,$eventMaterial);
		}
		return $materialList;
	}
	/**
		イベントの素材アイテムを取得する
	*/
	public function getEventMaterialMst()
	{
		$eventMaterial = $this->getAll('/event/eventMaterial');
		return $eventMaterial;
	}
	
	/*
	  素材IDでユーザーの素材を取得する
	  $materialId:素材ID
	  $userId:ユーザーID
	  return:array
	*/
	public function getByMaterialId($materialId, $userId=null)
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
		$sql .= " WHERE userId=$userId AND materialId=$materialId";
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  ユーザーの素材を取得する
	  $userId:ユーザーID
	  return:array
	*/
	public function getByUserId($userId=null)
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
		
		return $this->fetchAll($sql);
	}
	
	/*
	  ユーザーの結合済み素材データを取得する
	  $userId:ユーザーID
	  return:array
	*/
	public function getMargeDataByUserId($userId=null)
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
		
		$userMaterialList = $this->getByUserId($userId);
		$mstDataList = array(
						array('mstData'=>$this->getMaster(), 'key'=>'materialId', 'mstKey'=>'id'),
						);
		$userMaterial = $this->dataMarge($userMaterialList, $mstDataList);
		
		return $userMaterial;
	}
	
	/**
		素材を増やす
		持っていなければ新規追加する
	*/
	public function addMaterial($materialId, $count, $userId=null)
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
		$userMaterial = $this->getByMaterialId($materialId, $userId);
		
		
		if(empty($userMaterial))
		{
			$sql = 'INSERT INTO '.self::TABLE_NAME.'(userId,materialId,count)';
			$sql .= ' VALUES ('.$userId.','.$materialId.','.$count.')';
		}
		else
		{
			$sql = 'UPDATE '.self::TABLE_NAME.' SET count = count+'.$count;
			$sql .= ' WHERE userId = '.$userId;
			$sql .= ' AND materialId = '.$materialId;
		}
		$this->fetchFirst($sql);
	}
	
	/**
		素材を減らす
		0個になるときはDBから削除
	*/
	public function reduceMaterial($userId,$materialId,$count)
	{
		$userMaterial = $this->getByMaterialId($materialId, $userId);
		
		if(($userMaterial['count'] - $count) <= 0)
		{
			$sql = 'DELETE FROM '.self::TABLE_NAME;
			$sql .= ' WHERE userId = '.$userId;
			$sql .= ' AND materialId = '.$materialId;
		}
		else
		{
			$sql = 'UPDATE '.self::TABLE_NAME.' SET count = count-'.$count;
			$sql .= ' WHERE userId = '.$userId;
			$sql .= ' AND materialId = '.$materialId;
		}
		$this->fetchFirst($sql);
	}
}