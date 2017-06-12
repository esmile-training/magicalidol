<?php
class Model_Avatar extends Model_Base_DbCsv
{
	const TABLE_NAME = 'userAvatar';
	
	/*
	  カテゴリーIDごとのリスト取得
	  $categoryCode:a:髪、b:くつ、c:顔、d:服、e:アクセサリー
	  return:array
	*/
	public function getAvatarByCode($categoryCode)
	{
		$avatarMst = $this->getAll('/avatar/'.$categoryCode);
		$eventMst = $this->getAll('/event/shop/avatar/'.$categoryCode);
		if(!empty($eventMst))
		{
			$avatarMst = array_merge($eventMst,$avatarMst);
		}
		return $avatarMst;
	}
	
	public function getEventAvatarMst($categoryCode)
	{
		$avatarlist = $this->getAll('/event/shop/avatar/'.$categoryCode);
		return $avatarlist;
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
	  ユーザーIDでリストの取得
	  $id:ユーザーID
	  $category:カテゴリーコード(null:指定なし)
	  $equip:装備中フラグ(null:指定なし、0:非装備アバター、1:装備中アバター)
	  return:array
	*/
	public function getByUserId($id, $category=null, $equip=null)
	{
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE userId='$id'";
		if($category)
		{
			//カテゴリーの指定がある場合は条件に追加
			$sql .= " AND categoryId='$category'";
		}
		if($equip)
		{
			//装備中フラグの指定がある場合は条件に追加
			$sql .= " AND equipmentFlg='$equip'";
		}
		$sql .= " ORDER BY";
		if(!$category)
		{
			//カテゴリーの指定がない場合はソート条件にカテゴリーを追加
			$sql .= " categoryId,";
		}
		$sql .= " avatarId";
		$avatarList = $this->fetchAll($sql);
		
		return $avatarList;
	}
	
	/*
	  ユーザーIDでリストの取得
	  $id:ユーザーID
	  $category:カテゴリーコード(null:指定なし、a:髪、b:くつ、c:顔、d:服、e:アクセサリー)
	  $equip:装備中フラグ(null:指定なし、0:非装備アバター、1:装備中アバター)
	  return:array
	*/
	public function getMargeDataByUserId($id, $category=null, $equip=null)
	{
		//選択されたカテゴリーのアバターリスト（csv）
		if($category)
		{
			$avatarMst = $this->getAvatarByCode($category);
			//データ結合条件
			$mstDataList = array(
								array('mstData'=>$avatarMst, 'key'=>'avatarId', 'mstKey'=>'id'),
							);
		}
		else
		{
			$avatarMstA = $this->getAvatarByCode('a');
			$avatarMstB = $this->getAvatarByCode('b');
			$avatarMstC = $this->getAvatarByCode('c');
			$avatarMstD = $this->getAvatarByCode('d');
			$avatarMstE = $this->getAvatarByCode('e');
			//データ結合条件
			$mstDataList = array(
								array('mstData'=>$avatarMstA, 'key'=>'avatarId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'a', 'categoryKey'=>'categoryId'),
								)),
								array('mstData'=>$avatarMstB, 'key'=>'avatarId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'b', 'categoryKey'=>'categoryId'),
								)),
								array('mstData'=>$avatarMstC, 'key'=>'avatarId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'c', 'categoryKey'=>'categoryId'),
								)),
								array('mstData'=>$avatarMstD, 'key'=>'avatarId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'d', 'categoryKey'=>'categoryId'),
								)),
								array('mstData'=>$avatarMstE, 'key'=>'avatarId', 'mstKey'=>'id', 'categoryList'=>array(
									array('category'=>'e', 'categoryKey'=>'categoryId'),
								)),
							);
		}
		
		//選択されたカテゴリーのユーザが所持しているアバター（db）
		$userAvatarList = $this->getByUserId($id, $category, $equip);
		
		//配列を結合
		$userAvatar = $this->dataMarge($userAvatarList, $mstDataList);
		
		return $userAvatar;
	}
	
	/*
	  装備アバター変更処理
	  $id:ユーザーID
	  $nowAvatar:現在装備中アバターのID
	  $newAvatar:装備するアバターのID
	  $nowAvatarHp:現在装備中アバターのHP
	  $newAvatarHp:装備するアバターのHP
	  return:bool
	*/
	public function changeAvatar($id, $nowAvatar, $newAvatar, $nowAvatarHp, $newAvatarHp)
	{
		//ユーザーの現在HPの取得
		$sql = "SELECT * FROM user WHERE id=$id";
		$user = $this->fetchFirst($sql);
		
		//更新後のユーザーのHPを計算
		$newMaxHp = $user['hpMax'] - $nowAvatarHp + $newAvatarHp;
		$newHp = $user['hp'];
		//ユーザーの現在HPが最大HPを上回った場合、現在HPを最大HPに合わせる
		if($newMaxHp<$newHp)
		{
			$newHp = $newMaxHp;
		}
		
		//装備更新SQLの実行
		$sql = "UPDATE ".self::TABLE_NAME." SET equipmentFlg = 1 WHERE id = '$newAvatar';";
		$this->fetchFirst($sql);
		$sql = "UPDATE ".self::TABLE_NAME." SET equipmentFlg = 0 WHERE id = '$nowAvatar';";
		$this->fetchFirst($sql);
		$sql = "UPDATE user SET hp = '$newHp',hpMax = '$newMaxHp' WHERE id = '$id';";
		return $this->fetchFirst($sql);
	}
	
	//装備アバターを初期化
	public function resetAvatar($userId=null)
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
		
		//装備中のアバターを取得
		$equipAvatar = $this->getByUserId($userId, null, 1);
		
		//初期アバターを取得
		$defaultAvatar = Config::get('userBase.defaultAvatarId');
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE userId=$userId";
		$sql .= " AND ( ";
		$defaultAvatarSql = array();
		foreach($defaultAvatar as $category=>$avatarId)
		{
			$defaultAvatarSql[] = "( categoryId='$category' AND avatarId=$avatarId )";
		}
		$sql .= implode(" OR ", $defaultAvatarSql);
		$sql .= " );";
		$initialAvatar = $this->fetchAll($sql);
		
		//装備中アバターの装備を解除
		foreach((array)$equipAvatar as $avatar)
		{
			$sql = "UPDATE ".self::TABLE_NAME." SET equipmentFlg=0 WHERE id=".$avatar['id'];
			$this->fetchFirst($sql);
		}
		
		//初期アバターをすべて削除
		foreach((array)$initialAvatar as $avatar)
		{
			$this->deleteById($avatar['id']);
		}
		//初期アバターを再登録・装備
		foreach($defaultAvatar as $category=>$avatarId)
		{
			$this->insertAvatar($category, $avatarId, 1, $userId);
		}
		
		//HPをリセット
		$hp = Config::get('userBase.defaultHp');
		$sql = "UPDATE user SET hp='$hp',hpMax='$hp' WHERE id='$userId';";
		return $this->fetchFirst($sql);
	}
	
	//アバターを挿入
	public function insertAvatar($category, $avatarId, $equipment=0, $userId=null)
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
		
		$sql = "INSERT INTO ".self::TABLE_NAME;
		$sql .= " SET userId=$userId, categoryId='$category', avatarId=$avatarId, equipmentFlg=$equipment";
		
		return $this->fetchFirst($sql);
	}
}