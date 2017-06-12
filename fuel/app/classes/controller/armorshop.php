<?php
class Controller_Armorshop extends Lib_Contents
{
	public function action_index($result=null)
	{
		$ModelArmor = new Model_armor($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		$ModelMaterial = new Model_Material($this->userData);
		
		//防具のデータを取得
		$armorData = $ModelArmor->getMaster();
		//ユーザーが持つ防具データ
		$userArmorData = $ModelArmor->getByUserId($this->userData['id']);
		//贈り物の中にある防具データ
		$userPresentData = $ModelPresent->getByUserId(4);
		//csvの素材データ
		$materialData = $ModelMaterial->getMaster(false);
		//購入の際必要となる素材の数のデータ
		Config::load('armor',true);
		$armorMaterial = Config::get('armor.armorMaterial');
		//ユーザーが所持する素材のデータ
		$userMaterialData = $ModelMaterial->getByUserId();
		
		//ユーザーがすでに持っている防具はsold out表示
		foreach($armorData as $id => $data)
		{
			$possession[$id] = false;
			foreach((array)$userArmorData as $userArmor)
			{
				if($id == $userArmor['armorId'])
				{
					$possession[$id] = true;
					break;
				}
			}
			if($possession[$id])
			{
				continue;
			}
			foreach((array)$userPresentData as $userPresent)
			{
				if($id == $userPresent['itemId'])
				{
					$possession[$id] = true;
					break;
				}
			}
		}
		
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
		
		//素材が足りているかどうかの配列を作成
		for($i = 1;$i <= sizeof($materialData);$i++)
		{
			$enoughMaterial[$i] = true;
		}
		//素材の数回す
		foreach($enoughMaterial as $id => $eMaterial)
		{
			//必要素材の種類の分回す
			foreach($armorMaterial[$id] as $materialId => $armorMaterialNum)
			{
				//所持数が必要数より少なければfalse
				if($userMaterial[$materialId] < $armorMaterialNum){ $enoughMaterial[$id] = false; }
			}
		}
		
		if($result)
		{
			if($result == 0)
			{
				$this->viewData['armormsg'] = '購入できません！';
				$this->viewData['armormsg2'] = '';
			}
			else
			{
				$this->viewData['armormsg'] = $armorData[$result]['name'].'を購入しました';
				$this->viewData['armormsg2'] = '受け取り箱から受け取ってください';
			}
		}
		else
		{
			$this->viewData['armormsg'] = '';
			$this->viewData['armormsg2'] = '';
		}
		
		$this->viewData['possession'] = $possession;
		$this->viewData['armorData'] = $armorData;
		$this->viewData['status'] = $this->userData;
		$this->viewData['enoughMaterial'] = $enoughMaterial;
		$this->viewData['armorMaterial'] = $armorMaterial;
		$this->viewData['userMaterial'] = $userMaterial;
		$this->viewData['materialData'] = $materialData;
		
		//画面表示
		if($result)
		{
			View_Wrap::contents('armorshop/armorshop', $this->viewData, 'modal');
		}
		else
		{
			View_Wrap::contents('armorshop/armorshop', $this->viewData);
		}
	}
	
	public function action_buyresult($armorId)
	{
		$ModelArmor = new Model_armor($this->userData);
		$ModelPresent = new Model_Present($this->userData);
		$ModelUser = new Model_User($this->userData);
		$ModelMaterial = new Model_Material($this->userData);
		
		//購入可能かどうか
		//ユーザーデータ取得
		$status = $this->userData;
		//防具のデータを取得
		$armorData = $ModelArmor->getMaster();
		//贈り物の中にある防具データ
		$userPresentData = $ModelPresent->getByUserId(4);
		//csvの素材データ
		$materialData = $ModelMaterial->getMaster();
		//購入の際必要となる素材の数のデータ
		Config::load('armor',true);
		$armorMaterial = Config::get('armor.armorMaterial');
		//ユーザーが所持する素材のデータ
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
		
		$bought = false;
		//所持金と値段を比較し、買える場合はtrueにする
		if($status['money'] >= $armorData[$armorId]['price'])
		{
			$bought = true;
		}
		//購入済みの場合は購入不可
		foreach((array)$userPresentData as $presentData)
		{
			if($presentData['itemId'] == $armorId)
			{
				$bought = false;
			}
		}
		//素材の数回す
		foreach($armorMaterial[$armorId] as $id => $materialNum)
		{
			//所持数が必要数より少なければfalse
			if($userMaterial[$id] < $materialNum){ $bought = false; }
		}
		
		if($bought == true)
		{
			$ModelUser->changeDifferenceMoney(-$armorData[$armorId]['price']);
			$this->reduceMaterials($this->userData['id'],$armorId);
			$ModelPresent->setToPost(4,$armorId,1,$armorData[$armorId]['status']);
		}
		else
		{
			$armorId = 0;
		}
		
		Response::redirect(CONTENTS_URL.'armorshop/index/'.$armorId);
	}
	
	private function reduceMaterials($userId,$armorId)
	{
		$ModelMaterial = new Model_Material($this->userData);
		
		$userMaterials = $ModelMaterial->getByUserId($userId);
		//config内のガチャに必要な素材のデータ
		Config::load('armor',true);
		//購入の際必要な素材データの取得
		$armorBuyData = Config::get('armor.armorMaterial');
		
		foreach($armorBuyData[$armorId] as $materialId => $count)
		{
			foreach($userMaterials as $userMaterial)
			{
				if($userMaterial['materialId'] == $materialId)
				{
					$ModelMaterial->reduceMaterial($userId, $materialId, $count);
					break;
				}
			}
		}
	}
}