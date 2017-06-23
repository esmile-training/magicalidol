<a href=<?= ADMIN_URL ?>>戻る</a>
<h1>gitコマンド</h1>
<table border=1>
	<tr>
		<td>
			クローン
		</td>
		<td>
			git clone https://github.com/esmile-training/magicalidol.git
		</td>
	</tr>
	<tr>
		<td>
			追加
		</td>
		<td>
			git commit --all
		</td>
	</tr>
	<tr>
		<td>
			コミット
		</td>
		<td>
			svn commit パス -m 'ｺﾒﾝﾄ'<br />
			※パスに[ . ]を指定すればカレントディレクトリ以下全て<br />
			※コミットする前には必ずstatusやdiffコマンドで内容を確認すること！
		</td>
	</tr>
		<td>
			追加
		</td>
		<td>
			svn add パス<br />
			※未参加ディレクトリを指定した場合、以下のファイルも再帰的に追加される。
		</td>
	</tr>
	<tr>
		<td>
			追加（一括）
		</td>
		<td>
			svn add * --force<br />
			カレントディレクトリ以下のフォルダを全て走査して追加。
		</td>
	</tr>
	<tr>
		<td>
			削除
		</td>
		<td>
			svn delete パス<br />
			※単に削除しても、バージョンからは消えないのでコマンドで。<br />
			※間違えて削除した場合、変更をコミットしないこと。<br />
		</td>
	</tr>
	<tr>
		<td>
			変更を元に戻す
		</td>
		<td>
			svn revert　パス<br />
			※ディレクトリ以下全て戻すには、svn revert . -R
		</td>
	</tr>
	<tr>
		<td>
			チェックｱｳﾄ<br />
			※新規にリビジョン作成
		</td>
		<td>
			svn checkout svn+ssh://esmile-sys.sakura.ne.jp/home/esmile-sys/svn/repos ディレクトリ名<br />
			※ディレクトリ名はURLの環境（[dev]など)の部分になる
		</td>
	</tr>
</table>
あとは各自で調べてください。いろいろあります。

<h1>ローカルリポジトリ環境</h1>
・IDEのエディタや、SVNをGUIで利用したい場合、ローカルにリポジトリを作成。<br />
・ただし、ブラウザで動作させるためには、DBの設定とDBを最新に保つ必要があるので、かなり面倒くさい。<br />
→ローカルリポジトリでソースを作成して、サーバリポジトリにコピーして動作確認するのが推奨。<br />


