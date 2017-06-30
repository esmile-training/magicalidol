<?php
class Controller_Base_Ajax extends Controller
{
	public $view_data;

	public function __construct()
	{

	}
	
	public function post()
	{
		$content = Input::post('name');
		echo json_decode($content);
	}
}
