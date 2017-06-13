<?php
class Model_User extends Model_Basegame
{
	public $userData;
	
	public function __construct($userData = null){
		$this->userData = $userData;
	}

		public function getById($userId)
	{
		return $userId;
	}
	
	public function totalCount($username = 'unknown')
	{
		var_dump($this->userData);
		return 'Hellow!! ' . $username;
	}
}