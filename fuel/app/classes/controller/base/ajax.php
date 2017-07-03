<?php
/*
 * ajax受け取り先のコントローラーには必ずController_Restを指定
 */
class Controller_Base_Ajax extends Controller_Rest
{
	public function action_post_data()
    {
		// 配列を初期化
		$revision = array();
		
		// POST情報の受け取り
        $id = input::post('id');
		
		// データベース接続・処理
		$user_data = Model_User::find('first', array(
			'where' => array(
				'id' => $id
			)
		));
		
		// データベースからの情報だけ抽出
		foreach($user_data as $key => $val)
		{
			$revision[$key] = $val;
		}
		// json型に変換
		$conversion = json_encode($revision);
		// データをajaxに戻す
        return $this->response($conversion);
    }
}
