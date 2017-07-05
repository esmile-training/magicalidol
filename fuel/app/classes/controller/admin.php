<?php
class Controller_Admin extends Controller_Base_Admin
{
	/*
	 * 管理画面TOP
	 */
	public function action_index()
	{
		return View_Wrap::admin('index', $this->view_data);
	}

	/*
	 * キャラ一覧
	 */
	public function action_user_list( )
	{
		//検索条件
		$param = input::get();
		$where = array();
		$get_url = "?";

		$this->view_data['user_id'] = "";
		if(isset($param['user_id']) && $param['user_id']){
			$where[] = array("id", "IN", explode(",", $param['user_id']));
			$get_url .= 'user_id='.$param['user_id'];
			$this->view_data['user_id'] = $param['user_id'];
		}
		$this->view_data['user_name'] = "";
		if(isset($param['user_name']) && $param['user_name']){
			$where[] = array('name', 'LIKE', '%'.$param['user_name'].'%');
			$get_url .= 'user_name='.$param['user_name'];
			$this->view_data['user_name'] = $param['user_name'];
		}

		//件数取得
		$total_items = Model_User::count(array(
			'where' => $where,
		));

		//ページャ設定
		$config = array(
			'pagination_url' => ADMIN_URL.'user_list'.$get_url,
			'uri_segment' => 'page',
			'num_links' => 9,
			'per_page' => 10,
			'total_items' => $total_items,
			'name' => 'pagination',
			'show_first' => true,
			'show_last' => true,
		);
		Pagination::set_config($config);


		//ユーザデータ取得
		$this->view_data['user_list'] = Model_User::find('all', array(
			'where' => $where,
			'limit' => Pagination::get('per_page'),
			'offset' => Pagination::get('offset'),
			'order_by' => array('id' => 'asc'),
			
		));

		//ビュー表示
		return View_Wrap::admin('user_list', $this->view_data);
	}
	/*
	 * ユーザ編集画面
	 */
	public function action_user_edit( $user_id )
	{
		$this->view_data['user_id'] = $user_id;

		//ユーザデータ取得
		$this->view_data['user'] = Model_User::find('first', array(
			'where' => array(
				'id' => $user_id
			)
		));
		
		//ビュー表示
		return View_Wrap::admin('user_edit', $this->view_data);
	}

	/*
	 * ユーザ編集・削除
	 */
	public function action_edit( $user_id )
	{
		//POSTデータ受け取り
		$param = input::post();
		
		//ユーザデータ取得
		$Model_user = Model_User::find('first', array(
			'where' => array(
				'id' => $user_id
			)
		));
		
		//削除
		if(isset($param['delete']) && $param['delete']){
			$Model_user->delete();
			//リダイレクト
			Response::redirect('admin/user_list');
		}
		var_dump($param);
		//更新処理
		foreach($param as $key => $val){
			$Model_user->$key = $param[$key];
		}
		$Model_user->save();
		
		//リダイレクト
		Response::redirect('admin/user_list');
	}
		

	/*
	 * 魔物図鑑
	 */
	public function action_ennemy_list()
	{
		//魔物データ取得
		$this->view_data['enemmy_mst'] = $this->csv->getAll('/enemy/mst');

		//ビュー表示
		return View_Wrap::admin('enemmy_list', $this->view_data);
	}
	
	
	/*
	 * ポップアップ
	 */	
	public function action_popup()
	{
		$this->view_data['value'] = 'abc';
		
		return View_Wrap::admin('popup', $this->view_data);
	}

	/*
	 * スタッフロール
	 */
	public function action_staff()
	{
		Config::load('admin/staff');										//コンフィグファイルをロード
		$this->view_data['staff_list'] = Config::get('admin_staff.list');	//コンフィグ取得

		return View_Wrap::admin('staff', $this->view_data);
	}

}
