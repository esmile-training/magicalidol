<?php
class Controller_Base_Admin extends Controller
{
	public $view_data;

	public function __construct()
	{
		// Modelインスタンス化
		$this->csv = new Model_Base_Csv();
	}

}

