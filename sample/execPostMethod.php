<?php
require_once( './config.php');

if( isset( $_POST['submit'] ) ){
	require_once( MAEDU_ROOT_BASE . '/manebi_client/src/transaction/ExecTran.php');
	
	//入力パラメータクラスをインスタンス化します
	$execTran = new ExecTran();
	$result = $execTran->makeToken($_POST['login_id']);
	
	$token = isset($result['access_token'])?$result['access_token']:null;
	if (!empty($token)) {
		return $execTran->checkPermission(array(
				'login_id' => $_POST['login_id'],
				'access_token' => $token,
		));
	}
	
}

//EntryTran入力・結果画面
require_once( MAEDU_SAMPLE_BASE . '/display/postMethod.php' );