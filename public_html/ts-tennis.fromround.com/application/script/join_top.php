<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/path.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/msg.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/FUNCTION_webManagement.php');

// 遷移先をお問い合わせ内容確認画面とする
$screen_path = $GLOBALS['_SCR_JOIN_TOP_'];

// 置換タグ定義
$replace_bracket_tag = array();

// エラーメッセージ定義
$error_message = '';

// お申込みコースキーハッシュ
$kyh_course = [
	'初級者コース'=>'INPUT_COURSE1',
	'中学生・高校生 中級者コース'=>'INPUT_COURSE2',
	'中学生・高校生 上級者コース'=>'INPUT_COURSE3',
	'中学生・高校生 ゲームコース'=>'INPUT_COURSE4',
	'社会人 ブランク解消コース'=>'INPUT_COURSE5'
];

// 公園キーハッシュ
$kyh_park = [
	'舎人公園'=>'INPUT_PARK1',
	'猿江恩賜公園'=>'INPUT_PARK2',
	'そうか公園'=>'INPUT_PARK3',
];

// 性別キーハッシュ
$kyh_gender = [
	'男性'=>'INPUT_GENDER1',
	'女性'=>'INPUT_GENDER2',
	'その他'=>'INPUT_GENDER3'
];

// トリム・サニタイズ
$course = htmlspecialchars(trim($_POST['course']), ENT_COMPAT, "UTF-8");
$park = htmlspecialchars(trim($_POST['park']), ENT_COMPAT, "UTF-8");
$times = htmlspecialchars(trim($_POST['times']), ENT_COMPAT, "UTF-8");
$target = htmlspecialchars(trim($_POST['target']), ENT_COMPAT, "UTF-8");
$name = htmlspecialchars(trim($_POST['name']), ENT_COMPAT, "UTF-8");
$email = htmlspecialchars(trim($_POST['email']), ENT_COMPAT, "UTF-8");
$phone = htmlspecialchars(trim($_POST['phone']), ENT_COMPAT, "UTF-8");
$age = htmlspecialchars(trim($_POST['age']), ENT_COMPAT, "UTF-8");
$gender = htmlspecialchars(trim($_POST['gender']), ENT_COMPAT, "UTF-8");
$tennis_history = htmlspecialchars(trim($_POST['tennis_history']), ENT_COMPAT, "UTF-8");
$blank = htmlspecialchars(trim($_POST['blank']), ENT_COMPAT, "UTF-8");
$contents = htmlspecialchars(trim($_POST['contents']), ENT_COMPAT, "UTF-8");

// 置換タグ設定
$replace_tag['TIMES'] = 4;
$replace_tag['TARGET'] = '';
$replace_tag['NAME'] = '';
$replace_tag['EMAIL'] = '';
$replace_tag['PHONE'] = '';
$replace_tag['AGE'] = '';
$replace_tag['GENDER'] = '';
$replace_tag['TENNIS_HISTORY'] = '';
$replace_tag['BLANK'] = '';
$replace_tag['CONTENTS'] = '';
$replace_tag['AGREE'] = '';

// POSTデータのコースが入力されている場合
if($course != ""){

	// コースを設定する
	$replace_bracket_tag[$kyh_course[$course]] = 'selected';
	
}

// POSTデータの参加場所が入力されている場合
if($park != ""){

	// 参加場所を設定する
	$replace_bracket_tag[$kyh_park[$park]] = 'selected';
	
}

// POSTデータの希望回数が入力されている場合
if($times != ""){

	// 希望回数を設定する
	$replace_tag['TIMES'] = $times;
	
}

// POSTデータの目指すレベルが入力されている場合
if($target != ""){

	// 目指すレベルを設定する
	$replace_tag['TARGET'] = $target;
	
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

// POSTデータのテニス歴が入力されている場合
if($tennis_history != ""){

	// テニス歴を設定する
	$replace_tag['TENNIS_HISTORY'] = $tennis_history;
	
}

// POSTデータのブランク年数が入力されている場合
if($blank != ""){

	// ブランク年数を設定する
	$replace_tag['BLANK'] = $blank;
	
}

// POSTデータのお問い合わせ内容が入力されている場合
if($contents != ""){

	// お問い合わせ内容を設定する
	$replace_tag['CONTENTS'] = $contents;
	
}

// 確認画面を表示する
FUNCTION_webManagement::getDisplayScreen($screen_path, $replace_tag, $replace_bracket_tag);