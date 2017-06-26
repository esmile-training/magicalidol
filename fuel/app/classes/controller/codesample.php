<?php

class Controller_Codesample extends Controller_Basegame
{
	public function action_index()
	{
		/*
		 * ライブラリはクエリで必要になる値を処理させる
		 * ライブラリからのモデルの実行はできない
		 */
		$data = $this->Lib->exec('User', 'test', [10, 'masaya']);
		
		$this->view_data['img'] = $this->img_url('mypage', 'test', 'background.jpg', ['abcdefghijklmnopqrstuwxyz', '1234567890']);
		
		// config
		$this->view_data['config'] = Config::load('user');
		
		//insert
		//Controller_Codesample::insert($data);
		
		
		//select
		$select = Controller_Codesample::select();
		
		//update
		//Controller_Codesample::update();
		
		//delete
		//Controller_Codesample::deleted();
		
		// リレーショナルorm
		$this->view_data['relation'] = Controller_Codesample::relations();
		
		// csvmodel
		$weaponList = $this->Lib->getAll('/weapon/mst1');
		$combining = $this->Lib->combining($select, $weaponList, 'weapon');
		
		// ヘッダーフッター付きのページを表示
		View_Wrap::admin('codesample/index', $this->view_data);
	}
	
	/*
	 *	INSERT文
	 */
	public function insert($data = null)
	{
		// 実行
		Model_User::forge($data)->save();
	}
	
	/*
	 *	SELECT文
	 */
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
	
	/*
	 *	UOPDATE文
	 */
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
	
	/*
	 *	DELET文
	 */
	public function deleted()
	{
		// findの引数は$_primariyで設定したカラムの値
		$delete = Model_User::find(5);
		
		// 実行
		$delete->delete();
	}
	
	/*
	 *	リレーション文
	 */
	public function relations()
	{
		$results = Model_User::find(1); // 引数はkey_fromで設定したカラムと自動でwhere句を生成
		$relation = $results->uShop;	// 指定のカラムまでアローで指定
	    
	    /*
	    // 配列化させたい場合はこれを使う
	    $array = array();
	    // リレーションのデータを置き換え
    	foreach($relation as $key => $val)
    	{
			foreach($val as $valkey => $valval)
			{
				$array[$key][] = $valval;
			}
		}
		return $array;
		*/
		return $relation;
	}
	
	/*
	 *	URLの複合化
	 */
	public function action_test($data1, $data2)
	{
		var_dump($this->url_marge([$data1, $data2]));
	}
}
