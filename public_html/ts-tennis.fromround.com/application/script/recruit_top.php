<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/path.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/msg.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/FUNCTION_webManagement.php');

// 遷移先をお問い合わせ内容確認画面とする
$screen_path = $GLOBALS['_SCR_RECRUIT_TOP_'];

// 置換タグ定義
$replace_tag = array();
$replace_bracket_tag = array();

// エラーメッセージ定義
$error_message = '';

// 性別キーハッシュ
$kyh_gender = [
	'男性'=>'INPUT_GENDER1',
	'女性'=>'INPUT_GENDER2',
	'その他'=>'INPUT_GENDER3'
];

// トリム・サニタイズ
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name']), ENT_COMPAT, "UTF-8") : '';
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email']), ENT_COMPAT, "UTF-8") : '';
$phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone']), ENT_COMPAT, "UTF-8") : '';
$age = isset($_POST['age']) ? htmlspecialchars(trim($_POST['age']), ENT_COMPAT, "UTF-8") : '';
$post_num1 = isset($_POST['post_num1']) ? htmlspecialchars(trim($_POST['post_num1']), ENT_COMPAT, "UTF-8") : '';
$post_num2 = isset($_POST['post_num2']) ? htmlspecialchars(trim($_POST['post_num2']), ENT_COMPAT, "UTF-8") : '';
$address = isset($_POST['address']) ? htmlspecialchars(trim($_POST['address']), ENT_COMPAT, "UTF-8") : '';
$gender = isset($_POST['gender']) ? htmlspecialchars(trim($_POST['gender']), ENT_COMPAT, "UTF-8") : '';
$soft_tennis_history = isset($_POST['soft_tennis_history']) ? htmlspecialchars(trim($_POST['soft_tennis_history']), ENT_COMPAT, "UTF-8") : '';
$tennis_history = isset($_POST['tennis_history']) ? htmlspecialchars(trim($_POST['tennis_history']), ENT_COMPAT, "UTF-8") : '';
$soft_tennis_leader_history = isset($_POST['soft_tennis_leader_history']) ? htmlspecialchars(trim($_POST['soft_tennis_leader_history']), ENT_COMPAT, "UTF-8") : '';
$tennis_leader_history = isset($_POST['tennis_leader_history']) ? htmlspecialchars(trim($_POST['tennis_leader_history']), ENT_COMPAT, "UTF-8") : '';
$monday = isset($_POST['monday']) ? htmlspecialchars(trim($_POST['monday']), ENT_COMPAT, "UTF-8") : '';
$tuesday = isset($_POST['tuesday']) ? htmlspecialchars(trim($_POST['tuesday']), ENT_COMPAT, "UTF-8") : '';
$wednesday = isset($_POST['wednesday']) ? htmlspecialchars(trim($_POST['wednesday']), ENT_COMPAT, "UTF-8") : '';
$thursday = isset($_POST['thursday']) ? htmlspecialchars(trim($_POST['thursday']), ENT_COMPAT, "UTF-8") : '';
$friday = isset($_POST['friday']) ? htmlspecialchars(trim($_POST['friday']), ENT_COMPAT, "UTF-8") : '';
$saturday = isset($_POST['saturday']) ? htmlspecialchars(trim($_POST['saturday']), ENT_COMPAT, "UTF-8") : '';
$sunday = isset($_POST['sunday']) ? htmlspecialchars(trim($_POST['sunday']), ENT_COMPAT, "UTF-8") : '';
$t09 = isset($_POST['t09']) ? htmlspecialchars(trim($_POST['t09']), ENT_COMPAT, "UTF-8") : '';
$t11 = isset($_POST['t11']) ? htmlspecialchars(trim($_POST['t11']), ENT_COMPAT, "UTF-8") : '';
$t13 = isset($_POST['t13']) ? htmlspecialchars(trim($_POST['t13']), ENT_COMPAT, "UTF-8") : '';
$t15 = isset($_POST['t15']) ? htmlspecialchars(trim($_POST['t15']), ENT_COMPAT, "UTF-8") : '';
$t17 = isset($_POST['t17']) ? htmlspecialchars(trim($_POST['t17']), ENT_COMPAT, "UTF-8") : '';
$t19 = isset($_POST['t19']) ? htmlspecialchars(trim($_POST['t19']), ENT_COMPAT, "UTF-8") : '';
$commuting_days = isset($_POST['commuting_days']) ? htmlspecialchars(trim($_POST['commuting_days']), ENT_COMPAT, "UTF-8") : '';
$contents = isset($_POST['contents']) ? htmlspecialchars(trim($_POST['contents']), ENT_COMPAT, "UTF-8") : '';

// 置換タグ設定
$replace_tag['NAME'] = '';
$replace_tag['EMAIL'] = '';
$replace_tag['PHONE'] = '';
$replace_tag['AGE'] = '';
$replace_tag['POST_NUM1'] = '';
$replace_tag['POST_NUM2'] = '';
$replace_tag['ADDRESS'] = '';
$replace_tag['GENDER'] = '';
$replace_tag['SOFT_TENNIS_HISTORY'] = '';
$replace_tag['TENNIS_HISTORY'] = '';
$replace_tag['SOFT_TENNIS_LEADER_HISTORY'] = '';
$replace_tag['TENNIS_LEADER_HISTORY'] = '';
$replace_tag['MONDAY'] = '';
$replace_tag['TUESDAY'] = '';
$replace_tag['WEDNESDAY'] = '';
$replace_tag['THURSDAY'] = '';
$replace_tag['FRIDAY'] = '';
$replace_tag['SATURDAY'] = '';
$replace_tag['SUNDAY'] = '';
$replace_tag['T09'] = '';
$replace_tag['T11'] = '';
$replace_tag['T13'] = '';
$replace_tag['T15'] = '';
$replace_tag['T17'] = '';
$replace_tag['T19'] = '';
$replace_tag['COMMUTING_DAYS'] = '';
$replace_tag['AGREE'] = '';
$replace_tag['CONTENTS'] = '';

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

// POSTデータの郵便番号1が入力されている場合
if($post_num1 != ""){

	// 郵便番号1を設定する
	$replace_tag['POST_NUM1'] = $post_num1;
	
}

// POSTデータの郵便番号2が入力されている場合
if($post_num2 != ""){

	// 郵便番号2を設定する
	$replace_tag['POST_NUM2'] = $post_num2;
	
}

// POSTデータの住所が入力されている場合
if($address != ""){

	// 住所を設定する
	$replace_tag['ADDRESS'] = $address;
	
}// POSTデータの性別が入力されている場合
if($gender != ""){

	// 性別を設定する
	$replace_bracket_tag[$kyh_gender[$gender]] = 'selected';
	
}

// POSTデータのソフトテニス歴が入力されている場合
if($tennis_history != ""){

	// ソフトテニス歴を設定する
	$replace_tag['SOFT_TENNIS_HISTORY'] = $soft_tennis_history;
	
}

// POSTデータのテニス歴が入力されている場合
if($tennis_history != ""){

	// テニス歴を設定する
	$replace_tag['TENNIS_HISTORY'] = $tennis_history;
	
}

// POSTデータのソフトテニス指導歴が入力されている場合
if($tennis_history != ""){

	// ソフトテニス指導歴を設定する
	$replace_tag['SOFT_TENNIS_LEADER_HISTORY'] = $soft_tennis_leader_history;
	
}

// POSTデータのテニス指導歴が入力されている場合
if($tennis_history != ""){

	// テニス指導歴を設定する
	$replace_tag['TENNIS_LEADER_HISTORY'] = $tennis_leader_history;
	
}

// POSTデータのレッスン可能曜日(月曜日)が入力されている場合
if($monday != ""){

	// レッスン可能曜日(月曜日)を設定する
	$replace_bracket_tag['MONDAY'] = 'checked';
	
}

// POSTデータのレッスン可能曜日(火曜日)が入力されている場合
if($tuesday != ""){

	// レッスン可能曜日(火曜日)を設定する
	$replace_bracket_tag['TUESDAY'] = 'checked';
	
}

// POSTデータのレッスン可能曜日(水曜日)が入力されている場合
if($wednesday != ""){

	// レッスン可能曜日(水曜日)を設定する
	$replace_bracket_tag['WEDNESDAY'] = 'checked';
	
}

// POSTデータのレッスン可能曜日(木曜日)が入力されている場合
if($thursday != ""){

	// レッスン可能曜日(木曜日)を設定する
	$replace_bracket_tag['THURSDAY'] = 'checked';
	
}

// POSTデータのレッスン可能曜日(金曜日)が入力されている場合
if($friday != ""){

	// レッスン可能曜日(金曜日)を設定する
	$replace_bracket_tag['FRIDAY'] = 'checked';
	
}

// POSTデータのレッスン可能曜日(土曜日)が入力されている場合
if($saturday != ""){

	// レッスン可能曜日(土曜日)を設定する
	$replace_bracket_tag['SATURDAY'] = 'checked';
	
}

// POSTデータのレッスン可能曜日(日曜日)が入力されている場合
if($sunday != ""){

	// レッスン可能曜日(日曜日)を設定する
	$replace_bracket_tag['SUNDAY'] = 'checked';
	
}

// POSTデータのレッスン可能時間(9時～)が入力されている場合
if($t09 != ""){

	// テニス指導歴を設定する
	$replace_bracket_tag['T09'] = 'checked';
	
}

// POSTデータのレッスン可能時間(11時～)が入力されている場合
if($t11 != ""){

	// レッスン可能時間(11時～)を設定する
	$replace_bracket_tag['T11'] = 'checked';
	
}

// POSTデータのレッスン可能時間(13時～)が入力されている場合
if($t13 != ""){

	// レッスン可能時間(13時～)を設定する
	$replace_bracket_tag['T13'] = 'checked';
	
}

// POSTデータのレッスン可能時間(15時～)が入力されている場合
if($t15 != ""){

	// レッスン可能時間(15時～)を設定する
	$replace_bracket_tag['T15'] = 'checked';
	
}

// POSTデータのレッスン可能時間(17時～)が入力されている場合
if($t17 != ""){

	// レッスン可能時間(17時～)を設定する
	$replace_bracket_tag['T17'] = 'checked';
	
}

// POSTデータのレッスン可能時間(19時～)が入力されている場合
if($t19 != ""){

	// レッスン可能時間(19時～)を設定する
	$replace_bracket_tag['T19'] = 'checked';
	
}

// POSTデータの希望レッスン日数が入力されている場合
if($commuting_days != ""){

	// 希望レッスン日数を設定する
	$replace_tag['COMMUTING_DAYS'] = $commuting_days;
	
}

// POSTデータの備考・ご質問が入力されている場合
if($contents != ""){

	// 備考・ご質問を設定する
	$replace_tag['CONTENTS'] = $contents;
	
}

// 確認画面を表示する
FUNCTION_webManagement::getDisplayScreen($screen_path, $replace_tag, $replace_bracket_tag);