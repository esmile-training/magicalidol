<?php
class Lib_Api extends Controller_Rest
{
	protected $format = 'json';
	
	public function before()
	{
		parent::before();
		
		//セッションからuser_id取ってくる
		$userId = Session::get('userId');
		if( !$userId )
		{
			return;
		}
		
		//ユーザ情報の取得
		$Model_Db = new Model_Base_Db();
		$this->userData = $Model_Db->getByIdBase( 'user', $userId );
		if( empty($this->userData) || $this->userData['id']==0)
		{
			return;
		}
		
		//表示用（ユーザテーブル＆現在時刻）
		$this->viewData['userData'] = $this->userData;
		$this->viewData['nowTime'] = $this->nowTime = is_null($this->userData['currentTime'])? date("Y-m-d H:i:s") : $this->userData['currentTime'];
		$this->userData['nowTime'] = $this->nowTime;
		
		//最終アクセス時間を更新
		$Model_User = new Model_User($this->userData);
		$Model_User->updateUpdateTime();
		
		//多重装備チェック
		$Model_Weapon = new Model_weapon();
		$Model_Armor = new Model_armor();
		$Model_Avatar = new Model_Avatar();
		$userWeapon = $Model_Weapon->getByUserId($userId, 0, 1);
		$userArmor = $Model_Armor->getByUserId($userId, 1);
		$userAvatar = $Model_Avatar->getByUserId($userId, null, 1);
		if(count($userWeapon)>1)
		{
			array_shift($userWeapon);
			foreach($userWeapon as $weapon)
			{
				$Model_Weapon->changeWeapon($weapon['id'], 0);
			}
		}
		if(count($userArmor)>1)
		{
			array_shift($userArmor);
			foreach($userArmor as $armor)
			{
				$Model_Armor->changeArmor($armor['id'], 0);
			}
		}
		if(count($userAvatar)!=5)
		{
			$Model_Avatar->resetAvatar($userId);
		}
	}
	
	/*
	  文字列置き換え
	  $replace(array):置き換え文字連想配列(key:置換前 => value:置換後)
	  $subject(string):置き換え文字列
	  return:string
	*/
	public function strReplaceAssoc(array $replace, $subject)
	{
		return str_replace(array_keys($replace), array_values($replace), $subject);
	}
	
	public function post_debug()
	{
		$inputData = Input::json();
		
		foreach($inputData as $key=>$value)
		{
			Log::debug($key.":".$value);
		}
	}
}