<?php
/**
 * <b>API返却パラメータ文字列パーサ</b>
 *
 * manebiのSSOサーバーから返却された文字列をパースするためのクラス
 *
 * @package common
 * @author manebi education
 * @version 1.0
 * @created 2017-06-23
 */
class ParamParser {

	/**
	 * パラメータ文字列解析
	 *
	 * @param  string $params    パラメータ文字列
	 * @return array paramsMap パラメータ文字列の連想配列
	 */
	public function parse($params) {
	    // nullの場合は処理を行わない
		if (empty($params)) {
	        return null;
	    }
	    
	    $params= json_decode($params);
	    if (empty($params) || empty($params->data)) {
	    	return null;
	    }

	    // パラメータ文字列の分割
	    return (array)$params->data;
	}
}
?>