<?php
class Model_Base_Db extends Orm\Model 
{
	
	protected static $_created_at = 'created_at';
	protected static $_updated_at = 'updated_at';
	protected static $_mysql_timestamp = true;	
	
}