<?php
class Lib_Basegame
{
	public function __construct()
	{
		
	}
	
	public function exec($className, $method, $arg = false)
	{
		$className = 'Lib_' . $className;
		$libClass = new $className();
		
		//引数の数によって出しわけ
		if (is_array($arg))
		{
			return $result = call_user_func_array(array($libClass, $method), $arg);
		}
		elseif ($arg)
		{
			return $result = call_user_func_array(array($libClass, $method), array($arg));
		}
		else
		{
			return $result = $libClass->$method();
		};
	}
	
	/*
	*	CSV全件取得
	*	@fileName	public/assets/scv以下のファイル名(拡張子無し)
	*	@rowKey		各行のキーにするカラム（0番目は大抵iid）
	*/
	public function getAll($fileName, $rowKey=0){
		$allList = Asset::csv($fileName);
		//1行目はカラム名
		$keyList = array_shift($allList);
		$result = array();
		foreach($allList as $row){
			//2行目以降は、先頭カラムをkeyにする。
			$id = (int)$row[0];
			foreach($row as $key => $value){
				//データは、カラム名=>データに並び替え(空文字はNULL)
				$result[$id][$keyList[$key]] = ($value)? $value : null;
			}
		}
		return $this->format($fileName, $result);
	}
	
	/*
	*	ＣＳＶは全て文字型のため、コンフィグ設定に従って型を変換
	*/
	public function format($fileName, $data){
		Config::load('csv/'.$fileName);
		$format = Config::get('format');
		foreach($data as $id => $row){
			foreach($row as $key => $value){
				if( !isset($format[$key]) ) continue;
				switch($format[$key]){
					case 'int':
						$data[$id][$key] = (int)$value;
						break;
					case 'json':
						$data[$id][$key] = json_decode($value,TRUE);
					case 'string':
					default:
						break;
				}
			}
		}
		return $data;
	}
	
	/*
	*	csvとModelから取得したデータを結合
	*/
	
	public function combining($modelData, $csvData, $code = 'user'){
	
		$code_id	= $code . "Id";
		$code_mst	= $code . "Mst";

		foreach($modelData as $modelval)
		{
			$modelval->$code_mst = ( isset( $csvData[$modelval->$code_id] ) )? $csvData[$modelval->$code_id] : null;
		}
		
		return $modelval;
	}
}

