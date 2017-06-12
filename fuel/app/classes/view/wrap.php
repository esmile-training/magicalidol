<?php
class View_Wrap extends Controller_Template
{
//	public static function contents( $view_pass, $data=array(), $header=null)
//	{
//		//ヘッダ読み込み
//		if ($header) {
//			$headerView = View::forge($header.'/header', $data);
//		} else {
//			$headerView = View::forge('common/header', $data);
//		}
//			
//		//本体読み込み
//		$bodyView = View::forge( $view_pass, $data, false);
//		//フッタ読み込み
//		$footerView = View::forge('common/footer');
//		//表示
//		echo $headerView.$bodyView.$footerView;
//	}
//	
	/*
	 * headerとfooterを付与
	 */
	public static function admin( $view_pass, $data=array())
	{
		//ヘッダ読み込み
		$headerView = View::forge('admin/common/header');
		//本体読み込み
		$bodyView = View::forge( $view_pass, $data);
		//フッタ読み込み
		$footerView = View::forge('admin/common/footer');
		//表示
		echo $headerView.$bodyView.$footerView;
	}
	
	/*
	 * headerとfooterを付与しない
	 */
	public static function mainonly( $view_pass, $data=array())
	{
		//ヘッダ読み込み
		$headerView = View::forge('admin/common/nomalheader');
		//本体読み込み
		$bodyView = View::forge( $view_pass, $data);
		//フッタ読み込み
		$footerView = View::forge('admin/common/nomalfooter');
		//表示
		echo $headerView.$bodyView.$footerView;
	}
}