<?php
/*
 * ajax受け取り先のコントローラーには必ずController_Restを指定
 */
class Controller_Base_Ajax extends Controller_Rest
{
	/*
	 * POSTされたユーザIDからデータを取得
	 */
	public function action_post_data($user_id)
    {
		// 配列を初期化
		$revision = array();
		
		// データベース接続・処理
		$user_data = Model_Developer::find('first', array(
			'where' => array(
				'id' => $user_id
			)
		));
		
		if(is_null($user_data))
		{
			// データがない時の判定用
			$revision['data'] = false;
			$revision['id'] = $user_id;
		}else{
			// データベースからの情報だけ抽出
			foreach($user_data as $key => $val)
			{
				$revision[$key] = $val;
			}
		}
		// json型に変換
		$conversion = json_encode($revision);
		// データをajaxに戻す
        return $this->response($conversion);
    }
    
	
	/*
	 * 開発者の削除・追加
	 */
	public function action_chenge_developer($user_id)
	{
		// userデータの取得
		$user_data = Model_Developer::find('first', array(
			'where' => array(
				'user_id' => $user_id
			)
		));
		
		// ユーザ情報がなかった時
		if(is_null($user_data))
		{
			
		}
		else
		{
			$user_data->delete();
			$revision['data'] = false;
			$revision['id'] = $user_id;
		}
		
		// json型に変換
		$conversion = json_encode($revision);
		// データをajaxに戻す
        return $this->response($conversion);
	}
}
