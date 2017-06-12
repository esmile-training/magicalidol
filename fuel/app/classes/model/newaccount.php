<?php
class Model_Newaccount extends Model_Base_DbCsv
{
	/** 
		ユーザーを新しく追加
		初期アバターを追加
	*/
	public function createCharacter( $userId, $userName )
	{
		//Log::debug('debug is passed');
		$sql = 'INSERT INTO user( id, name )';
		$sql .= 'VALUES ( '.$userId.', "'.$userName.'" );';
		$this->fetchFirst($sql);
		
		$avatarCategory = array('a','b','c','d','e');
		foreach($avatarCategory as $category)
		{
			$sql = 'INSERT INTO userAvatar(userId,categoryId,avatarId,equipmentFlg)';
			$sql .= 'VALUES ('.$userId.',"'.$category.'",1,1);';
			$this->fetchFirst($sql);
		}
		
		Config::load('weapon',true);
		$baseStatus = Config::get('weapon.baseStatus.1');
		$sql = "INSERT INTO userWeapon( userId, category, weaponId, strengthening, status, equipmentFlg )";
		$sql .= "VALUES ( $userId, 1, 1, 0, $baseStatus, 1 )";
		//Log::debug('SQL::'.$sql);
		$this->fetchFirst($sql);
		
		$ModelArmor = new Model_armor($this->userData);
		$armorData = $ModelArmor->getMaster();
		$sql = "INSERT INTO userArmor ( userid, armorId, status, equipmentFlg)";
		$sql .= "VALUES ( $userId, 1, ".$armorData[1]['status'].", 1 )";
		//Log::debug('SQL::'.$sql);
		$this->fetchFirst($sql);
		
		$ModelRoom = new Model_Room($this->userData);
		$ModelRoom->insertRoom($userId,1,1);
		
	}
    
}