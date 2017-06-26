<?php
require_once MAEDU_ROOT_BASE . '/manebi_client/src/common/CommonUrl.php';
/**
 * <b>SSO実行　実行クラス</b>
 *
 * @package transaction
 * @author manebi education
 * @version 1.0
 * @created 2017-06-23
 */
class ExecTran{
	protected $clients = array(
		'client_id' => MAEDU_SAMPLE_CLIENT_ID,
		'client_secret' => MAEDU_SAMPLE_CLIENT_SECRET
	);
	
	public function makeToken($loginId){
		$params = array_merge($this->clients,array('login_id' => $loginId));
		
		$commonsUrl = new CommonUrl(); 
		$result = $commonsUrl->callProtocol($params, ucfirst(__FUNCTION__));
		
		return !empty($result)?$result:null;
	}
	
	public function checkPermission($params){
		$commonsUrl = new CommonUrl();
		return $commonsUrl->redirect($params, ucfirst(__FUNCTION__));
	}
}
?>