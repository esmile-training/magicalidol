<?php

class Model_UShop extends Model_Basegame
{
	protected static $_table_name = 'uShop';		//�e�[�u���������f�����̕����`�Ȃ�ȗ���
	protected static $_primariy = array('id');	//�v���C�}���[�L�[��id�Ȃ�ȗ���
	
	//�g�p����t�B�[���h�����Z�b�g
	protected static $_properties = array(
		'id',
		'userId',
		'productName',
	);
	
	protected static $_belongs_to = array(
        // �����[�V�����̊֌W�����������O���w��
        'uShop' => array(
            'model_to' => 'Model_User',
            'key_from' => 'userId',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
    );
}