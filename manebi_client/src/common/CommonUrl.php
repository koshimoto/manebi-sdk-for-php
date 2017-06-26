<?php
require_once MAEDU_ROOT_BASE . '/manebi_client/src/common/ParamParser.php';
/**
 * @abstract
 * <b>API 基底クラス</b>
 *
 * @package common
 * @author manebi education
 * @version 1.0
 * @created 2017-06-23
 */
class CommonUrl {

	protected $modm = 'MODM-2017.06.23';
	protected $version = 'MA-1.0';
	protected $exception;
	
	protected $APIs = array(
		'MakeToken' => MAEDU_SAMPLE_MAKE_TOKEN,
		'CheckPermission' => MAEDU_SAMPLE_CHECK_PERMISSION
	);

	/**
	 * コンストラクタ
	 */
	public function __construct() {}

	/**
	 * プロトコルタイプのURLへ接続する。
	 *
	 * @param string $url    プロトコルタイプへのURL文字列
	 * @exception Exception
	 */
	public function connect($url) {
		// URLを解析
		$url_tokens = parse_url($url);

		// プロトコルを取得
        // ※array_key_exists()はPHP4.1.0以降で動作します
		$protocol = array_key_exists('scheme', $url_tokens) ? $url_tokens['scheme'] : null;

		// 未対応のプロトコルのときはエラーとする
		if (false == preg_match('/^[Hh][Tt][Tt][Pp][Ss]?/', $protocol)) {
			$this->exception = new Exception("未対応のプロトコルが指定されました。[$protocol]", 'MSP-001', $this->exception);
			return null;
		}

		// HTTP/HTTPS 接続

		// CURLの初期化
		$urlConnect = curl_init();
		// POSTメソッドに設定
		curl_setopt($urlConnect, CURLOPT_POST, 1);
		// URLを設定
		curl_setopt($urlConnect, CURLOPT_URL, $url);
		// 戻り値の取得方法の設定
		curl_setopt($urlConnect, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($urlConnect, CURLOPT_FOLLOWLOCATION, 1);
		// SSL認証の設定
		//curl_setopt($urlConnect, CURLOPT_SSL_VERIFYHOST, 2);
		// サーバ証明書の検証を行わない
		//curl_setopt($urlConnect, CURLOPT_SSL_VERIFYPEER, false);
		// HTTPで400 以上のコードが返ってきた際に処理失敗とする
		curl_setopt($urlConnect, CURLOPT_FAILONERROR, true);
		curl_setopt($urlConnect, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'); 

		$error = curl_error($urlConnect);
		if ($error) {
			$this->exception = new Exception("プロトコルタイプへの接続に失敗しました。[$error]", 'MSP-002', $this->exception);
			return null;
		}

		return $urlConnect;
	}

	/**
	 * プロトコルタイプのURLへの接続を解除する。
	 *
	 * @param mixed $urlConnect    プロトコルタイプへのURL接続
	 */
	public function disconnect(&$urlConnect) {
		if ($urlConnect) {
			curl_close($urlConnect);
		}
	}

	/**
	 * プロトコルタイプのURLへデータを送信する。
	 *
	 * @param mixed $urlConnect    プロトコルタイプへのURL接続
	 * @param string $params    プロトコルタイプへ送信するパラメータ文字列
	 * @exception Exception
	 */
	public function sendData(&$urlConnect, $params) {
		// HTTP/HTTPS 接続に失敗しているときは戻る
		if (!$urlConnect) {
			return null;
		}

		if (is_null($params)) {
			$this->exception = new Exception("パラメータ文字列がnullです。", 'MSP-003', $this->exception);
			return null;
		}

		// パラメータを送信
		curl_setopt($urlConnect, CURLOPT_POSTFIELDS, $params);
		$retData = curl_exec($urlConnect);
		
		if (false == $retData) {
			$error = curl_error($urlConnect);
			$this->exception = new Exception("プロトコルタイプとのデータの送受信に失敗しました。 : $error", 'MSP-004', $this->exception);
			return "ErrCode=S91&ErrInfo=SSO-91001";
		}
		return $retData;
	}

	/**
	 * プロトコルタイプのURLから戻り値を読み出す。
	 *
	 * @param mixed $retData    プロトコルタイプへのURL接続
	 * @return string 戻り値
	 * @exception Exception
	 */
	public function recvData($retData) {

		// データの送受信に失敗しているときは戻る

		if (!$retData) {
			return null;
		}

		// ※２つめの引数はPHP4.1.0以降で認識します。
		return rtrim($retData, "\r\n");
	}

	/**
	 * プロトコルタイプを呼び出し、結果を返す。
	 *
	 * @param string $url    プロトコルタイプへのURL文字列
	 * @param string $params    プロトコルタイプへ送信するパラメータ文字列
	 * @return IgnoreCaseMap 出力パラメータマップ
	 * @exception Exception
	 */
	public function execProtocol($url, $params) {
		
		// プロトコルタイプのURLへの接続
		$urlConnect = $this->connect($url);

		// データの送信
		$retData = $this->sendData($urlConnect, $params);

		// 戻り値の取り出し
		$retData = $this->recvData($retData);

		// プロトコルタイプのURLへの接続を解除
		$this->disconnect($urlConnect);

		if (!$retData) {
			return null;
		}
		
		// 戻り値を解析
		$parser = new ParamParser();
		return $parser->parse($retData);
	}

	/**
	 * プロトコルタイプを呼び出し、結果を返す。
	 * 呼び出し先のURLはクラス名をもとに取得する。
	 *
	 * @param string $params    プロトコルタイプへ送信するパラメータ文字列
	 * @param string $key	APIキー名
	 * @return IgnoreCaseMap 出力パラメータマップ
	 * @exception Exception
	 */
	public function callProtocol($params, $key) {
		// URLを取得
		$url = $this->getApiUrl($key);
		
		// URLを取得できなかったときはエラーとする
		if (is_null($url)) {
			$this->exception = new Exception("呼び出し先のURLを取得できませんでした。[$key]", 'MSP-005', $this->exception);
			return null;
		}

		//更新者として、製品バージョンを設定
		return $this->execProtocol($url, http_build_query($params) . '&Modm=' . $this->modm. '&Version=' . $this->version );
	}

	/**
	 * 例外の発生を判定する
	 *
	 * @return boolean 判定結果(true = 例外発生)
	 */
	public function isExceptionOccured() {
		return false == is_null($this->exception);
	}

	/**
	 * 例外を返す
	 *
	 * @return  Exception 例外
	 */
	public function &getException() {
		return $this->exception;
	}
	
	public function getApiUrl($key){
		return isset($this->APIs[$key])?$this->APIs[$key]:null;
	}
	
	public function redirect($params, $key) {
		if (!is_array($params))
			$param = array('param' => $params);
		
		$apiUrl = $this->getApiUrl($key);
		$httpQuery = http_build_query($params);
		$redirectUrl = $apiUrl.'?'.$httpQuery;
		header("Location: {$redirectUrl}");
		exit;
	}
}
?>