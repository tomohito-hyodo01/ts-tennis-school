<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/path.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ini/msg.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/COMMON_Utils.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/COMMON_Mail.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/application/module/FUNCTION_webManagement.php');

// 遷移先をお問い合わせ内容確認画面とする
$screen_path = $GLOBALS['_REDIRECT_'];

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

// 置換タグ配列定義
$replace_tag = array();
$replace_bracket_tag = array();

// POSTデータが存在しない場合
if(!isset($_POST)) {

	// エラーメッセージを設定する
	$error_message = "エラーが発生いたしました";
	
} else {

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

	// お申込みコースが選択されていない場合
	if ($course == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_COURSE'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 参加場所が選択されていない場合
	if ($park == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_PARK'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 希望回数が選択されていない場合
	if ($times == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_TIMES'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 名前が入力されていない場合
	if ($name == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_NAME'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// メールアドレスが入力されていない場合
	if ($email == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_EMAIL'] . '<br>';
		
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
		$error_message .= $GLOBALS['_ERROR_']['JOIN_PHONE'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	// 電話番号の形式チェック
	} elseif(!COMMON_Utils::checkPhoneFormat($phone)) {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['PHONE_FORMAT'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 年齢、ブランク年数が入力されていない場合
	if ($age == "" || $blank == "" || $tennis_history == "") {
	
		// 年齢が入力されていない場合、エラーメッセージを設定する
		if($age == "") 	$error_message .= $GLOBALS['_ERROR_']['JOIN_AGE'] . '<br>';
		
		// ブランク年数が入力されていない場合、エラーメッセージを設定する
		if ($blank == "") $error_message .= $GLOBALS['_ERROR_']['JOIN_BLANK'] . '<br>';
		
		// テニス歴が入力されていない場合、エラーメッセージを設定する
		if ($tennis_history == "") $error_message .= $GLOBALS['_ERROR_']['JOIN_TENNIS_HISTORY'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	// 全て入力されている場合
	} else {
	
		// テニス歴が年齢を超えている場合
		if ($age < $tennis_history) {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['JOIN_AGE_VIOLATION1'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		// ブランク年数が年齢を超えている場合
		} elseif($age < $blank) {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['JOIN_AGE_VIOLATION2'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		// テニス歴 + ブランク年数が年齢を超えている場合
		} elseif($age < $tennis_history + $blank) {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['JOIN_AGE_VIOLATION3'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		}
		
	}
	
	// 性別が選択されていない場合
	if ($gender == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_GENDER'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// テニス歴が入力されていない場合
	if ($tennis_history == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_TENNIS_HISTORY'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// ブランク年数が入力されていない場合
	if ($blank == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_BLANK'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 置換タグ設定
	if($error_message != "") $replace_tag['ERROR_MESSAGE'] = $error_message . '<br>';
	$replace_tag['COURSE'] = $course;
	$replace_tag['PARK'] = $park;
	$replace_tag['TIMES'] = $times;
	$replace_tag['TARGET'] = $target;
	$replace_tag['NAME'] = $name;
	$replace_tag['EMAIL'] = $email;
	$replace_tag['PHONE'] = $phone;
	$replace_tag['AGE'] = $age;
	$replace_tag['GENDER'] = $gender;
	$replace_tag['TENNIS_HISTORY'] = $tennis_history;
	$replace_tag['BLANK'] = $blank;
	$replace_tag['CONTENTS'] = $contents;
	$replace_tag['URL'] = 'join_complete.html';
	$replace_bracket_tag['URL'] = 'join_complete.html';
	if($_POST['agree'] != '') $replace_bracket_tag['AGREE'] = 'checked';
	$replace_tag['INPUT_COURSE'] = FUNCTION_webManagement::setHiddenTag('course', $course);
	$replace_tag['INPUT_PARK'] = FUNCTION_webManagement::setHiddenTag('target', $target);
	$replace_tag['INPUT_TIMES'] = FUNCTION_webManagement::setHiddenTag('target', $target);
	$replace_tag['INPUT_TARGET'] = FUNCTION_webManagement::setHiddenTag('target', $target);
	$replace_tag['INPUT_NAME'] = FUNCTION_webManagement::setHiddenTag('name', $name);
	$replace_tag['INPUT_EMAIL'] = FUNCTION_webManagement::setHiddenTag('email', $email);
	$replace_tag['INPUT_PHONE'] = FUNCTION_webManagement::setHiddenTag('phone', $phone);
	$replace_tag['INPUT_AGE'] = FUNCTION_webManagement::setHiddenTag('age', $age);
	$replace_tag['INPUT_GENDER'] = FUNCTION_webManagement::setHiddenTag('gender', $gender);
	$replace_tag['INPUT_TENNIS_HISTORY'] = FUNCTION_webManagement::setHiddenTag('tennis_history', $tennis_history);
	$replace_tag['INPUT_BLANK'] = FUNCTION_webManagement::setHiddenTag('blank', $blank);
	$replace_tag['INPUT_CONTENTS'] = FUNCTION_webManagement::setHiddenTag('contents', $contents);
	
	// エラーフラグが設定されている場合
	if($error_flg == True) {
	
		// お問い合わせページを表示する
		$screen_path = $GLOBALS['_SCR_JOIN_TOP_'];
		
	}
	
	// お客様からのお問い合わせをメール送信
	$result = COMMON_Mail::sendMail('hyodo1011@yahoo.co.jp', 'JOIN_SYSTEM', array($course, $park, $times, $target, $name, $email, $phone, $age, $gender, $tennis_history, $blank, $contents), "");
	
	// お客様に自動メール送信処理
	$result = COMMON_Mail::sendMail($email, 'JOIN_USER', array($name, $course, $park, $times, $contents), "");
	
	// 追加開発:::LINE通知

}

// 確認画面を表示する
FUNCTION_webManagement::getDisplayScreen($screen_path, $replace_tag, $replace_bracket_tag);