<a href=<?= ADMIN_URL ?>>戻る</a>
<style type="text/css">
	th {
		background-color:#00AA00;
	}
</style>

<div style="margin:10px";>
<h1>FuelPHPのディレクトリ構成について</h1>
<h3>URLの解読</h3>
・まず最初に環境直下にある.htaccessファイルが割り込んで./index.phpを読み込む。<br />
・index.phpは、環境変数の定義、必要ファイルの呼び出し、URL解決してコントローラを呼び出す。<br />
例）esmile-sys.sakura.ne.jp/dev/admin/login/index/123?userId=456&errCode=7<br />
⇒ドメイン/環境/コントローラ(階層)/アクション/fuel引数?GET引数<br />

<table border=1>
	<tr>
		<th>
			URL
		</th>
		<th>
			詳細
		</th>
	</tr>
	<tr>
		<td>
			esmile-sys.sakura.ne.jp
		</td>
		<td>
			ドメイン
		</td>
	</tr>
	<tr>
		<td>
			dev
		</td>
		<td>
			環境
		</td>
	</tr>
	<tr>
		<td>
			admin/login
		</td>
		<td>
			コントローラ（www/koba/fuel/app/classes/controller/以下）
		</td>
	</tr>
		<td>
			index
		</td>
		<td>
			アクション（indexだけは引数が無い場合のみ省略が可能）
		</td>
	</tr>
	<tr>
		<td>
			123
		</td>
		<td>
			fuel引数。コントローラのアクションメゾットの引数で受け取る。
		</td>
	</tr>
	<tr>
		<td>
			?userId=456&errCode=7
		</td>
		<td>
			GET引数。fuelはfuel引数があるので普通あまり使わない。<br />
			Input::get('userId') とか、Input::get(' errCode ')<br />
			 として受け取る。存在しない場合、空文字(nullかも)を返す。<br />
			※ちなみにPOSTは、Input::post('userId')で受け取る。<br />
		</td>
	</tr>
</table>


<h3>機能の種類</h3>
・public/assets
<table border=1>
	<tr>
		<th>
			名前
		</th>
		<th>
			備考
		</th>
		<th>
			使い方
		</th>
	</tr>
	<tr>
		<td>
			css
		</td>
		<td>
			スタイルシート置き場。
		</td>
		<td>
			Asset::css(ファイル名);
		</td>
	</tr>
	<tr>
		<td>
			img
		</td>
		<td>
			画像置き場。実態はwww直下にある。
		</td>
		<td>
			Asset::img( ファイル名, オプション);
		</td>
	</tr>
		<tr>
		<td>
			js
		</td>
		<td>
			JavaScript置き場。
		</td>
		<td>
			Asset::js(ファイル名);
		</td>
	</tr>
</table>
<br />
・fuel/app/
<table border=1>
	<tr>
		<th>
			名前
		</th>
		<th>
			備考
		</th>
	</tr>
	<tr>
		<td>
			config
		</td>
		<td>
			コンフィグ置き場。定数による設定は、ここに書いておく。使うときは、<br />
			Config::load('db'); <br />
			$dbType = Config::get(' default . type ');<br />
			ファイルをロードして、キー名でゲット(階層は[.]で区切る)<br />
		</td>
	</tr>
	<tr>
		<td>
			view
		</td>
		<td>
			ビュー置き場。phpファイルだけどhtmlで記述。<br />
			組み込みphp少し特殊な記法が用意されている（別途解説）。<br />
			呼び出し方は、<br />
			View_Wrap::contents('presentBox/top', $this->viewData);<br />
			など（ 表示はfuel/app/class/viewでプログラムされている）。<br />
			$this->viewData['var'] =　値;<br />
			として値を渡すと、変数( $var )がViewで使えるようになる。<br />
		</td>
	</tr>
	<tr>
		<td>
			Log
		</td>
		<td>
			日付ごとにログファイルを作成。SVN管理外。<br />
			Log::info('内容'.’ userId:’.$this->user->id);　とすると、<br />
			INFO - 2014-08-28 00:31:56 --> 内容  userId:1<br />
			が書かれる。必ずユーザIDを入れること。誰のログか分からないので。<br />
			Info以外にも( debug, warning,  error )とか使える。<br />
			今後レベルごとにファイルを分けようかと思ってる。accessログも必要？<br />
		</td>
	</tr>
		<tr>
		<td>
			class
		</td>
		<td>
			下表にて別途説明。<br />
		</td>
	</tr>
</table>
<br />
・fuel/app/class<br />
※このフォルダ以下のファイルのクラス名は「Controller_Test_Kobayashi」とすること。<br />
頭大文字、階層は[ _ ]区切り。お約束。<br />
<table border=1>
	<tr>
		<th>
			名前
		</th>
		<th>
			備考
		</th>
	</tr>
	<tr>
		<td>
			controller
		</td>
		<td>
			URLから指定して読まれるactionメゾットを置くファイル。<br />
			action_ top( $id )　でメゾット宣言。URL で言う/top/1 を意味する。<br />
			特殊なactionが用意されていて、<br />
			・action_ index (URL省略できる。但し引数がある場合は省略不可)<br />
			・before (このコントローラのaction実行の事前に必ず呼ばれる)<br />
			・after (このコントローラのaction実行の事後に必ず呼ばれる)<br />
			<br />
			Lib_Controllerを親にすること。遷移毎に呼ばれる設定が入ってるので。<br />
			例えば、$this->userにはログインユーザの情報を入れてる。<br />
		</td>
	</tr>
	<tr>
		<td>
			lib
		</td>
		<td>
			コントローラ等で使う共通パーツを置く。<br />
			分けた方が見やすいし、共通で使えて便利だから。<br />
			あちこちから呼ばれる親クラスもここに置いてある。使い方は、<br />
			Lib_Page::set(); 　※クラス名::メゾット名( 引数 )<br />
		</td>
	</tr>
	<tr>
		<td>
			model
		</td>
		<td>
			SQLを使うときはここに書く。別に他でも書けるが、見やすくするため。<br />
			親クラスは「Model」(コアにある)で。Fuelがいろいろ使い方を用意している。<br />
			tableごとにファイルを用意すると分かりやすい。<br />
			共通に使えそうなのは[util.php]に書いてみた。使い方は、<br />
			Model_Util::getById( $id ); ※クラス名::メゾット名( 引数 )<br />
			<br />
			Lib_Controllerを親にしてあるファイルは、<br />
			$this->model でModel_Utilが使えるようにしてみました。<br />
			$this->model->wrap('Present', 'getListWithItem', $page );<br />
			⇒$this->model->メゾット(　モデルファイル , メゾット , 引数 )<br />
			とするとログインユーザの情報（$this->user）をモデルファイル内で使る！<br />
		</td>
	</tr>
</table>
