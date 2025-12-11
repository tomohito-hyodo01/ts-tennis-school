<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/path.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/msg.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/COMMON_Utils.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/COMMON_Mail.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/FUNCTION_webManagement.php');

// 遷移先をリダイレクト画面とする
$screen_path = $GLOBALS['_REDIRECT_'];

// エラーメッセージ定義
$error_message = '';

// エラーフラグ
$error_flg = False;

// 体験希望日キーハッシュ
$kyh_date = [
	'2025/12/23'=>'INPUT_DATE1',
	'2026/01/05'=>'INPUT_DATE2'
];

// 性別キーハッシュ
$kyh_gender = [
	'男性'=>'INPUT_GENDER1',
	'女性'=>'INPUT_GENDER2',
	'その他'=>'INPUT_GENDER3'
];

// 置換タグ配列定義
$replace_tag = array();
$replace_bracket_tag = array();

// POSTデータが存在しない場合
if(!isset($_POST)) {

	// エラーメッセージを設定する
	$error_message = "エラーが発生いたしました";

} else {

	// トリム・サニタイズ
	$trial_date = htmlspecialchars(trim($_POST['trial_date']), ENT_COMPAT, "UTF-8");
	$name = htmlspecialchars(trim($_POST['name']), ENT_COMPAT, "UTF-8");
	$email = htmlspecialchars(trim($_POST['email']), ENT_COMPAT, "UTF-8");
	$phone = htmlspecialchars(trim($_POST['phone']), ENT_COMPAT, "UTF-8");
	$age = htmlspecialchars(trim($_POST['age']), ENT_COMPAT, "UTF-8");
	$gender = htmlspecialchars(trim($_POST['gender']), ENT_COMPAT, "UTF-8");
	$contents = htmlspecialchars(trim($_POST['contents']), ENT_COMPAT, "UTF-8");

	// 体験希望日が選択されていない場合
	if ($trial_date == "") {

		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['TRIAL_DATE'] . '<br>';

		// エラーフラグをTrueに設定する
		$error_flg = True;

	}

	// 名前が入力されていない場合
	if ($name == "") {

		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['TRIAL_NAME'] . '<br>';

		// エラーフラグをTrueに設定する
		$error_flg = True;

	}

	// メールアドレスが入力されていない場合
	if ($email == "") {

		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['TRIAL_EMAIL'] . '<br>';

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
		$error_message .= $GLOBALS['_ERROR_']['TRIAL_PHONE'] . '<br>';

		// エラーフラグをTrueに設定する
		$error_flg = True;

	// 電話番号の形式チェック
	} elseif(!COMMON_Utils::checkPhoneFormat($phone)) {

		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['PHONE_FORMAT'] . '<br>';

		// エラーフラグをTrueに設定する
		$error_flg = True;

	}

	// 年齢が入力されていない場合
	if ($age == "") {

		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['TRIAL_AGE'] . '<br>';

		// エラーフラグをTrueに設定する
		$error_flg = True;

	}

	// 性別が選択されていない場合
	if ($gender == "") {

		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['TRIAL_GENDER'] . '<br>';

		// エラーフラグをTrueに設定する
		$error_flg = True;

	}

	// 置換タグ設定
	if($error_message != "") $replace_tag['ERROR_MESSAGE'] = $error_message . '<br>';
	$replace_tag['TRIAL_DATE'] = $trial_date;
	$replace_tag['NAME'] = $name;
	$replace_tag['EMAIL'] = $email;
	$replace_tag['PHONE'] = $phone;
	$replace_tag['AGE'] = $age;
	$replace_tag['GENDER'] = $gender;
	$replace_tag['CONTENTS'] = $contents;
	$replace_tag['URL'] = 'trial_complete.html';
	$replace_bracket_tag['URL'] = 'trial_complete.html';
	if(isset($_POST['agree']) && $_POST['agree'] != '') $replace_bracket_tag['AGREE'] = 'checked';
	$replace_tag['INPUT_TRIAL_DATE'] = FUNCTION_webManagement::setHiddenTag('trial_date', $trial_date);
	$replace_tag['INPUT_NAME'] = FUNCTION_webManagement::setHiddenTag('name', $name);
	$replace_tag['INPUT_EMAIL'] = FUNCTION_webManagement::setHiddenTag('email', $email);
	$replace_tag['INPUT_PHONE'] = FUNCTION_webManagement::setHiddenTag('phone', $phone);
	$replace_tag['INPUT_AGE'] = FUNCTION_webManagement::setHiddenTag('age', $age);
	$replace_tag['INPUT_GENDER'] = FUNCTION_webManagement::setHiddenTag('gender', $gender);
	$replace_tag['INPUT_CONTENTS'] = FUNCTION_webManagement::setHiddenTag('contents', $contents);

	// エラーフラグが設定されている場合
	if($error_flg == True) {

		// 体験申込ページを表示する
		$screen_path = $GLOBALS['_SCR_TRIAL_TOP_'];

	}

	// 管理者への体験申込通知をメール送信
	$result = COMMON_Mail::sendMail('hyodo1011@yahoo.co.jp', 'TRIAL_SYSTEM', array($trial_date, $name, $email, $phone, $age, $gender, $contents), "");

	// お客様に自動メール送信処理
	$result = COMMON_Mail::sendMail($email, 'TRIAL_USER', array($name, $trial_date, $contents), "");

}

// 確認画面を表示する
FUNCTION_webManagement::getDisplayScreen($screen_path, $replace_tag, $replace_bracket_tag);
