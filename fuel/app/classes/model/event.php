<?php
class Model_Event extends Model_Base_DbCsv
{
	const TABLE_NAME = "event";
	const TABLE_USER_NAME = "userEvent";
	
	/*
	  イベントのマスターデータを取得
	  $categoryId(int):カテゴリーID(1:ダンジョン、2:ショップ、3:武器強化確率変動、4:武器ガチャ確率変動)
	  return:array
	*/
	public function getMaster($categoryId){
		Config::load('event/event', true);
		$categoryList = Config::get('event/event.category');
		$category;
		
		//debug
		// Log::debug("categoryId:".$categoryId);
		
		foreach($categoryList as $key=>$value)
		{
			if($key==$categoryId)
			{
				$category = $value;
				break;
			}
		}
		
		$result = $this->getAll('/event/'.$category);
		return $result;
	}
	
	public function getEventShopMaster()
	{
		return $this->getAll('event/eventshop');
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
	  イベントIDとカテゴリーで取得
	  $category(int):カテゴリーID(1:ダンジョン、2:ショップ、3:武器強化確率変動、4:武器ガチャ確率変動)
	  $eventId(int):イベントID
	  return:array
	*/
	public function getByEventId($category, $eventId)
	{
		//エラー処理
		if(empty($eventId) || empty($category))
		{
			return false;
		}
		
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE category=$category AND eventId=$eventId;";
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  現在開催中のイベントを取得
	  $category(int):カテゴリーID(null:全取得、1:ダンジョン、2:ショップ、3:武器強化確率変動、4:武器ガチャ確率変動 default:null)
	  $isExchange(bool):交換期限フラグ(true:終了日時を交換期限に設定、false:終了日時をイベント終了日時の設定 default:false)
	  $currentTime(string):現在時刻(format[Y-m-d H:i:s] default:userDataから取得)
	  return:array
	*/
	public function getByCurrentTime($category=null, $isExchange=false, $currentTime=null)
	{
		//現在時刻を設定
		if(is_null($currentTime))
		{
			if(empty($this->userData['nowTime']))
			{
				throw new Exception('現在時刻が取得できません。');
				return false;
			}
			$currentTime = $this->userData['nowTime'];
		}
		
		//SQLを設定
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE start <= '$currentTime'";
		if($isExchange)
		{
			$sql .= " AND (endExchange > '$currentTime' OR endExchange IS NULL)";
		}
		else
		{
			$sql .= " AND (end > '$currentTime' OR end IS NULL)";
		}
		if(!empty($category))
		{
			$sql .= " AND category = $category";
		}
		$sql .= " ORDER BY start DESC;";
		
		return $this->fetchAll($sql);
	}
	
	/*
	  現在開催中のイベントデータを取得(DB・CSV結合済み)
	  $category(int):カテゴリーID(null:全取得、1:ダンジョン、2:ショップ、3:武器強化確率変動、4:武器ガチャ確率変動 default:null)
	  $isExchange(bool):交換期限フラグ(true:終了日時を交換期限に設定、false:終了日時をイベント終了日時の設定 default:false)
	  $currentTime(string):現在時刻(format[Y-m-d H:i:s] default:userDataから取得)
	  return:array
	*/
	public function getMargeDataBycurrentTime($category=null, $isExchange=false, $currentTime=null)
	{
		Config::load('event/event', true);
		$categoryList = Config::get('event/event.category');
		
		//開催中イベントリストを取得
		$eventList = $this->getByCurrentTime($category, $isExchange, $currentTime);
		if(empty($eventList))
		{
			return false;
		}
		
		//イベントマスタを取得
		if(empty($category))
		{
			$mstDataList = array();
			foreach($categoryList as $key=>$value)
			{
				$mstDataList[] = array(
									array('mstData'=>$this->getMaster($key), 'key'=>'eventId', 'mstKey'=>'id', 'categoryList'=>array(
										array('category'=>$key, 'categoryKey'=>'category'),
										)
									)
								);
			}
		}
		else
		{
			$mstDataList = array(
							array('mstData'=>$this->getMaster($category), 'key'=>'eventId', 'mstKey'=>'id'),
							);
		}
		
		//配列を結合
		$eventDataList = $this->dataMarge($eventList, $mstDataList);
		
		return $eventDataList;
	}
	
	/*
	  イベントユーザーデータを取得
	  $category(int):カテゴリーID(1:ダンジョン、2:ショップ、3:武器強化確率変動、4:武器ガチャ確率変動)
	  $eventId(int):イベントID
	  $userId(int):ユーザーID(default:userDataから取得)
	*/
	public function getUserEvent($category, $eventId, $userId=null)
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
		
		$sql = "SELECT * FROM ".self::TABLE_USER_NAME;
		$sql .= " WHERE id=$userId AND category=$category AND eventId=$eventId;";
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  イベントユーザーデータを新規登録
	  $category(int):カテゴリーID(1:ダンジョン、2:ショップ、3:武器強化確率変動、4:武器ガチャ確率変動)
	  $eventId(int):イベントID
	  $progress(int):イベント進行度(default:null)
	  $userId(int):ユーザーID(default:userDataから取得)
	*/
	public function createUserEvent($category, $eventId, $progress=null, $userId=null)
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
		
		//DB設定
		$sql = "INSERT INTO ".self::TABLE_USER_NAME;
		$sql .= " SET id=$userId, category=$category, eventId=$eventId";
		if(!is_null($progress))
		{
			$sql .= ", progress=$progress";
		}
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  イベントユーザーデータを更新
	  $category(int):カテゴリーID(1:ダンジョン、2:ショップ、3:武器強化確率変動、4:武器ガチャ確率変動)
	  $eventId(int):イベントID
	  $progress(int):イベント進行度(default:null)
	  $userId(int):ユーザーID(default:userDataから取得)
	*/
	public function updateUserEvent($category, $eventId, $progress=null, $userId=null)
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
		
		//更新データのエラーチェック
		if(is_null($progress))
		{
			throw new Exception('更新データが不正です。');
			return false;
		}
		
		//DB設定
		$sql = "UPDATE ".self::TABLE_USER_NAME." SET";
		if(!is_null($progress))
		{
			$sql .= " progress=$progress";
		}
		$sql .= " WHERE id=$userId AND category=$category AND eventId=$eventId;";
		
		return $this->fetchFirst($sql);
	}
}
