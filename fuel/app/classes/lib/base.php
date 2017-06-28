<?php
class Lib_Base
{
	public function __construct()
	{
		// Modelインスタンス化
		$this->csv = new Model_Base_Csv();
	}
}

