<?php
class Lib_User extends Lib_Basegame
{
	public function __construct()
	{
		
	}
	
	public function test($id = null, $name = 'unknown')
	{
		$name .= '‚³‚ñ';
		
		$data=array(
			'id' => $id,
			'name'=> $name 
		);
		return $data;
	}
}