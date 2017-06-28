<?php
class Lib_User 
{
	public function get_cnt()
	{
		$count = DB::count_records('user');
		return $count;
	}

}

