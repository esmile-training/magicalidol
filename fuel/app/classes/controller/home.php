<?php
class Controller_Home extends Controller_Basegame
{	
	public function action_index()
	{
		// インスタンス化
		//$this->viewData['libData'] = $this->Lib->exec();
		
		// ヘッダーフッター付きのページを表示
		View_Wrap::admin('home/top', $this->viewData);
	}
}
