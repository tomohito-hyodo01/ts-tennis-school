<?php

class COMMON_Mail
{
	/**
	 * 自動返信メールを送信する.
	 *
	 * @param mail_template メールテンプレート名.
	 * @param subject_replacement タイトル置換文字.
	 * @param body_replacement 本文置換文字.
	 */
	static function sendMail(
		$email, 
		$template, 
		$body_replacement, 
		$content
	) {
		// グローバル変数取得
		global $FROM;
		global $SUBJECT;
		global $BODY;
		
		// メールテンプレート読み込み
		require_once($_SERVER['DOCUMENT_ROOT'] . '/mail/' . $template . '.php');
		
		// 文字コード設定
		mb_internal_encoding("UTF-8");
		
		// 本文を置換する
		$body = vsprintf($BODY, $body_replacement);

		// メールを送信し、結果を返却する
		return mb_send_mail($email, $SUBJECT, $body . $content, $FROM);
	}

}