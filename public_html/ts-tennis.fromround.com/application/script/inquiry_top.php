<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/path.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/msg.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/FUNCTION_webManagement.php');

// 遷移先をお問い合わせ内容確認画面とする
$screen_path = $GLOBALS['_SCR_INQUIRY_TOP_'];

// エラーメッセージ定義
$error_message = '';

// トリム・サニタイズ
$name = htmlspecialchars(trim($_POST['name']), ENT_COMPAT, "UTF-8");
$email = htmlspecialchars(trim($_POST['email']), ENT_COMPAT, "UTF-8");
$phone = htmlspecialchars(trim($_POST['phone']), ENT_COMPAT, "UTF-8");
# $contents = htmlspecialchars(trim($_POST['contents']), ENT_COMPAT, "UTF-8");
$contents = $_POST['contents'];

// 置換タグ設定
$replace_tag['NAME'] = '';
$replace_tag['EMAIL'] = '';
$replace_tag['PHONE'] = '';
$replace_tag['CONTENTS'] = '';
$replace_tag['AGREE'] = '';

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

// POSTデータのお問い合わせ内容が入力されている場合
if($contents != ""){

	// お問い合わせ内容を設定する
	$replace_tag['CONTENTS'] = $contents;
}

// 確認画面を表示する
FUNCTION_webManagement::getDisplayScreen($screen_path, $replace_tag);