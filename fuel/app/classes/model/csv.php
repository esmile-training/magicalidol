<?php
class Model_Csv extends Model
{
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
}