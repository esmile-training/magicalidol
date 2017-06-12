<?php
class Model_Base_Db extends Model
{
	public $userData;
	public $nowTime;

	public function __construct( $userData=null )
	{
		$this->userData = $userData;
		if($userData)
		{
			$this->nowTime = $userData['nowTime'];
		}
	}
	/*
	* SQL実行（1件返す）
	*/
	public function fetchFirst( $sql ){
		$query = DB::query($sql);
		$result = $query->execute();
		return ( empty($result) )? null : $result[0];
	}
	/*
	* SQL実行（全件連想配列で返す）
	*/
	public function fetchAll( $sql ){
		$query = DB::query($sql);
		$result = $query->execute()->as_array('id');;
		return ( empty($result) )? null : $result;
	}
	/*
	* idで取得
	*/
	public function getByIdBase( $tableName, $id )
	{
		$sql = "SELECT * FROM `$tableName`";
		$sql .= " WHERE id = '$id'";
		return $this->fetchFirst($sql);
	}
	
	/*
	  idで削除
	*/
	public function deleteByIdBase($tableName, $id)
	{
		$sql = "DELETE FROM $tableName";
		$sql .= " WHERE id=$id";
		
		return $this->fetchFirst($sql);
	}
}