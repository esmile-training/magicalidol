<?php
class View_Parts extends Controller_Template
{
	public static function img( $file, $options = array() )
	{
		$result = '<img src=http://'.$_SERVER['SERVER_NAME'].'/img/'.$file;
		foreach( $options as $key => $value ){
			$result .= ' '.$key.'='.'"'.$value.'"';
		}
		$result .= '>';
		return $result;
	}
	
	public static function link( $file, $options = array() )
	{
		$result = '<a src=http://'.$_SERVER['SERVER_NAME'].'/img/'.$file;
		foreach( $options as $key => $value ){
			$result .= ' '.$key.'='.'"'.$value.'"';
		}
		$result .= '>';
		return $result;
	}
}