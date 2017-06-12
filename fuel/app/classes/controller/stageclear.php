<?php
class Controller_StageClear extends Lib_Contents
{	
	public function action_index()
	{
		//instance作成
		$ModelDungeon = new Model_Dungeon($this->userData);
		
		//ダンジョンテーブルからデータを取得
		$getDb = $ModelDungeon->getDungeonDb($this->userData['id']);
		
		//取得したテーブルが空であるか調べる
		if(empty($getDb))
		{
			//空であれば、マイページにリダイレクト
			Log::debug('pass no DB');
			Response::redirect(CONTENTS_URL.'mypage');
			return;
		}
		
		//クリアしているか調べる
		if(!$getDb['clear'])
		{
			//クリアしていなければ、マイページへリダイレクト
			Log::debug('pass no clear');
			Response::redirect(CONTENTS_URL.'mypage');
			return;
		}
		
		//リザルト画面に表示する処理を行う
		$this->result($getDb['dungeonRank'],$getDb['dungeonId']);
		
		//ダンジョンのデータベース削除
		$ModelDungeon->deleteDungeonDb($this->userData['id']);
		
		Log::debug('pass clear');
		View_Wrap::contents('stageclear/top', $this->viewData);
		return;
	}
	
	public function result($stageRank,$stageId)
	{
		//インスタンス作成する
		$ModelDungeon = new Model_Dungeon($this->userData);
		$ModelMaterial = new Model_Material();
		$ModelPresent = new Model_Present($this->userData);
		
		//ステージデータから値を元に必要なデータを取得する。
		$list = $ModelDungeon->getDungeonData($stageRank,$stageId);
		//マテリアルのCSVからデータを取得する。
		$materials = $ModelMaterial->getMaster();
		
		//リストのゴールの中にある報酬配列を取得
		foreach($list['goal'] as $getData)
		{
			//取得したデータをカテゴリー別に処理をする。
			switch($getData['category'])
			{
				//ゴールドの場合
				case 1:
				{
					//stageConfigにあるcountMin.countMaxで振れ幅を設定
					$randomMoney = mt_rand($getData['countMin'], $getData['countMax']);
					$this->viewData['money'] = $randomMoney;
					//setToPostでお金を受け取り箱へ送る　　1 = お金識別id　0 = お金のid
					$ModelPresent->setToPost(1,0,$randomMoney);
					break;
				}
				//素材の場合
				case 2:
				{
					$material = $getData;
					//stageConfigにあるcountMin.countMaxで振れ幅を設定
					$material['count'] = mt_rand($getData['countMin'], $getData['countMax']);
					$getMaterial[] = $material;
					//setToPostで素材を受け取り箱へ送る　　2 = 素材識別id
					$ModelPresent->setToPost(2,$material['id'],$material['count']);
					break;
				}
				default:
					//ここでゴールド・素材、以外が入った場合は何もせず終了させる。
					break;
			}
			
		}
		
		if(isset($getMaterial))
		{
			$this->viewData['material'] = $getMaterial;
		}
		else
		{
			$this->viewData['material'] = null;
		}
		
		$this->viewData['materials'] = $materials;
		$this->viewData['list'] = $list;
	}

}
