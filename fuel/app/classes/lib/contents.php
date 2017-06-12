<?php
class Lib_Contents extends Controller
{
	/*
	public function __construct()
	{
		//セッションからuser_id取ってくる
		$userId = Session::get('userId');
		if( !$userId ){
			//セッションに無ければポストから取得
			$userId = Input::post('userId');
			if( !$userId ) 
			{
				Response::redirect(ADMIN_URL);
				return;
			}
			//セッションにユーザIDに入れる
			Session::set('userId', $userId );
			Response::redirect(CONTENTS_URL.'top');
			return;
		}
		
		//ユーザ情報の取得
		$ModelDb = new Model_Base_Db();
		$this->userData = $ModelDb->getByIdBase( 'user', $userId );
		if( empty($this->userData) || $this->userData['id']==0)
		{
			if(ctype_digit($userId) && $userId!=0)	//入力されたuserIdが数字だった場合
			{
				//アカウント作成ページに遷移
				Response::redirect(CONTENTS_URL.'admin/createpage/'.$userId);
				return;
			}
			else	//そうでなければ
			{
				//セッションを終了し、管理画面に戻る
				Session::delete('userId');
				Response::redirect(ADMIN_URL);
				return;
			}
		}
		
		//表示用（ユーザテーブル＆現在時刻）
		$this->viewData['userData'] = $this->userData;
		$this->viewData['nowTime'] = $this->nowTime = is_null($this->userData['currentTime'])? date("Y-m-d H:i:s") : $this->userData['currentTime'];
		$this->userData['nowTime'] = $this->nowTime;
		
		//最終アクセス時間を更新
		$ModelUser = new Model_User($this->userData);
		$ModelUser->updateUpdateTime();
		
		//多重装備チェック
		$ModelWeapon = new Model_weapon();
		$ModelArmor = new Model_armor();
		$ModelAvatar = new Model_Avatar();
		$ModelRoom = new Model_Room();
		$userWeapon = $ModelWeapon->getByUserId($userId, 0, 1);
		$userArmor = $ModelArmor->getByUserId($userId, 1);
		$userAvatar = $ModelAvatar->getByUserId($userId, null, 1);
		$userRoom = $ModelRoom->getByUserId($userId, 1);
		if(count($userWeapon)>1)
		{
			array_shift($userWeapon);
			foreach($userWeapon as $weapon)
			{
				$ModelWeapon->changeWeapon($weapon['id'], 0);
			}
		}
		if(count($userArmor)>1)
		{
			array_shift($userArmor);
			foreach($userArmor as $armor)
			{
				$ModelArmor->changeArmor($armor['id'], 0);
			}
		}
		if(count($userAvatar)!=5)
		{
			$ModelAvatar->resetAvatar($userId);
		}
		if(count($userRoom)!=1)
		{
			$ModelRoom->resetRoom($userId);
		}
		
		//戦闘中チェック
		$ModelBattle = new Model_Battle();
		if(($_SERVER["REQUEST_URI"] != '/'.ENVIRONMENT.'/battle') && ($_SERVER["REQUEST_URI"] != '/'.ENVIRONMENT.'/top') && $ModelBattle->isBattle($userId))
		{
			Response::redirect(CONTENTS_URL.'battle');
			return;
		}
		
		//HP、APの時間経過による回復
		$ModelUser->recoverByTime(1,5);
		$ModelUser->recoverByTime(2,3);
		
		unset($ModelBattle);
		unset($ModelWeapon);
		unset($ModelArmor);
		unset($ModelAvatar);
		unset($ModelUser);
		unset($ModelDb);
	}*/
	
	/*
	  連想配列をキーでソート
	  $array:ソート配列
	  $sortKey:ソート対象キー
	  $sortType:ソート順
	  return:array
	*/
	public function arraySortByKey($array, $sortKey, $sortType=SORT_ASC)
	{
		foreach($array as $key=>$row)
		{
			$tmpArray[$key] = $row[$sortKey];
		}
		array_multisort($tmpArray, $sortType, $array);
		
		return $array;
	}
	
	/*
	  ページャー
	  $dataList:ページングするデータリスト(array)
	  $page:現在ページ番号(default:1)
	  $limit:1ページあたりの表示数(default:5)
	  return:array(pageData:表示データの配列, page:現在ページ番号, maxPage:最大ページ数)
	*/
	public function listPager($dataList, $page=1, $limit=5)
	{
		if(empty($dataList))
		{
			$result = array(
				'dataList' => array(),
				'page' => $page,
				'maxPage' => 0,
			);
			
			return $result;
		}
		
		$cnt = 0;
		foreach((array)$dataList as $data)
		{
			if( ($limit*($page-1) <= $cnt) && ($cnt < $limit*$page) )
			{
				$pageData[] = $data;
			}
			$cnt++;
		}
		if(!isset($pageData))
		{
			$pageData = array();
		}
		
		$maxPage = ceil((double)$cnt/(double)$limit);
		
		$result = array(
			'dataList' => $pageData,
			'page' => $page,
			'maxPage' => $maxPage,
		);
		Log::debug('result count = '.count($result['dataList']));
		
		return $result;
	}
	
	/*
	  ページャーレイアウト出力
	  $page:現在ページ(int)
	  $maxPage:最大ページ数(int)
	  $link:リンク先(string:[page]をページ番号に置き換え)
	  $linkType:リンク方法(0:URLリンク, 1:onclickスクリプト | default:0)
	  return:string
	*/
	public function getPagerText($page, $maxPage, $link, $linkType=0)
	{
		if($maxPage<1)
		{
			return null;
		}
		
		$limit = 5;
		$limitOffset = floor($limit/2);
		$searchStr = '[page]';
		
		$result = '<div class="pager">';
		if($linkType)//onclickスクリプト
		{
			// prev
			if($page>1)
			{
				$linkStr = str_replace($searchStr, $page-1, $link);
				$result .= '<span class="pageLink" onclick="'.$linkStr.'">';
			}
			$result .= 'prev';
			if($page>1)
			{
				$result .= '</span>';
			}
			$result .= '<span class="pageLink" onclick="pagerSlide(false)">&nbsp;&lt;&lt;</span> ';
			
			// page
			$result .= '<div class="pagerSlider">';
			$result .= '<div class="pagerSlideSet">';
			for($cnt=1; $cnt<=$maxPage; $cnt++)
			{
					$linkStr = str_replace($searchStr, $cnt, $link);
					$result .= '<div class="pagerSlide" onclick="'.$linkStr.'">'.$cnt.'</div> ';
			}
			$result .= '</div>';
			$result .= '</div>';
			
			// next
			$result .= '<span class="pageLink" onclick="pagerSlide(true)">&gt;&gt;</span> ';
			if($page<$maxPage)
			{
				$linkStr = str_replace($searchStr, $page+1, $link);
				$result .= '<span class="pageLink" onclick="'.$linkStr.'">';
			}
			$result .= 'next';
			if($page<$maxPage)
			{
				$result .= '</span>';
			}
		}
		else//URLリンク
		{
			// prev
			if($page>1)
			{
				$linkStr = str_replace($searchStr, $page-1, $link);
				$result .= '<a href="'.$linkStr.'">';
			}
			$result .= 'prev';
			if($page>1)
			{
				$result .= '</a>';
			}
			$result .= '<span class="pageLink" onclick="pagerSlide(false)">&nbsp;&lt;&lt;</span> ';
			
			// page
			$result .= '<div class="pagerSlider">';
			$result .= '<div class="pagerSlideSet">';
			for($cnt=1; $cnt<=$maxPage; $cnt++)
			{
					$linkStr = str_replace($searchStr, $cnt, $link);
					$result .= '<div class="pagerSlide"><a href="'.$linkStr.'">'.$cnt.'</a></div> ';
			}
			$result .= '</div>';
			$result .= '</div>';
			
			// next
			$result .= '<span class="pageLink" onclick="pagerSlide(true)">&gt;&gt;</span> ';
			if($page<$maxPage)
			{
				$linkStr = str_replace($searchStr, $page+1, $link);
				$result .= '<a href="'.$linkStr.'">';
			}
			$result .= 'next';
			if($page<$maxPage)
			{
				$result .= '</a>';
			}
		}
		$result .= '</div>';
		
		$result .= '<div>'.$page.'/'.$maxPage.'</div>';
		
		$result .= '<script type="text/javascript">setupPager('.$page.')</script>';
		
		return $result;
	}
	
	/*
	  データを結合する
	  $dataList:結合元データの二次元連想配列(array(array))
	  $mstDataList:結合マスターデータリスト(array(array("mstData"=>array(array), "key"=>string, "mstKey"=>string, "categoryList"=>array("category", "categoryKey"))))
		mstData:結合マスターデータ二次元連想配列(マスター結合キー以外で結合元データと同じカラム名があるとマスターデータで上書きされるので注意)
		key:結合キー
		mstKey:マスター結合キー
		categoryList:結合カテゴリー条件(特定カテゴリーのみ結合する場合に設定。設定なしの場合はすべてのデータに結合)
		  category:結合カテゴリー
		  categoryKey:結合カテゴリーカラム識別キー
	  return:array(array)
	*/
	public function dataMarge($dataList, $mstDataList)
	{
		$ModelBase = new Model_Base_DbCsv();
		
		return $ModelBase->dataMarge($dataList, $mstDataList);
	}
	
	/*
	  二次元連想配列の配列名を変更する
	  $dataList:変更配列データ
	  $changeKeyList:変更キーデータリスト(array(array("key"=>string, "changeKey"=>string)))
	*/
	public function changeArrayKey($dataList, $changeKeyList)
	{
		$ModelBase = new Model_Base_DbCsv();
		
		return $ModelBase->changeArrayKey($dataList, $changeKeyList);
	}
	
	/*
	  文字列置き換え
	  $replace(array):置き換え文字連想配列(key:置換前 => value:置換後)
	  $subject(string):置き換え文字列
	  $isRegular(bool):正規表現フラグ
	  return:string
	*/
	public function strReplaceAssoc(array $replace, $subject, $isRegular=false)
	{
		if($isRegular)
		{
			$result = preg_replace(array_keys($replace), array_values($replace), $subject);
		}
		else
		{
			$result = str_replace(array_keys($replace), array_values($replace), $subject);
		}
		return $result;
	}
	
	/*
	  文字列->画像置き換え
	  $subject(string):置き換え文字列
	  return:string
	*/
	public function strReplaceImg($subject)
	{
		$result = preg_replace_callback('/\[img:(.+)\]/', function($matches){
			return Asset::img( $matches[1], array('width'=>'100%'));
		}, $subject);
		
		return $result;
	}
}