<?php
class Controller_Admin extends Lib_Admin
{
	/*
	 * 最初に表示されるページ
	 */
	public function action_index()
	{
		return View::forge('admin/top');
	}
	
	/*
	 * 指定メモページを表示
	 * action_???の部分はフォルダの構成と一致している。
	 * ???以下の階層のファイル名を取得可能。
	 * 例： action_memo -> memo/server ,svn
	 */
	public function action_memo( $view )
	{
		echo $view;
		View_Wrap::mainonly('admin/memo/'.$view);
	}
}
