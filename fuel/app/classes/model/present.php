<?php

class Model_Present extends Model_Base_DbCsv
{
	const TABLE_NAME = 'present';
	
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
	  ユーザーIDでリストの取得
	  $id:ユーザーID
	  $category:プレゼントカテゴリー(0:指定なし、1:お金、2:素材、3:武器、4:防具、5:アバター、6:回復アイテム、7:補助アイテム、8:部屋/default:0)
	  $charId:該当プレゼントのcharId
	  return:array
	*/
	public function getByUserId($category=0, $charId=null, $userId=null)
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
		if(!empty($category))
		{
			$sql .= " AND categoryId=$category";
		}
		if(!is_null($charId))
		{
			$sql .= " AND charId='$charId'";
		}
		
		return $this->fetchAll($sql);
	}
	
	//databaseのpresentからユーザーID、カテゴリーID(武器とか防具)、アイテムID(武器や防具の名前)、個数の取得
	public function getPresent($userId)
	{
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE `present`.`userId` = '" . $userId . "'";
		$sql .= " ORDER BY `id` DESC";
		return $this->fetchAll($sql);
	}
	
	//ユーザーIDでプレゼントの判断
	public function cntPresentsAll($userId)
	{
		$sql = "SELECT * FROM ".self::TABLE_NAME." WHERE `userId` = " . $userId;
		
		return count($this->fetchAll($sql));
	}
	
	//データベースの受け取り箱にアイテムを放り込む
	public function setToPost($categoryId, $itemId, $count=1, $value=null, $charId=null, $userId=null)
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
		
		$sql  = "INSERT INTO ".self::TABLE_NAME;
		$sql .= " SET userId=$userId";
		$sql .= ",categoryId=$categoryId";
		$sql .= ",itemId=$itemId";
		$sql .= ",count=$count";
		if($charId)
		{
			$sql .=",charId='$charId'";
		}
		if($value)
		{
			$sql .=",value=$value;";
		}
		
		return $this->fetchFirst($sql);
	}
}
