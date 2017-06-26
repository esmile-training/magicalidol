<?php

class Model_Ushop extends Model_Basegame
{
	protected static $_table_name = 'uShop';    // �e�[�u���������f�����̕����`�Ȃ�ȗ���
	protected static $_primariy = array('id');  // �v���C�}���[�L�[��id�Ȃ�ȗ���
	
	// �g�p����t�B�[���h�����Z�b�g
	protected static $_properties = array(
		'id',
		'userId',
		'productName',
	);
	
	/*
	 *  �����[�V�����F�����[�V�����Ώۑ�
	 *  �O���Ŏw�肳�ꂽ��L�[�����e�[�u�� (key_to => ��L�[)
	 */
	protected static $_belongs_to = array(
        // �����[�V�����̊֌W�����������O���w��
        'user' => array(
            'model_to'       => 'Model_User',   // �A�����f����
            'key_from'       => 'userId',       // �A�g������l
            'key_to'         => 'id',           // �A������l
            'cascade_save'   => false,          // �^�[�Q�b�g���f�����X�V���邩�ǂ���
            'cascade_delete' => false,          // �^�[�Q�b�g���f�����폜���邩�ǂ���
        ),
    );
}