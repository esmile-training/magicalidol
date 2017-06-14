<?php
class Model_Basegame extends Model
{
	public  $user;
	
	/*
	 * modelのインスタンス化
	 */
	public function newIns($modelName)
	{
		$modelName = 'Model_' . $modelName;
		
		// 各モデルのuserDataにユーザー情報を渡す。
		$this->model = new $modelName();
		$this->model->userData = $this->user;
		return new $modelName($this->user);
	}

	/*
	 * SELECT
	 */
	public function select($sql)
	{
		$sql->execute();
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