<?php
class Controller_Mypage extends Controller_Basegame
{
	public function action_index()
	{
		// インスタンス化
		$this->viewData['libData'] = $this->Lib->exec();
		
		$modelUser = $this->Model->newIns('User');
		$this->viewData['modelData'] = $modelUser->totalCount();
		
		// ヘッダーフッター付きのページを表示
		View_Wrap::admin('mypage', $this->viewData);
	}
}
