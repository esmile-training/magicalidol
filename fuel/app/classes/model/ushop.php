<?php

class Model_Ushop extends Model_Basegame
{
	protected static $_table_name = 'uShop';    // テーブル名がモデル名の複数形なら省略可
	protected static $_primariy = array('id');  // プライマリーキーがidなら省略可
	
	// 使用するフィールド名をセット
	protected static $_properties = array(
		'id',
		'userId',
		'productName',
	);
	
	/*
	 *  リレーション：リレーション対象側
	 *  外部で指定された主キーを持つテーブル (key_to => 主キー)
	 */
	protected static $_belongs_to = array(
        // リレーションの関係性を示す名前を指定
        'user' => array(
            'model_to'       => 'Model_User',   // 連結モデル名
            'key_from'       => 'userId',       // 連携させる値
            'key_to'         => 'id',           // 連結する値
            'cascade_save'   => false,          // ターゲットモデルも更新するかどうか
            'cascade_delete' => false,          // ターゲットモデルも削除するかどうか
        ),
    );
}