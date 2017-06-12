<?php
class Model_Base_DbCsv extends Model
{
	public $userData;
	public $nowTime;

	public function __construct( $userData=null )
	{
		$this->userData = $userData;
		$this->nowTime = (is_null($this->userData['currentTime']) )? date("Y-m-d H:i:s") : $this->userData['currentTime'];
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
		foreach((array)$allList as $row){
			//2行目以降は、先頭カラムをkeyにする。
			$id = (int)$row[0];
			foreach((array)$row as $key => $value){
				//データは、カラム名=>データに並び替え(空文字はNULL)
				$result[$id][$keyList[$key]] = ($value)? $value : null;
			}
		}
		return $this->format($fileName, $result);
	}
	
	/*
	*	CSVは全て文字型のため、コンフィグ設定に従って型を変換
	*/
	public function format($fileName, $data){
		Config::load('csv/'.$fileName);
		$format = Config::get('format');
		foreach((array)$data as $id => $row){
			foreach((array)$row as $key => $value){
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
	  データを結合する
	  $dataList:結合元データの二次元連想配列(array(array))
	  $mstDataList:結合マスターデータリスト(array(array("mstData"=>array(array), "key"=>string, "mstKey"=>string, "categoryList"=>array("category", "categoryKey"))))
		mstData:結合マスターデータ二次元連想配列(マスター結合キー以外で結合元データと同じカラム名があるとマスターデータで上書きされるので注意)
		key:結合キー
		mstKey:マスター結合キー
		categoryList:結合カテゴリー条件(特定カテゴリーのみ結合する場合に設定。設定なしの場合はすべてのデータに結合)
		  category:結合カテゴリー
		  categoryKey:結合カテゴリーカラム識別キー
	  return:array(array)
	*/
	public function dataMarge($dataList, $mstDataList)
	{
		$margeData = array();
		
		foreach((array)$dataList as $data)
		{
			foreach((array)$mstDataList as $mstList)
			{
				$margeFlg = true;
				if(!empty($mstList['categoryList']))
				{
					foreach((array)$mstList['categoryList'] as $lst)
					{
						if($data[$lst['categoryKey']] != $lst['category'])
						{
							$margeFlg = false;
							break;
						}
					}
				}
				if($margeFlg)
				{
					$key    = $mstList['key'];
					$mstKey = $mstList['mstKey'];
					foreach((array)$mstList['mstData'] as $mst)
					{
						if($data[$key] == $mst[$mstKey])
						{
							unset($mst[$mstKey]);
							$data += $mst;
							break;
						}
					}
					break;
				}
			}
			$margeData[] = $data;
		}
		
		return $margeData;
	}
	
	/*
	  二次元連想配列の配列名を変更する
	  $dataList:変更配列データ
	  $changeKeyList:変更キーデータリスト(array(array("key"=>string, "changeKey"=>string)))
	*/
	public function changeArrayKey($dataList, $changeKeyList)
	{
		$changeList = array();
		
		foreach((array)$dataList as $list)
		{
			$changeData = array();
			foreach((array)$list as $key=>$data)
			{
				$listKey = $key;
				foreach((array)$changeKeyList as $keyList)
				{
					if($listKey == $keyList["key"])
					{
						$listKey = $keyList["changeKey"];
						break;
					}
				}
				
				$changeData[$listKey] = $data;
			}
			
			$changeList[] = $changeData;
		}
		
		return $changeList;
	}
}