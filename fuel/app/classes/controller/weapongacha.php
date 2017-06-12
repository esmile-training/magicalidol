<?php
class Controller_WeaponGacha extends Lib_Contents
{
	public function action_index($resultId=null,$weaponId=null)
	{
		//データ取得
		$ModelWeapon = new Model_weapon($this->userData);
		$ModelEvent = new Model_Event($this->userData);
		$ModelMaterial = new Model_Material($this->userData);
		
		//csvの素材データ
		$materialData = $ModelMaterial->getMaster(false);
		//config内のガチャに必要な素材のデータ
		Config::load('weapon',true);
		$weaponGachaData = Config::get('weapon.weaponGacha');
		//ユーザーデータ(所持金参照用)
		$userData = $this->userData;
		//ユーザーが所持する素材データ
		$userMaterialData = $ModelMaterial->getByUserId();
		//武器データ取得
		if($weaponId)
		{
			$weaponData = $ModelWeapon->getMaster($weaponId);
		}
		//イベントデータ取得
		$eventGachaData = $ModelEvent->getMargeDataBycurrentTime(4);
		
		//ユーザーが持っていない素材を0として扱う配列を用意
		//最初すべての要素を0で初期化
		for($i = 1;$i <= sizeof($materialData);$i++)
		{
			$userMaterial[$i] = 0;
		}
		//素材の数回す
		foreach($userMaterial as $id => $materialNum)
		{
			//ユーザーの持つ素材の数回す
			foreach((array)$userMaterialData as $materials)
			{
				//$userMaterialのキーとuserMaterialData[materialId]を突き合わせる
				if($materials['materialId'] == $id)
				{
					$userMaterial[$id] = $materials['count'];
				}
			}
		}
		
		//ガチャを回せるかどうかの配列を作成
		//最初すべての要素をtrueで初期化
		$canGacha = array();
		foreach($materialData as $value)
		{
			$canGacha[$value['id']] = true;
		}
		//素材の数回す
		foreach($canGacha as $canId=>&$can)
		{
			foreach($weaponGachaData as $gachaId=>$gachaData)
			{
				if($canId == $gachaId)
				{
					//お金が足りなければfalse
					if($userData['money'] < $gachaData['gold'])
					{
						$can = false;
						break;
					}
					foreach($gachaData['material'] as $materialId => $weaponGachaNum)
					{
						foreach($userMaterial as $id=>$data)
						{
							//所持数が必要数より少なければfalse
							if($materialId == $id)
							{
								if($data < $weaponGachaNum)
								{
									$can = false;
								}
								break;
							}
						}
					}
				}
			}
		}
		
		//viewDataに値を渡す
		//素材データ
		$this->viewData['materialData'] = $materialData;
		//必要素材データ
		$this->viewData['weaponGachaData'] = $weaponGachaData;
		//ユーザーデータ
		$this->viewData['userData'] = $userData;
		//ユーザーが持つ素材数
		$this->viewData['userMaterialNum'] = $userMaterial;
		//ガチャを回せるかどうか
		$this->viewData['canGacha'] = $canGacha;
		//イベントデータ
		if(!empty($eventGachaData))
		{
			$this->viewData['eventGachaData'] = array_shift($eventGachaData);
		}
		//メッセージ
		if($resultId)
		{
			if($resultId == 0)
			{
				$this->viewData['gachamsg'] = '合成に失敗しました';
				$this->viewData['gachamsg2'] = '';
			}
			else
			{
				$this->viewData['gachamsg'] = $weaponData[$resultId]['name'].'を手に入れました';
				$this->viewData['gachamsg2'] = '受け取り箱から受け取ってください';
			}
			
		}
		else
		{
			$this->viewData['gachamsg'] = '';
			$this->viewData['gachamsg2'] = '';
		}
		
		//画面表示
		if($resultId)
		{
			View_Wrap::contents('weapongacha/weapongacha' , $this->viewData, 'modal');
		}
		else
		{
			View_Wrap::contents('weapongacha/weapongacha' , $this->viewData);
		}
	}
	
	public function action_gacharesult($materialid)
	{
		//データ取得
		$ModelWeapon = new Model_weapon($this->userData);
		$ModelEvent = new Model_Event($this->userData);
		$ModelMaterial = new Model_Material($this->userData);
		$ModelUser = new Model_User($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		
		//素材データのCSV
		$materialData = $ModelMaterial->getMaster(false);
		//config内のガチャに必要な素材のデータ
		Config::load('weapon',true);
		$weaponGachaData = Config::get('weapon.weaponGacha');
		//ユーザーデータ(所持金参照用)
		$userData = $this->userData;
		//ユーザーが所持する素材データ
		$userMaterialData = $ModelMaterial->getByUserId();
		
		//ユーザーが持っていない素材を0として扱う配列を用意
		//最初すべての要素を0で初期化
		for($i = 1;$i <= sizeof($materialData);$i++)
		{
			$userMaterial[$i] = 0;
		}
		//素材の数回す
		foreach($userMaterial as $id => $materialNum)
		{
			//ユーザーの持つ素材の数回す
			foreach((array)$userMaterialData as $materials)
			{
				//$userMaterialのキーとuserMaterialData[materialId]を突き合わせる
				if($materials['materialId'] == $id)
				{
					$userMaterial[$id] = $materials['count'];
				}
			}
		}
		
		//ガチャを回せるかどうかの配列を作成
		//最初すべての要素をtrueで初期化
		for($j = 1;$j <= sizeof($materialData);$j++)
		{
			$canGacha[$j] = true;
		}
		//素材の数回す
		foreach($canGacha as $canId => $can)
		{
			//お金が足りなければfalse
			if($userData['money'] < $weaponGachaData[$canId]['gold']){ $canGacha[$canId] = false; }
			foreach($weaponGachaData[$canId]['material'] as $weaponGachaId => $weaponGachaNum)
			{
				//所持数が必要数より少なければfalse
				if($userMaterial[$weaponGachaId] < $weaponGachaNum){ $canGacha[$weaponGachaId] = false; }
			}
		}
		
		//ガチャが引けるかどうかの確認
		//引けなければ「引けない」と表示してガチャトップ画面に戻る
		$canGachaThis = true;
		//素材の数回す
		//お金が足りなければfalse
		if($userData['money'] < $weaponGachaData[$materialid]['gold']){ $canGachaThis = false; }
		foreach($weaponGachaData[$materialid]['material'] as $canGachaId => $canGachaNum)
		{
			//所持数が必要数より少なければfalse
			if($userMaterial[$canGachaId] < $canGachaNum){ $canGachaThis = false; }
		}
		
		if($canGachaThis)
		{
			//武器を合成する処理
			//合成される武器の決定
			$randomMaterial = $this->getRandomMaterial($materialid);
			$weaponCategory = $this->getRandomWeapon();
			//DBから消費した素材を減らす
			$this->reduceMaterials($this->userData['id'],$materialid);
			$ModelUser->changeDifferenceMoney(-$weaponGachaData[$materialid]['gold']);
			//初期攻撃力取得
			$firstStatus = Config::get("weapon.baseStatus.".$randomMaterial);
			//贈り物に送る
			$ModelPresent->setToPost(3,$randomMaterial,1,$firstStatus,$weaponCategory);
		}
		else
		{
			$weaponCategory = 0;
		}
		
		Response::redirect(CONTENTS_URL . 'weapongacha/index/'.$randomMaterial.'/'.$weaponCategory);
	}
	
	private function reduceMaterials($userId,$materialId)
	{
		$ModelMaterial = new Model_Material($this->userData);
		
		$userMaterials = $ModelMaterial->getByUserId();
		//config内のガチャに必要な素材のデータ
		Config::load('eventWeaponGacha',true);
		//ガチャ成功率データの取得
		$weaponGachaData = Config::get('eventWeaponGacha.weaponGachaMaterial');
		
		foreach($weaponGachaData[$materialId]['material'] as $id => $count)
		{
			foreach($userMaterials as $userMaterial)
			{
				if($userMaterial['materialId'] == $id)
				{
					$ModelMaterial->reduceMaterial($userId, $id, $count);
					break;
				}
			}
		}
	}
	
	private function getRandomWeapon()
	{
		$ModelEvent = new Model_Event($this->userData);
		$eventGachaData = $ModelEvent->getMargeDataBycurrentTime(4);
		//config内のガチャに必要な素材のデータ
		Config::load('weaponGachaRate',true);
		//ガチャ成功率データの取得
			switch($eventGachaData)
			{
				case '1':
					$eventGachaData = Config::get('weaponGachaRate.eventGachRateAx');
					break;
				case '2':
					$eventGachaData = Config::get('weaponGachaRate.eventGachaRateSword');
					break;
				case '3':
					$eventGachaData = Config::get('weaponGachaRate.eventGachaRateBoomerang');
					break;
				case '4':
					$eventGachaData = Config::get('weaponGachaRate.eventGachaRateSickle');
					break;
				default:
					$eventGachaData = Config::get('weaponGachaRate.gachaRate');
					break;
			}
		
		//ガチャの成功率をすべて足す
		$totalRate = 0;
		foreach($eventGachaData as $id => $rate)
		{
			$totalRate += $rate['rate'];
		}
		//乱数値から何の武器ができたかを判定
		$randomRate = mt_rand(0,$totalRate-1);
		
		foreach($eventGachaData as $id => $rate)
		{
			if($randomRate < $rate['rate'])
			{
				$weaponCategory = $id;
				break;
			}
			else
			{
				$randomRate -= $rate['rate'];
			}
		}
		
		//$weaponGachaId = 6*($weaponCategory-1)+$materialId;
		
		return $weaponCategory;
	}
	
	private function getRandomMaterial($materialId)
	{
		//config内のガチャに必要な素材のデータ
		Config::load('weapon',true);
		//ガチャに必要な素材数のデータ
		$weaponGachaData = Config::get('weapon.weaponGacha');
		$weaponGachaData = $weaponGachaData[$materialId]['rate'];
		
		$totalRate = 0;
		foreach($weaponGachaData as $id => $rate)
		{
			$totalRate += $rate;
		}
		$randNum = mt_rand(0,$totalRate-1);
		foreach($weaponGachaData as $id => $rate)
		{
			if($randNum < $rate)
			{
				$resultId = $id;
				break;
			}
			else
			{
				$randNum -= $rate;
			}
		}
		return $resultId;
	}
}