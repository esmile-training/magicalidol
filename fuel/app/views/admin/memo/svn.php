<a href=<?= ADMIN_URL ?>>戻る</a>
<h1>SVNコマンド</h1>
<table border=1>
	<tr>
		<td>
			更新（update)<br />
			※最新のヴァージョンにする
		</td>
		<td>
			svn update パス<br />
			※パスを省略した場合、カレントディレクトリ以下全て
		</td>
	</tr>
	<tr>
		<td>
			変更を取り消して更新
		</td>
		<td>
			/home/esmile-sys/www/環境/update.sh<br />
			を用意しました。更新によるコンフリクトを避けられます。<br />
			※変更が取り消されるので注意。webサーバ側の環境で使うとよいかも。
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

<h3>TortoiseSVN設定</h3>
・SSH設定<br />
右クリック＞TortoiseSVN＞設定　ネットワーク＞SSH＞SSHクライアンント<br />
"C:\Program Files\TortoiseSVN\bin\TortoisePlink.exe" -l esmile-sys -pw esmile00<br />
※TortoiseSVNをインストールしたフォルダを指定。<br />
<div>
	<?= Asset::img( 'admin/memo/tortoisesvn00.png'); ?>
</div>
<br />
・チェックアウト<br />
・チェックアウト先のディレクトリは、作成するフォルダを指定。
<div>
	<?= Asset::img( 'admin/memo/tortoisesvn01.png'); ?>
</div>
