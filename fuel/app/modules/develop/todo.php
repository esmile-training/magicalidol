<?php
class Controller_Admin_Todo extends Lib_Admin
{
	public function action_index( )
	{
		// 進捗ステータス
		$status = array(
			'1' => "新規",
			'2' => "作業中",
			'3' => "レビュー",
			'4' => "差し戻し",
			'9' => "完了",
		);
		
		// todoリストの取得（今は仮）
		$todoList = array(
			array(
				'id' => "1",
				'title' => "タイトル1",
				'name' => "Aさん",
				'fixedDate' => "今週中",
				'detail' => "作業内容",
				'status' => "1",
				'updateTime' => "*****",
				'createTime' => "*****",
			),
			array(
				'id' => "2",
				'title' => "タイトル2",
				'name' => "Bさん",
				'fixedDate' => "今週中",
				'detail' => "作業内容",
				'status' => "2",
				'updateTime' => "*****",
				'createTime' => "*****",
			),
		);
		
		//DBから値を受け取る
		$todoList = Model_Util::fetchAll('todo');
		
		// ビューに値を渡す
		$data['status'] = $status;
		$data['todoList'] = $todoList;
		View_Wrap::login('admin/todo', $data);
	}
	
	public function action_addTodo()
	{
		//POSTの値を受け取る
		$data = Input::post();
		
		//DBインサート
		Model_Todo::insert($data);
		Response::redirect(ADMIN_URL.'todo');
	}

}