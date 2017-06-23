<a href=<?= ADMIN_URL ?>>戻る</a>
<h1>関数一覧</h1>
<table border=1>
	<tr>
		<td>
			関数
		</td>
		<td>
			サンプル
		</td>
	</tr>
	<tr>
		<td>
			Viewごとに表示形式を変更
		</td>
		<td>
			View_Wrap::admin('ディレクトリ名', '値');
		</td>
	</tr>
	<tr>
		<td>
			ライブラリを実行
		</td>
		<td>
			$this->lib->exec('ライブラリ名', '関数名', '値')
		</td>
	</tr>
		<td>
			モデル(インサート)
		</td>
		<td>
			Model_User::forge('値')->save();
		</td>
	</tr>
	<tr>
		<td>
			モデル(セレクト)
		</td>
		<td>
			 Model_User::find('all');
		</td>
	</tr>
	<tr>
		<td>
			モデル(アップデート)
		</td>
		<td>
			$update = Model_User::find(6);<br>
			$update->set(array('name' => 'aser'));<br>
			$update->save();<br>
			※find(指定id)
		</td>
	</tr>
	<tr>
		<td>
			モデル(デリート)
		</td>
		<td>
			$delete = Model_User::find(5);<br>
			$delete->delete();<br>
			※find(指定id)
		</td>
	</tr>
	<tr>
		<td>
			モデル(リレーション)
		</td>
		<td>
			userとushopのモデルを見ればわかりますが、二つのモデルは
			連結しています。下記のような呼び出しをすれば一致する項
			目を取得します。
			
			$results = Model_User::find(2);<br>
			$results->uShop->productName;
		</td>
	</tr>
	<tr>
		<td>
			イメージリンク(暗号化)
		</td>
		<td>
			$this->imgUrl('ディレクトリ名','関数名','画像','値');<br>
			※Urlのgetを暗号化しています。上記の宣言を行う場合は<br>
			　受け取り側の関数で下の関数を呼び出してください。
		</td>
	</tr>
	<tr>
		<td>
			イメージリンク(複合化)
		</td>
		<td>
			$this->urlMerge('受け取った変数');
		</td>
	</tr>
	<tr>
		<td>
			CSV取得
		</td>
		<td>
			$this->Lib->getAll('/ディレクトリ/ファイル名');
		</td>
	</tr>
	<tr>
		<td>
			モデルの情報にCSVを付与
		</td>
		<td>
			$this->Lib->combining('モデルデータ', 'CSVデータ', 'keyとなる文字列');<br>
			
			※第三引数はデータベースのカラム名に依存(例：　weaponId<-weaponの部分)。<br>
			　実際に配列に付与するときにも使用され、配列のkeyとなる。
		</td>
	</tr>
</table>
<br>
大まかな内容は以上です。オリジナル関数でわからないことがあれば水頭まで。

