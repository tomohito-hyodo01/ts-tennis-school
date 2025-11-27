<?php

class COMMON_Utils {
	/**
	* タグ置換
	* @param tag タグ
	* @param word 置換後文字列
	* @param text 置換対象文字列
	*/
	static function replaceTag(
		$tag, 
		$word, 
		$text 
	) {
		// タグ置換を実行し、返す
		return str_replace($tag, $word, $text);
	}
	
	/**
	* メールアドレス形式チェック
	* @email メールアドレス
	*/
	static function checkEmailFormat(
		$email 
	) {
		// メールアドレス形式チェック
		return preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/', $email);
		
	}
	
	/**
	* メールアドレスドメインチェック
	* @email メールアドレス
	*/
	static function checkEmailDomain(
		$email 
	) {
	
		// メールアドレスドメインチェック
		return checkdnsrr(substr($email, strpos($email, "@") + 1), "MX");
		
	}
	
	/**
	* 電話番号形式チェック
	* @email メールアドレス
	*/
	static function checkPhoneFormat(
		$phone 
	) {
		// メールアドレス形式チェック
		return preg_match("/^[0-9]+$/",$phone);
		
	}
}
