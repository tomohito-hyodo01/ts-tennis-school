<?php 
require_once('/home/fromround/fromround.com/public_html/ts-tennis.fromround.com/ini/path.php');
require_once('/home/fromround/fromround.com/public_html/ts-tennis.fromround.com/ini/msg.php');
require_once('/home/fromround/fromround.com/public_html/ts-tennis.fromround.com/application/module/COMMON_Utils.php');
require_once('/home/fromround/fromround.com/public_html/ts-tennis.fromround.com/application/module/FUNCTION_webManagement.php');

// 遷移先をリダイレクト画面とする
$screen_path = $GLOBALS['_SCR_JOIN_CONFIRM_'];

// エラーフラグ
$error_flg = False;

// エラーメッセージ定義
$error_message = '';

// 性別キーハッシュ
$kyh_gender = [
	'男性'=>'INPUT_GENDER1',
	'女性'=>'INPUT_GENDER2',
	'その他'=>'INPUT_GENDER3'
];



// 置換タグ配列定義
$replace_tag = array();
$replace_bracket_tag = array();

// POSTデータチェック
if(!isset($_POST)) {

	// エラーメッセージを設定する
	$error_message = "エラーが発生いたしました";
	
// 存在する場合
} else {

	// トリム・サニタイズ
	$name = htmlspecialchars(trim($_POST['name']), ENT_COMPAT, "UTF-8");
	$email = htmlspecialchars(trim($_POST['email']), ENT_COMPAT, "UTF-8");
	$phone = htmlspecialchars(trim($_POST['phone']), ENT_COMPAT, "UTF-8");
	$post_num1 = htmlspecialchars(trim($_POST['post_num1']), ENT_COMPAT, "UTF-8");
	$post_num2 = htmlspecialchars(trim($_POST['post_num2']), ENT_COMPAT, "UTF-8");
	$address = htmlspecialchars(trim($_POST['address']), ENT_COMPAT, "UTF-8");
	$gender = htmlspecialchars(trim($_POST['gender']), ENT_COMPAT, "UTF-8");
	$soft_tennis_history = htmlspecialchars(trim($_POST['soft_tennis_history']), ENT_COMPAT, "UTF-8");
	$tennis_history = htmlspecialchars(trim($_POST['tennis_history']), ENT_COMPAT, "UTF-8");
	$soft_tennis_leader_history = htmlspecialchars(trim($_POST['soft_tennis_leader_history']), ENT_COMPAT, "UTF-8");
	$tennis_leader_history = htmlspecialchars(trim($_POST['tennis_leader_history']), ENT_COMPAT, "UTF-8");
	$monday = htmlspecialchars(trim($_POST['monday']), ENT_COMPAT, "UTF-8");
	$tuesday = htmlspecialchars(trim($_POST['tuesday']), ENT_COMPAT, "UTF-8");
	$wednesday = htmlspecialchars(trim($_POST['wednesday']), ENT_COMPAT, "UTF-8");
	$thursday = htmlspecialchars(trim($_POST['thursday']), ENT_COMPAT, "UTF-8");
	$friday = htmlspecialchars(trim($_POST['friday']), ENT_COMPAT, "UTF-8");
	$sunday = htmlspecialchars(trim($_POST['sunday']), ENT_COMPAT, "UTF-8");
	$t09 = htmlspecialchars(trim($_POST['t09']), ENT_COMPAT, "UTF-8");
	$t11 = htmlspecialchars(trim($_POST['t11']), ENT_COMPAT, "UTF-8");
	$t13 = htmlspecialchars(trim($_POST['t13']), ENT_COMPAT, "UTF-8");
	$t15 = htmlspecialchars(trim($_POST['t15']), ENT_COMPAT, "UTF-8");
	$t17 = htmlspecialchars(trim($_POST['t17']), ENT_COMPAT, "UTF-8");
	$t19 = htmlspecialchars(trim($_POST['t19']), ENT_COMPAT, "UTF-8");
	$commuting_days = htmlspecialchars(trim($_POST['commuting_days']), ENT_COMPAT, "UTF-8");
	$contents = htmlspecialchars(trim($_POST['contents']), ENT_COMPAT, "UTF-8");
	
	// お申込みコースが選択されていない場合
	if ($course == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_COURSE'] . '<br>';
		
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
	
	// 年齢が入力されていない場合
	if ($age == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_AGE'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	// テニス歴が年齢を超えている場合
	} elseif($age < $tennis_history) {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_AGE_VIOLATION1'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	// テニス歴 + ブランク年数が年齢を超えている場合
	} elseif($age < $blank) {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_AGE_VIOLATION2'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	} elseif($age < $tennis_history + $blank) {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_AGE_VIOLATION3'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 性別が選択されていない場合
	if ($gender == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_GENDER'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 職業が選択されていない場合
	if ($job == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['JOIN_JOB'] . '<br>';
		
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
	
	// 個人情報保護法同意にチェックされていない場合
	if ($_POST['agree'] == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['INQUIRY_AGREE'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 置換タグ設定
	if($error_message != "") $replace_tag['ERROR_MESSAGE'] = $error_message . '<br>';
	$replace_tag['COURSE'] = $course;
	$replace_tag['TARGET'] = $target;
	$replace_tag['NAME'] = $name;
	$replace_tag['EMAIL'] = $email;
	$replace_tag['PHONE'] = $phone;
	$replace_tag['AGE'] = $age;
	$replace_tag['GENDER'] = $gender;
	$replace_tag['JOB'] = $job;
	$replace_tag['TENNIS_HISTORY'] = $tennis_history;
	$replace_tag['BLANK'] = $blank;
	$replace_tag['CONTENTS'] = $contents;
	if($_POST['agree'] != '') $replace_bracket_tag['AGREE'] = 'checked';
	$replace_tag['INPUT_COURSE'] = FUNCTION_webManagement::setHiddenTag('course', $course);
	$replace_bracket_tag[$kyh_course[$course]] = 'selected';
	$replace_tag['INPUT_TARGET'] = FUNCTION_webManagement::setHiddenTag('target', $target);
	$replace_tag['INPUT_NAME'] = FUNCTION_webManagement::setHiddenTag('name', $name);
	$replace_tag['INPUT_EMAIL'] = FUNCTION_webManagement::setHiddenTag('email', $email);
	$replace_tag['INPUT_PHONE'] = FUNCTION_webManagement::setHiddenTag('phone', $phone);
	$replace_tag['INPUT_AGE'] = FUNCTION_webManagement::setHiddenTag('age', $age);
	$replace_tag['INPUT_GENDER'] = FUNCTION_webManagement::setHiddenTag('gender', $gender);
	$replace_bracket_tag[$kyh_gender[$gender]] = 'selected';
	$replace_tag['INPUT_JOB'] = FUNCTION_webManagement::setHiddenTag('job', $job);
	$replace_bracket_tag[$kyh_job[$job]] = 'selected';
	$replace_tag['INPUT_TENNIS_HISTORY'] = FUNCTION_webManagement::setHiddenTag('tennis_history', $tennis_history);
	$replace_tag['INPUT_BLANK'] = FUNCTION_webManagement::setHiddenTag('blank', $blank);
	$replace_tag['INPUT_CONTENTS'] = FUNCTION_webManagement::setHiddenTag('contents', $contents);
	
	// エラーフラグが設定されている場合
	if($error_flg == True) {
	
		// お問い合わせページを表示する
		$screen_path = $GLOBALS['_SCR_JOIN_TOP_'];
		
	}
	
}

// 確認画面を表示する
FUNCTION_webManagement::getDisplayScreen($screen_path, $replace_tag, $replace_bracket_tag);