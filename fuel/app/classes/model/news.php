<?php
class Model_News extends Model_Base_Db
{
	const TABLE_NAME = 'news';
	
	/*
	  idで取得
	  $id:ID
	  return:array
	*/
	public function getById($id)
	{
		return $this->getByIdBase(self::TABLE_NAME, $id);
	}
	
	//現在時刻で取得
	public function getNewsByCurrentTime()
	{
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " WHERE start <= '".$this->userData['nowTime']."'";
		$sql .= " AND (end > '".$this->nowTime."' OR end IS NULL)";
		$sql .= " ORDER BY start DESC, id DESC";
		
		return $this->fetchAll($sql);
	}
	
	//全て取得
	public function getNewsAll()
	{
		$sql = "SELECT * FROM ".self::TABLE_NAME;
		$sql .= " ORDER BY start DESC, id DESC";
		
		return $this->fetchAll($sql);
	}
	
	public function insertNews($title, $text, $start, $end=null)
	{
		$sql = "INSERT INTO ".self::TABLE_NAME;
		$sql .= " SET title='$title', text='$text', start='$start'";
		if(is_null($end))
		{
			$sql .= ", end=NULL";
		}
		else
		{
			$sql .= ", end='$end'";
		}
		
		return $this->fetchFirst($sql);
	}
	
	/*
	  お知らせ更新
	  $id:ID
	  $title:タイトル
	  $text:内容
	  $start:開始日時
	  $end:終了日時
	*/
	public function updateNews($id, $title, $text, $start, $end=null)
	{
		$sql = "UPDATE ".self::TABLE_NAME;
		$sql .= " SET title='$title', text='$text', start='$start'";
		if(is_null($end))
		{
			$sql .= ", end=NULL";
		}
		else
		{
			$sql .= ", end='$end'";
		}
		$sql .= " WHERE id=$id";
		
		return $this->fetchFirst($sql);
	}
}