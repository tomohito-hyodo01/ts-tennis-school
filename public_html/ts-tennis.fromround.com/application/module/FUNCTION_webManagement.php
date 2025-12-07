<?php
require_once('COMMON_Utils.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/path.php');

class FUNCTION_webManagement {
	
	/**
	 * 共通エラー画面表示.
	 *
	 * @param message エラーメッセージ.
	 */
	static function displayCommonError(
		$message 
	) {
		// 画面情報取得
		$html = file_get_contents($GLOBALS['_SCR_NG']);
		// エラーメッセージ置換
		$html = COMMON_Utils::replaceTag('<!-- ERROR_MESSAGE -->', $message, $html);
		echo $html;
		exit();
	}
	
	/**
	 * 画面情報取得.
	 *
	 * @param screen_path 画面パス.
	 * @param replace_tag 置換タグ.
	 */
	static function getDisplayScreen(
		$screen_path, 
		$replace_tag = [], 
		$replace_bracket_tag = []
	) {
		// 画面情報取得
		$html = file_get_contents($screen_path);
		
		// 置換タグの数だけ置換を行う
		foreach ($replace_tag as $key => $value ) {
			$html = COMMON_Utils::replaceTag('<!-- ' . $key . ' -->', $value, $html);
		}
		
		// かぎかっこ置換タグの数だけ置換を行う
		foreach ($replace_bracket_tag as $key => $value ) {
			$html = COMMON_Utils::replaceTag('[-- ' . $key . ' --]', $value, $html);
		}
		
		// 画面情報を返す
		echo $html;
		exit();
	}
	
	/**
	 * Hiddenタグ設定.
	 *
	 * @param name タグ名.
	 * @param value 値.
	 */
	static function setHiddenTag(
		$name,
		$value
	) {
		// Hiddenタグ返却
		return "<input type='hidden' id='" . $name . "' name='" . $name . "' value='" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "'>";
	}
	
}
