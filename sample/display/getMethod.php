<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja-JP" xml:lang="ja-JP">
<head>
	<meta http-equiv="Content-Style-Type" content="text/css; charset=UTF-8" />	
	<link rel="stylesheet" href="style/ma-common.css" charset="UTF-8" />

	<title>[manebi SDK for PHP]-シングルサインオン－モジューAPI呼び出しサンプル</title>
</head>
<body>

<div id="header">
	<h1>シングルサインオン－モジューAPI呼び出しサンプル</h1>
	<a href="index.html">インデックスに戻る</a>
</div>

<div id="main">
	<?php if(isset($result['msg'])) { ?>
	<div class="error-msg">
		<?php echo $result['msg'];?>
	</div>
	<?php } ?>
	<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
		<table>
			<tbody>
				<tr>
					<th scope="row">ログインID(LoginID)</th>
					<td><input name="login_id" type="text" value="<?php echo isset($_GET['login_id'])? $_GET['login_id'] : '' ?>" tabindex="11" /></td>
				</tr>
				<tr>
					<th scope="row">メール(user_email)</th>
					<td><input name="user_email" type="text" value="<?php echo isset($_GET['user_email'])? $_GET['user_email'] : '' ?>" tabindex="11" /></td>
				</tr>
				<tr>
					<th scope="row">ニックネーム(nick_name)</th>
					<td><input name="nick_name" type="text" value="<?php echo isset($_GET['nick_name'])? $_GET['nick_name'] : '' ?>" tabindex="11" /></td>
				</tr>
				<tr>
					<th scope="row">氏(last_name)</th>
					<td><input name="last_name" type="text" value="<?php echo isset($_GET['last_name'])? $_GET['last_name'] : '' ?>" tabindex="11" /></td>
				</tr>
				<tr>
					<th scope="row">名(first_name)</th>
					<td><input name="first_name" type="text" value="<?php echo isset($_GET['first_name'])? $_GET['first_name'] : '' ?>" tabindex="11" /></td>
				</tr>
				<tr>
					<th scope="row">誕生日(birth_day)</th>
					<td><input name="birth_day" type="text" value="<?php echo isset($_GET['birth_day'])? $_GET['birth_day'] : '' ?>" tabindex="11" /></td>
				</tr>
				<tr>
					<th scope="row">ステータス(status)</th>
					<td>
						<select name="status" tabindex="14">
							<option value="男性">有効</option>
							<option value="一時停止">一時停止</option>
							<option value="無効">無効</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">性別(sex_id)</th>
					<td>
						<select name="sex_id" tabindex="14">
							<option value="男性">男性</option>
							<option value="女性">女性</option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		
		<input name="submit" type="submit" value="実行"  tabindex="24" />
	</form>
</div>

<div id="footer">
	<em>Copyright (c) 2013 manebi,Inc. All Rights Reserved.</em>
</div>


</body>
</html>