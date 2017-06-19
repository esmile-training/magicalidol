<?php

class Model_Ushop extends Model_Basegame
{
	protected static $_table_name = 'uShop';	//�e�[�u���������f�����̕����`�Ȃ�ȗ���
	protected static $_primariy = array('id');	//�v���C�}���[�L�[��id�Ȃ�ȗ���
	
	//�g�p����t�B�[���h�����Z�b�g
	protected static $_properties = array(
		'id',
		'userId',
		'productName',
	);
	
	protected static $_has_many = array(
        // �����[�V�����̊֌W�����������O���w��
        'user' => array(
            'model_to' => 'Model_User',
            'key_from' => 'userId',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => false,
        ),
    );
}