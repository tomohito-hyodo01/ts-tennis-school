<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/path.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/msg.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/FUNCTION_webManagement.php');

// 遷移先を体験申込トップ画面とする
$screen_path = $GLOBALS['_SCR_TRIAL_TOP_'];

// 置換タグ定義
$replace_bracket_tag = array();

// エラーメッセージ定義
$error_message = '';

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

// トリム・サニタイズ
$trial_date = isset($_POST['trial_date']) ? htmlspecialchars(trim($_POST['trial_date']), ENT_COMPAT, "UTF-8") : '';
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name']), ENT_COMPAT, "UTF-8") : '';
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email']), ENT_COMPAT, "UTF-8") : '';
$phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone']), ENT_COMPAT, "UTF-8") : '';
$age = isset($_POST['age']) ? htmlspecialchars(trim($_POST['age']), ENT_COMPAT, "UTF-8") : '';
$gender = isset($_POST['gender']) ? htmlspecialchars(trim($_POST['gender']), ENT_COMPAT, "UTF-8") : '';
$contents = isset($_POST['contents']) ? htmlspecialchars(trim($_POST['contents']), ENT_COMPAT, "UTF-8") : '';

// 置換タグ設定
$replace_tag['NAME'] = '';
$replace_tag['EMAIL'] = '';
$replace_tag['PHONE'] = '';
$replace_tag['AGE'] = '';
$replace_tag['GENDER'] = '';
$replace_tag['CONTENTS'] = '';
$replace_tag['AGREE'] = '';

// POSTデータの体験希望日が入力されている場合
if($trial_date != ""){

	// 体験希望日を設定する
	$replace_bracket_tag[$kyh_date[$trial_date]] = 'selected';

}

// POSTデータの名前が入力されている場合
if($name != ""){

	// 名前を設定する
	$replace_tag['NAME'] = $name;

}

// POSTデータのメールアドレスが入力されている場合
if($email != ""){

	// メールアドレスを設定する
	$replace_tag['EMAIL'] = $email;

}

// POSTデータの電話番号が入力されている場合
if($phone != ""){

	// 電話番号を設定する
	$replace_tag['PHONE'] = $phone;

}

// POSTデータの年齢が入力されている場合
if($age != ""){

	// 年齢を設定する
	$replace_tag['AGE'] = $age;

}

// POSTデータの性別が入力されている場合
if($gender != ""){

	// 性別を設定する
	$replace_bracket_tag[$kyh_gender[$gender]] = 'selected';

}

// POSTデータのお問い合わせ内容が入力されている場合
if($contents != ""){

	// お問い合わせ内容を設定する
	$replace_tag['CONTENTS'] = $contents;

}

// 画面を表示する
FUNCTION_webManagement::getDisplayScreen($screen_path, $replace_tag, $replace_bracket_tag);
