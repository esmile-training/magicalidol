<a href=<?= ADMIN_URL ?>>戻る</a>
<h1 id='env'>Weｂサーバ</h1>
<table border=1>
	<tr>
		<td>
			現在のIPアドレス
		</td>
		<td>
			<?php
				$hostName = 'esmile-sys.sakura.ne.jp';
				$ipAdress = gethostbyname($hostName);
			?>
			<?php echo $ipAdress;?>
		</td>
	</tr>
	<tr>
		<td>
			URL
		</td>
		<td>
			http://esmile-sys.sakura.ne.jp/dev/public/admin/login<br />
			※[dev]の部分は表示したい環境によって変更。
		</td>
	</tr>
	<tr>
		<td>
			FTPサーバ名
		</td>
		<td>
			esmile-sys.sakura.ne.jp
		</td>
	</tr>
	<tr>
		<td>
			FTPアカウント
		</td>
		<td>
			esmile-sys
		</td>
	</tr>
	<tr>
		<td>
			サーバパスワード
		</td>
		<td>
			esmile00
		</td>
	</tr>
	<tr>
		<td>
			TCPポート番号
		</td>
		<td>
			22（SSH)
		</td>
	</tr>
	<tr>
		<td>
			ファイルプロトコル
		</td>
		<td>
			SFTP
		</td>
	</tr>
	<tr>
		<td>
			SSHヴァージョン
		</td>
		<td>
			SSH2
		</td>
	</tr>
</table>

<h1>データベース</h1>
<table border=1>
	<tr>
		<td>
			phpMyAdomin
		</td>
		<td>
			https://secure.sakura.ad.jp/phpmyadmin2/?server=mysql300.db.sakura.ne.jp
		</td>
	</tr>
	<tr>
		<td>
			ユーザ名
		</td>
		<td>
			esmile-sys
		</td>
	</tr>
	<tr>
		<td>
			接続パスワード
		</td>
		<td>
			esmile00
		</td>
	</tr>
	<tr>
		<td>
			データベース サーバ
		</td>
		<td>
			mysql300.db.sakura.ne.jp
		</td>
	</tr>
	<tr>
		<td>
			データベース名
		</td>
		<td>
			esmile-sys_db
		</td>
	</tr>
</table>


<h1>社内共有サーバ</h1>
<table border=1>
	<tr>
		<td>
			PHP研修
		</td>
		<td>
			\\192.168.62.41\social\インフラ教育用\101_sys用研修\PHP研修
		</td>
	</tr>
</table>

<h1>環境構成図</h1>
<div style="margin:20px">
	<?= Asset::img( 'admin/memo/kankyou.png'); ?>
</div>
