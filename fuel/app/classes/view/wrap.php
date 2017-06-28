<?php
class View_Wrap extends Controller_Template
{
	/*
	 * headerとfooterを付与
	 */
	public static function contents( $view_pass, $data = array(), $header = true, $footer = true )
	{
		
		$header_view = "";
		$body_view = "";
		$footer_view = "";
		
		//ヘッダ読み込み
		if( $header ) $header_view = View::forge('common/header');

		//本体読み込み
		$body_view = View::forge( $view_pass, $data, false);

		//フッタ読み込み
		if( $footer ) $footer_view = View::forge('common/footer');

		//表示
		echo $header_view.$body_view.$footer_view;
	}
	/*
	 * headerとfooterを付与
	 */
	public static function admin( $view_pass, $data = array() )
	{
		//ヘッダ読み込み
		$header_view = View::forge('admin/common/header');

		//本体読み込み
		$body_view = View::forge( 'admin/'.$view_pass, $data, false);

		//フッタ読み込み
		$footer_view = View::forge('admin/common/footer');

		//表示
		return $header_view.$body_view.$footer_view;

	}
}