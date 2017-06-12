<?php
class Controller_News extends Lib_Contents
{

	public function action_index($page=1){
		
		$ModelNews = new Model_News($this->userData);
		
		$newsList = $ModelNews->getNewsAll();
		
		$pageData = $this->listPager($newsList, $page);

		$this->viewData['newsList'] = $pageData['dataList'];
		$this->viewData['page'] = $page;
		$this->viewData['maxPage'] = $pageData['maxPage'];

		View_Wrap::noheader('news/top', $this->viewData);
	}
	
	public function action_detail($newsId){
		
		$ModelNews = new Model_News($this->userData);
		$this->viewData['detail'] = $ModelNews->getDetail($newsId);
		
		View_Wrap::noheader('news/detail', $this->viewData);
	}
}
