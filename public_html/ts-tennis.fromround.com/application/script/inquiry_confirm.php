<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/path.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/msg.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/COMMON_Utils.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/FUNCTION_webManagement.php');

// 遷移先をリダイレクト画面とする
$screen_path = $GLOBALS['_SCR_INQUIRY_CONFIRM_'];

// エラーフラグ
$error_flg = False;

// エラーメッセージ定義
$error_message = '';

// 置換タグ配列定義
$replace_tag = array();
$replace_bracket_tag = array();

if(!isset($_POST)) {

	// エラーメッセージを設定する
	$error_message = "エラーが発生いたしました";
	
} else {

	// トリム・サニタイズ
	$name = htmlspecialchars(trim($_POST['name']), ENT_COMPAT, "UTF-8");
	$email = htmlspecialchars(trim($_POST['email']), ENT_COMPAT, "UTF-8");
	$phone = htmlspecialchars(trim($_POST['phone']), ENT_COMPAT, "UTF-8");
	$contents = htmlspecialchars(trim(str_replace(array("\r", "\n"), '', $_POST['contents'])), ENT_COMPAT, "UTF-8");
	
	// 名前が入力されていない場合
	if ($name == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['INQUIRY_NAME'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// メールアドレスが入力されていない場合
	if ($email == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['INQUIRY_EMAIL'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	} else {
	
		// メールアドレス形式チェック
		if(!COMMON_Utils::checkEmailFormat($email)) {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['EMAIL_FORMAT'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		// メールアドレスドメインチェック
		} elseif(!COMMON_Utils::checkEmailDomain($email)) {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['EMAIL_DOMAIN'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
		
		}
		
	}
	
	// 電話番号が入力されていない場合
	if ($phone == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['INQUIRY_PHONE'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	// 電話番号の形式チェック
	} elseif(!COMMON_Utils::checkPhoneFormat($phone)) {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['PHONE_FORMAT'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// お問い合わせ内容が入力されていない場合
	if ($contents == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['INQUIRY_CONTENTS'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 個人情報保護法同意にチェックされていない場合
	if ($_POST['agree'] == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['INQUIRY_AGREE'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 置換タグ設定
	if($error_message != "") $replace_tag['ERROR_MESSAGE'] = $error_message . '<br>';
	$replace_tag['NAME'] = $name;
	$replace_tag['EMAIL'] = $email;
	$replace_tag['PHONE'] = $phone;
	$replace_tag['CONTENTS'] = $contents;
	if($_POST['agree'] != '') $replace_bracket_tag['AGREE'] = 'checked';
	$replace_tag['INPUT_NAME'] = FUNCTION_webManagement::setHiddenTag('name', $name);
	$replace_tag['INPUT_EMAIL'] = FUNCTION_webManagement::setHiddenTag('email', $email);
	$replace_tag['INPUT_PHONE'] = FUNCTION_webManagement::setHiddenTag('phone', $phone);
	$replace_tag['INPUT_CONTENTS'] = FUNCTION_webManagement::setHiddenTag('contents', $contents);
	
	// エラーフラグが設定されている場合
	if($error_flg == True) {
	
		// お問い合わせページを表示する
		$screen_path = $GLOBALS['_SCR_INQUIRY_TOP_'];
		
	}
	
}

// 確認画面を表示する
FUNCTION_webManagement::getDisplayScreen($screen_path, $replace_tag, $replace_bracket_tag);