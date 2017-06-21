<?php
/*
 *	クラス名はアンダースコアで区切る
 *	配置されているフォルダ名を先頭に置き最初は大文字
 */

class Controller_Home extends Controller_Basegame
{
	/*
	 *	メソッド名はアンダースコアで区切る
	 */
	public function action_index()
	{
	

		// ヘッダーフッター付きのページを表示
		View_Wrap::mainonly('home/top', $this->viewData);
	}
}
