<?php
class Controller_Shop extends Lib_Contents
{
	public function action_index( )
	{
		/*$ModelShop = new Model_Shop($this->userData);
		$this->viewData['shopList'] = $ModelShop->getViewShop();*/
		View_Wrap::contents('shop/top', $this->viewData);
	}
	public function action_confirm( )
	{
		View_Wrap::contents('shop/confirm');
	}
	public function action_complete( )
	{
		View_Wrap::contents('shop/complete');
	}
}