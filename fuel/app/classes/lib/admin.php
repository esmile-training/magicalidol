<?php
class Lib_Admin extends Controller
{
	public function __construct()
	{
		$this->viewData = array();
	}
	
	/*
	  文字列置き換え
	  $replace(array):置き換え文字連想配列(key:置換前 => value:置換後)
	  $subject(string):置き換え文字列
	  $isRegular(bool):正規表現フラグ
	  return:string
	*/
	public function strReplaceAssoc(array $replace, $subject, $isRegular=false)
	{
		if($isRegular)
		{
			$result = preg_replace(array_keys($replace), array_values($replace), $subject);
		}
		else
		{
			$result = str_replace(array_keys($replace), array_values($replace), $subject);
		}
		return $result;
	}

}
