<?php

class Controller_Mypage extends Controller_Basegame
{
	public function action_index()
	{
		/*
		 * ライブラリはクエリで必要になる値を処理させる
		 * ライブラリからのモデルの実行はできない
		 */
		$data = $this->Lib->exec('User', 'test', [10, 'masaya']);
		
		
		var_dump($_POST['name']);

		//insert
		//Controller_Mypage::insert($data);
		
		
		//select
		$select = Controller_Mypage::select();
		
		//update
		//Controller_Mypage::update();
		
		//delete
		//Controller_Mypage::deleted();
		
		// リレーショナルorm
		//Controller_Mypage::relations();
		
		// csvmodel
		$weaponList = $this->Lib->getAll('/weapon/mst1');
		
		$combining = $this->Lib->combining($select, $weaponList, 'weapon');
		
		
		// ヘッダーフッター付きのページを表示
		View_Wrap::admin('mypage', $this->viewData);
	}
	
	public function insert($data = null)
	{
		// 実行
		Model_User::forge($data)->save();
	}
	
	public function select()
	{
		// 現在登録されているすべての値を取得
		$select = Model_User::find('all');
		
		// 最後の一件だけ取得し、特定のカラムだけを取得
		//$select = Model_User::find('last', array('select' => array('id', 'name')));
		
		// 条件式のみ
		// select, fromの指定は各モデルで指定
		//$select = Model_User::find('all', array('where' => array('name' => 'user3')));
		
		
		return $select;
	}
	
	public function update()
	{
		// findの引数は$_primariyで設定したカラムの値
		$update = Model_User::find(6);
		
		// カラムと変更する値を指定
		$update->set(array(
			'name' => 'aser'
		));
		
		// 実行
		$update->save();
	}
	
	public function deleted()
	{
		// findの引数は$_primariyで設定したカラムの値
		$delete = Model_User::find(5);
		
		// 実行
		$delete->delete();
	}
	
	public function relations()
	{
		$results = Model_User::find(2);		// 引数はkey_fromで設定したカラムと自動でwhere句を生成
		echo $results->uShop->productName;	// 指定のカラムまでアローで指定
	    
	}
}
