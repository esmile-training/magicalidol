<?php
class Model_Item extends Model_Base_DbCsv
{
	const TABLE_NAME = 'userItem';
	
	//カテゴリー別のCSVを読めるように
	public function getItems($category)
	{
		$itemList = $this->getAll('/item/'.$category);
		return $itemList;
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
	  $id:ID
	  return:bool
	*/
	public function deleteById($id)
	{
		return $this->deleteByIdBase(self::TABLE_NAME, $id);
	}
	
	/*
	  idで所持数を変更
	  $id:ID
	  $count(int):増減数
	  return:bool
	*/
	private function changeCountById($id, $count)
	{
		$sql = "UPDATE ".self::TABLE_NAME;
		$sql .= " SET count = count+$count";
		$sql .= " WHERE id=$id;";
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  ユーザーIDで取得
	  $category:アイテムカテゴリー
	  $userId:ユーザーID
	  return:array
	*/
	public function getByUserId($category=null, $userId=null)
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
		if(!is_null($category))
		{
			$sql .= " AND category=$category";
		}
		$sql .= " ORDER BY itemId;";
		
		return $this->fetchAll($sql);
	}
	
	/*
	  アイテム使用
	  $itemId:アイテムID
	  $category:アイテムカテゴリー
	  $userId:ユーザーID
	  return:bool
	*/
	public function useItem($itemId, $category, $userId=null)
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
		
		//アイテム所持チェック
		$userItem = $this->getUserItemByItemId($category, $itemId, $userId);
		if(empty($userItem))
		{
			throw new Exception('該当アイテムを所持していません。');
			return false;
		}
		
		//所持数の更新
		if($userItem['count'] - 1 > 0){
			$result = $this->changeCountById($userItem['id'], -1);
		}else{
			$result = $this->deleteById($userItem['id']);
		}
		
		return $result;
		
	}
	
	/*
	  ユーザーアイテムをアイテムIDで取得
	  $category:アイテムカテゴリー
	  $itemId:アイテムID
	  $userId:ユーザーID
	  return:array
	*/
	public function getUserItemByItemId($category, $itemId, $userId=null)
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
		$sql .= " WHERE userId=$userId AND category=$category AND itemId=$itemId";
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  指定アイテムを所持しているかを確認
	  $category:アイテムカテゴリー
	  $itemId:アイテムID
	  $userId:ユーザーID
	  return:int(id)
	*/
	public function isPossesion($category, $itemId, $userId=null)
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
		
		$itemData = $this->getUserItemByItemId($category, $itemId, $userId);
		if(empty($itemData))
		{
			return null;
		}
		return $itemData['id'];
	}
	
	/*
	  アイテムの追加
	  $category:アイテムカテゴリー
	  $itemId:アイテムID
	  $count:増加数
	  $userId:ユーザーID
	*/
	public function addItem($category, $itemId, $count, $userId=null)
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
		
		$id = $this->isPossesion($category, $itemId, $userId);
		
		if(is_null($id))
		{
			$sql = "INSERT INTO ".self::TABLE_NAME;
			$sql .= " SET userId=$userId, category=$category, itemId=$itemId, count=$count";
			$result = $this->fetchFirst($sql);
		}
		else
		{
			$result = $this->changeCountById($id, $count);
		}
		
		return $result;
	}
}
