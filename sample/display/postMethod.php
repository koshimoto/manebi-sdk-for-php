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
					<th scope="row">アクセストークンID「必須」</th>
					<td><input name="access_token" type="text" value="<?php echo isset($_GET['access_token'])? $_GET['access_token'] : '' ?>" tabindex="11" /></td>
				</tr>
				<tr>
					<th scope="row">ユーザログインID「必須」</th>
					<td><input name="login_id" type="text" value="<?php echo isset($_GET['login_id'])? $_GET['login_id'] : '' ?>" tabindex="11" /></td>
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