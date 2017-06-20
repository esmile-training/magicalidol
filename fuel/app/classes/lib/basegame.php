<?php
class Lib_Basegame
{
	public function __construct()
	{
		
	}
	
	public function exec($className, $method, $arg = false)
	{
		$className = 'Lib_' . $className;
		$libClass = new $className();
		
		//�����̐��ɂ���ďo���킯
		if (is_array($arg))
		{
			return $result = call_user_func_array(array($libClass, $method), $arg);
		}
		elseif ($arg)
		{
			return $result = call_user_func_array(array($libClass, $method), array($arg));
		}
		else
		{
			return $result = $libClass->$method();
		};
	}
	
	/*
	*	CSV�S���擾
	*	@fileName	public/assets/scv�ȉ��̃t�@�C����(�g���q����)
	*	@rowKey		�e�s�̃L�[�ɂ���J�����i0�Ԗڂ͑��iid�j
	*/
	public function getAll($fileName, $rowKey=0){
		$allList = Asset::csv($fileName);
		//1�s�ڂ̓J������
		$keyList = array_shift($allList);
		$result = array();
		foreach($allList as $row){
			//2�s�ڈȍ~�́A�擪�J������key�ɂ���B
			$id = (int)$row[0];
			foreach($row as $key => $value){
				//�f�[�^�́A�J������=>�f�[�^�ɕ��ёւ�(�󕶎���NULL)
				$result[$id][$keyList[$key]] = ($value)? $value : null;
			}
		}
		return $this->format($fileName, $result);
	}
	
	/*
	*	�b�r�u�͑S�ĕ����^�̂��߁A�R���t�B�O�ݒ�ɏ]���Č^��ϊ�
	*/
	public function format($fileName, $data){
		Config::load('csv/'.$fileName);
		$format = Config::get('format');
		foreach($data as $id => $row){
			foreach($row as $key => $value){
				if( !isset($format[$key]) ) continue;
				switch($format[$key]){
					case 'int':
						$data[$id][$key] = (int)$value;
						break;
					case 'json':
						$data[$id][$key] = json_decode($value,TRUE);
					case 'string':
					default:
						break;
				}
			}
		}
		return $data;
	}
	
	/*
	*	csv��Model����擾�����f�[�^������
	*/
	
	public function combining($modelData, $csvData, $code = 'user'){
	
		$code_id	= $code . "Id";
		$code_mst	= $code . "Mst";

		foreach($modelData as $modelval)
		{
			$modelval->$code_mst = ( isset( $csvData[$modelval->$code_id] ) )? $csvData[$modelval->$code_id] : null;
		}
		
		return $modelval;
	}
}

