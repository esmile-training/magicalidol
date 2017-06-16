<?php
class Lib_BaseGame
{
	public function __construct()
	{
		
	}
	
	public function exec($className, $method, $arg = false)
	{
		$className = 'Lib_' . $className;
		$libClass = new $className();
		
		//引数の数によって出しわけ
		if (is_array($arg))
		{
			return $result = call_user_func_array(array($libClass, $method), $arg);
		}
		elseif ($arg)
		{
			return $result = call_user_func_array(array($libClass, $method), array($arg));
		}
		else
		{
			return $result = $libClass->$method();
		};
	}
}