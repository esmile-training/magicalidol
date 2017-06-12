<?php
class Controller_Top extends Lib_Contents
{
	public function action_index()
	{
		//データ取得
		$ModelNews = new Model_News($this->userData);
		$newsList = $ModelNews->getNewsByCurrentTime();
		
		//文字列置き換え
		foreach($newsList as &$news)
		{
			$news['text'] = nl2br($news['text']);
			$news['text'] = $this->strReplaceImg($news['text']);
		}
		
		$this->viewData['newsList'] = $newsList;
		
		//データ出力
		View_Wrap::noheader('top', $this->viewData);
	}
}
