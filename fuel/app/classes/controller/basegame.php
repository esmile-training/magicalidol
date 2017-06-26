<?php
class Controller_Basegame extends Controller
{
	public $view_data;
	
	// 秘密キー、暗号化方式、バイト指定
	private $hash_key 	= 'defult';
	private $method 	= 'bf-cbc';
	private $byte 		= '12345678';
	
	
	public function __construct()
	{
		// BaseGameLibインスタンス化
		$this->Lib = new Lib_Basegame();
		
		// 現在のディレクトリ名を取得し、configのディレクトリ名を取得
		$path = ltrim(CONTENTS_URL);
		$file = Config::load('fileCheck');
		
		// ユーザ認証のないページの判定
		if(in_array($path, $file))
		{
			return false;
		}
	}
	
	/*
	 *	imgリンクを暗号化して生成
	 */
	public function img_url($url, $function, $img, $value = null)
	{
		// 配列であればそれぞれ暗号化
		if(is_array($value))
		{
			foreach($value as $key => $val)
			{
				$value[$key] = bin2hex(openssl_encrypt($val, $this->method, $this->hash_key, OPENSSL_RAW_DATA, $this->byte));
			}
			
			// action引数に整形
			$value = implode("/", $value);
		}
		else
		{
			$value = bin2hex(openssl_encrypt($value, $this->method, $this->hash_key, OPENSSL_RAW_DATA, $this->byte));
		}
		
		// linkを生成
		$link = Html::anchor(
			$url.'/'.$function.'/' . $value,
			Asset::img($img)
		);
		
		return $link;
	}
	
	/*
	 *	暗号化されたデータを複合化
	 */
	public function url_marge($value)
	{
		// 配列であればそれぞれ複合化
		if(is_array($value))
		{
			foreach($value as $key => $val)
			{
				$value[$key] = openssl_decrypt(hex2bin($val), $this->method, $this->hash_key, OPENSSL_RAW_DATA, $this->byte);
			}
		}
		else
		{
			$value = openssl_decrypt(hex2bin($value), $this->method, $this->hash_key, OPENSSL_RAW_DATA, $this->byte);
		}
		
		return $value;
	}
	
	
}