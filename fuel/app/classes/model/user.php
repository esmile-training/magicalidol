<?php
namespace Model;
class User extends  \Model
{
	public $userData;
	/**
     * テーブル名
     * @var string
     */
    protected static $_table_name = 'user';

    /**
     * テーブルのプライマリキー
     * @var array
     */
    protected static $_primary_key = array('id');
	
	protected static $_properties = array(
        'id' => array(
            'data_type'  => 'int',
            'label'      => 'id',
            'validation' => array(
                'required',
                'valid_string' => array(array('numeric')),
            ),
            'form'      => array('type' => false),
        ),
        // 店舗エリアid
        'name' => array(
            'data_type'  => 'int',
            'label'      => 'name',
            'validation' => array(
                'required',
                'valid_string' => array(array('numeric')),
            ),
            'form'      => array('type' => false),
        ),
    );
	/*
	public function __construct($userData = null){
		$this->userData = $userData;
	}

	public function getById($userId)
	{
		return $userId;
	}
	
	public function getData($userId)
	{
		
	}
	 */
}