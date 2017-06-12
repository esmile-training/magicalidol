<?php
class Controller_Admin extends Lib_Admin
{
	public function action_index( )
	{
		Session::delete('userId');
		View_Wrap::Admin('admin/top');
	}
	
	//指定メモページを表示
	public function action_memo( $view )
	{
		echo $view;
		View_Wrap::Admin('admin/memo/'.$view);
	}
	
	//アカウント新規作成ページを表示
	public function action_createpage($newId)
	{
		$this->viewData['newId'] = $newId;
		View_Wrap::Admin('admin/newaccount', $this->viewData);
	}
	
	//アカウント新規作成
	public function action_create()
	{
		$id = Input::post('newId');
		$name = Input::post('userName');
		
		$ModelUser = new Model_User();
		$ModelWeapon = new Model_Weapon();
		$ModelArmor = new Model_Armor();
		$ModelAvatar = new Model_Avatar();
		$ModelRoom = new Model_Room();
		
		$result = $ModelUser->insertUser($id, $name);
		$ModelWeapon->insertWeapon(1, 1, null, 1, $id);
		$ModelArmor->insertArmor(1, null, 1, $id);
		$ModelAvatar->resetAvatar($id);
		$ModelRoom->insertRoom($id,1,1);
		
		Session::set('userId',$id);
		
		Response::redirect(CONTENTS_URL.'top');
	}
	
	//お知らせ編集ページを表示
	public function action_editNews()
	{
		$newsId = input::post('id', null);
		
		$ModelNews = new Model_News();
		
		if(is_null($newsId))
		{
			$newsList = $ModelNews->getNewsAll();
			
			$this->viewData['newsList'] = $newsList;
			View_Wrap::Admin('admin/newsList', $this->viewData);
		}
		else
		{
			if($newsId == 0)
			{
				$newsData = array(
					"id" => null,
					"title" => null,
					"text" => null,
					"start" => null,
					"end" => null
				);
			}
			else
			{
				$newsData = $ModelNews->getById($newsId);
				
				//日時フォーマットを調整
				if(!is_null($newsData['start']))
				{
					$newsData['start'] = str_replace(" ", "T", $newsData['start']);
				}
				if(!is_null($newsData['end']))
				{
					$newsData['end'] = str_replace(" ", "T", $newsData['end']);
				}
			}
			
			$this->viewData['newsData'] = $newsData;
			View_Wrap::Admin('admin/newsEdit', $this->viewData);
		}
	}
	
	//お知らせ編集
	public function action_submitNews()
	{
		$inputData = input::post();
		
		$ModelNews = new Model_News();
		
		//日時フォーマットを調整
		if(!empty($inputData['start']))
		{
			$inputData['start'] = str_replace("T", " ", $inputData['start']);
		}
		if(empty($inputData['end']))
		{
			$inputData['end'] = null;
		}
		else
		{
			$inputData['end'] = str_replace("T", " ", $inputData['end']);
		}
		
		if(empty($inputData['id']))
		{
			$ModelNews->insertNews($inputData['title'], $inputData['text'], $inputData['start'], $inputData['end']);
		}
		else
		{
			$ModelNews->updateNews($inputData['id'], $inputData['title'], $inputData['text'], $inputData['start'], $inputData['end']);
		}
		
		Response::redirect(ADMIN_URL.'editNews');
	}
}
