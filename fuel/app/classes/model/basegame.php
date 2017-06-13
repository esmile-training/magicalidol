<?php
class Model_Basegame extends Model
{
	public  $user;
	
	public function newIns($modelName)
	{
		$modelName = 'Model_' . $modelName;
		return new $modelName($this->user);
	}

	/*
	 * SELECT
	 */
	public function select( $sql, $range = 'all' )
	{
		$response = $this->dbapi($sql, 'select');
		//jsonから配列に変換
		$result = json_decode($response, true);
		if($result)
		{
			if( is_null($result) )
			{
			return array();
			}
			else if( $range == 'all' )
			{
			return $result;
			}
			else if( $range == 'first' &&  isset($result[0]) )
			{
			return $result[0];
			}
			else
			{
			return $result;
			}
		}
		else
		{
//			print( $response.'<br>' );
			\Log::error('Showing user profile for user: '.$response);
		}
	}
	
	/*
	 * charaUpdate
	 */
	public function charaUpdate($sql)
	{
		$this->dbapi($sql, 'update');
	}
	
	/*
	 * UPDATE
	 */
	public function update( $sql )
	{
		$result = $this->dbapi($sql, 'update');
		// SQLの実行

		BaseGameModel::StatusUpdate($sql);
		return $result;
	}

	/*
	 * DELETER
	 */
	public function delete( $sql )
	{
		$result = $this->dbapi($sql, 'delete');
		// SQLの実行
		BaseGameModel::StatusUpdate($sql);
		return $result;
	}

	/*intval($str)
	 * INSERT
	 */
	public function insert( $sql )
	{
		$result = $this->dbapi($sql, 'insert');
		// SQLの実行
		BaseGameModel::StatusUpdate($sql);
		return intval($result);
	}
	
	/*
	 * API実行
	 */
	public function dbapi( $sql, $type = 'dbapi' )
	{
		$params = ['sql' => $sql];

		//開始
		$curl = curl_init(DB_API_URL.$type.'.php');
		//オプションセット
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // パラメータをセット
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		//実行
		$response = curl_exec($curl);
		//閉じる
		curl_close($curl);

		return $response;

	}
}