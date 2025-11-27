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
	$name = htmlspecialchars(trim($_POST['name']), ENT_COMPAT, "UTF-8");
	$email = htmlspecialchars(trim($_POST['email']), ENT_COMPAT, "UTF-8");
	$phone = htmlspecialchars(trim($_POST['phone']), ENT_COMPAT, "UTF-8");
	$age = htmlspecialchars(trim($_POST['age']), ENT_COMPAT, "UTF-8");
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
	$saturday = htmlspecialchars(trim($_POST['saturday']), ENT_COMPAT, "UTF-8");
	$sunday = htmlspecialchars(trim($_POST['sunday']), ENT_COMPAT, "UTF-8");
	$t09 = htmlspecialchars(trim($_POST['t09']), ENT_COMPAT, "UTF-8");
	$t11 = htmlspecialchars(trim($_POST['t11']), ENT_COMPAT, "UTF-8");
	$t13 = htmlspecialchars(trim($_POST['t13']), ENT_COMPAT, "UTF-8");
	$t15 = htmlspecialchars(trim($_POST['t15']), ENT_COMPAT, "UTF-8");
	$t17 = htmlspecialchars(trim($_POST['t17']), ENT_COMPAT, "UTF-8");
	$t19 = htmlspecialchars(trim($_POST['t19']), ENT_COMPAT, "UTF-8");
	$commuting_days = htmlspecialchars(trim($_POST['commuting_days']), ENT_COMPAT, "UTF-8");
	$contents = htmlspecialchars(trim($_POST['contents']), ENT_COMPAT, "UTF-8");
	
	// 名前が入力されていない場合
	if ($name == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['RECRUIT_NAME'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// メールアドレスが入力されていない場合
	if ($email == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['RECRUIT_EMAIL'] . '<br>';
		
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
		$error_message .= $GLOBALS['_ERROR_']['RECRUIT_PHONE'] . '<br>';
		
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
		$error_message .= $GLOBALS['_ERROR_']['RECRUIT_AGE'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	// 入力されている場合
	} else {
	
		// ソフトテニス歴が入力されていない場合
		if($soft_tennis_history == "") {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['RECRUIT_SOFT_TENNIS_HISTORY'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		// ソフトテニス歴が年齢を超えている場合
		} elseif($age < $soft_tennis_history){
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['RECRUIT_AGE_VIOLATION1'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		}
		
		// テニス歴が入力されていない場合
		if($tennis_history == "") {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['RECRUIT_TENNIS_HISTORY'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		// テニス歴が年齢を超えている場合
		} elseif($age < $tennis_history) {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['RECRUIT_AGE_VIOLATION2'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		}
		
		// ソフトテニス指導歴が入力されていない場合
		if($soft_tennis_leader_history == "") {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['RECRUIT_SOFT_TENNIS_LEADER_HISTORY'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		
		// ソフトテニス指導歴が年齢を超えている場合
		} elseif($age < $soft_tennis_leader_history) {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['RECRUIT_AGE_VIOLATION3'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		}
		
		// テニス指導歴が入力されていない場合
		if($tennis_leader_history == "") {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['RECRUIT_TENNIS_LEADER_HISTORY'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		// テニス指導歴が年齢を超えている場合
		} elseif($age < $tennis_leader_history) {
		
			// エラーメッセージを設定する
			$error_message .= $GLOBALS['_ERROR_']['RECRUIT_AGE_VIOLATION4'] . '<br>';
			
			// エラーフラグをTrueに設定する
			$error_flg = True;
			
		}
		
	}
	
	// 郵便番号が入力されていない場合
	if ($post_num1 == "" || $post_num2 == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['RECRUIT_POST_NUM'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
	
	}
	
	// 住所が入力されていない場合
	if ($address == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['RECRUIT_ADDRESS'] . '<br>';
		
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
	
	// レッスン可能曜日が選択されていない場合
	if ($monday == "" && $tuesday == "" && $wednesday == "" && $thusday == "" && $friday == "" && $saturday == "" && $sunday == "") {
	echo 'aaaaa';
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['RECRUIT_LESSON_WEEK'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// レッスン可能時間帯が選択されていない場合
	if ($t09 == "" && $t11 == "" && $t13 == "" && $t15 == "" && $t17 == "" && $t19 == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['RECRUIT_LESSON_TIME'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 希望レッスン日数が入力されていない場合
	if ($commuting_days == "") {
	
		// エラーメッセージを設定する
		$error_message .= $GLOBALS['_ERROR_']['RECRUIT_COMMUTING_DAYS'] . '<br>';
		
		// エラーフラグをTrueに設定する
		$error_flg = True;
		
	}
	
	// 月曜日が選択されている場合
	if ($monday == 'on') {
	
		// レッスン可能曜日に月曜日を追加する
		$replace_tag['DAY_OF_WEEK'] .= '月曜日<br>';
		
		// 月曜日にチェックする(入力画面用)
		$replace_bracket_tag['MONDAY'] = 'checked';
		
	}
	
	// 火曜日が選択されている場合
	if ($tuesday == 'on') {
	
		// レッスン可能曜日に火曜日を追加する
		$replace_tag['DAY_OF_WEEK'] .= '火曜日<br>';
		
		// 火曜日にチェックする(入力画面用)
		$replace_bracket_tag['TUESDAY'] = 'checked';
		
	}
	
	// 水曜日が選択されている場合
	if ($wednesday == 'on') {
	
		// レッスン可能曜日に水曜日を追加する
		$replace_tag['DAY_OF_WEEK'] .= '水曜日<br>';
		
		// 水曜日にチェックする(入力画面用)
		$replace_bracket_tag['WEDNESDAY'] = 'checked';
		
	}
	
	// 木曜日が選択されている場合
	if ($thursday == 'on') {
	
		// レッスン可能曜日に木曜日を追加する
		$replace_tag['DAY_OF_WEEK'] .= '木曜日<br>';
		
		// 木曜日にチェックする(入力画面用)
		$replace_bracket_tag['THURSDAY'] = 'checked';
		
	}
	
	// 金曜日が選択されている場合
	if ($friday == 'on') {
	
		// レッスン可能曜日に金曜日を追加する
		$replace_tag['DAY_OF_WEEK'] .= '金曜日<br>';
		
		// 金曜日にチェックする(入力画面用)
		$replace_bracket_tag['FRIDAY'] = 'checked';
		
	}
	
	// 土曜日が選択されている場合
	if ($saturday == 'on') {
	
		// レッスン可能曜日に土曜日を追加する
		$replace_tag['DAY_OF_WEEK'] .= '土曜日<br>';
		
		// 土曜日にチェックする(入力画面用)
		$replace_bracket_tag['SATURDAY'] = 'checked';
		
	}
	
	// 日曜日が選択されている場合
	if ($sunday == 'on') {
	
		// レッスン可能曜日に日曜日を追加する
		$replace_tag['DAY_OF_WEEK'] .= '日曜日<br>';
		
		// 日曜日にチェックする(入力画面用)
		$replace_bracket_tag['SUNDAY'] = 'checked';
		
	}
	
	// 9:00～11:00が選択されている場合
	if ($t09 == 'on') {
	
		// レッスン可能時間帯に9:00～11:00を追加する
		$replace_tag['LESSON_TIME'] .= '9:00～11:00<br>';
		
		// 9:00～11:00にチェックする(入力画面用)
		$replace_bracket_tag['T09'] = 'checked';
		
	}
		
	// 11:00～13:00が選択されている場合
	if ($t11 == 'on') {
	
		// レッスン可能時間帯に11:00～13:00を追加する
		$replace_tag['LESSON_TIME'] .= '11:00～13:00<br>';
		
		// 11:00～13:00にチェックする(入力画面用)
		$replace_bracket_tag['T11'] = 'checked';
		
	}
	
	// 13:00～15:00が選択されている場合
	if ($t13 == 'on') {
	
		// レッスン可能時間帯に13:00～15:00を追加する
		$replace_tag['LESSON_TIME'] .= '13:00～15:00<br>';
		
		// 13:00～15:00にチェックする(入力画面用)
		$replace_bracket_tag['T13'] = 'checked';
		
	}
	
	// 15:00～17:00が選択されている場合
	if ($t15 == 'on') {
	
		// レッスン可能時間帯に15:00～17:00を追加する
		$replace_tag['LESSON_TIME'] .= '15:00～17:00<br>';
		
		// 15:00～17:00にチェックする(入力画面用)
		$replace_bracket_tag['T15'] = 'checked';
		
	}
	
	// 17:00～19:00が選択されている場合
	if ($t17 == 'on') {
	
		// レッスン可能時間帯に17:00～19:00を追加する
		$replace_tag['LESSON_TIME'] .= '17:00～19:00<br>';
		
		// 17:00～19:00にチェックする(入力画面用)
		$replace_bracket_tag['T17'] = 'checked';
		
	}
	
	// 19:00～21:00が選択されている場合
	if ($t19 == 'on') {
	
		// レッスン可能時間帯に19:00～21:00を追加する
		$replace_tag['LESSON_TIME'] .= '19:00～21:00<br>';
		
		// 19:00～21:00にチェックする(入力画面用)
		$replace_bracket_tag['T19'] = 'checked';
		
	}
	
	// 置換タグ設定
	if($error_message != "") $replace_tag['ERROR_MESSAGE'] = $error_message . '<br>';
	$replace_tag['NAME'] = $name;
	$replace_tag['EMAIL'] = $email;
	$replace_tag['PHONE'] = $phone;
	$replace_tag['AGE'] = $age;
	$replace_tag['POST_NUM1'] = $post_num1;
	$replace_tag['POST_NUM2'] = $post_num2;
	$replace_tag['ADDRESS'] = $address;
	$replace_tag['GENDER'] = $gender;
	$replace_tag['SOFT_TENNIS_HISTORY'] = $soft_tennis_history;
	$replace_tag['TENNIS_HISTORY'] = $tennis_history;
	$replace_tag['SOFT_TENNIS_LEADER_HISTORY'] = $soft_tennis_leader_history;
	$replace_tag['TENNIS_LEADER_HISTORY'] = $tennis_leader_history;
	$replace_tag['COMMUTING_DAYS'] = $commuting_days;
	$replace_tag['CONTENTS'] = $contents;
	$replace_tag['URL'] = 'recruit_complete.html';
	$replace_bracket_tag['URL'] = 'recruit_complete.html';
	if($_POST['agree'] != '') $replace_bracket_tag['AGREE'] = 'checked';
	$replace_tag['INPUT_NAME'] = FUNCTION_webManagement::setHiddenTag('name', $name);
	$replace_tag['INPUT_EMAIL'] = FUNCTION_webManagement::setHiddenTag('email', $email);
	$replace_tag['INPUT_PHONE'] = FUNCTION_webManagement::setHiddenTag('phone', $phone);
	$replace_tag['INPUT_AGE'] = FUNCTION_webManagement::setHiddenTag('age', $age);
	$replace_tag['INPUT_POST_NUM1'] = FUNCTION_webManagement::setHiddenTag('post_num1', $post_num1);
	$replace_tag['INPUT_POST_NUM2'] = FUNCTION_webManagement::setHiddenTag('post_num2', $post_num2);
	$replace_tag['INPUT_ADDRESS'] = FUNCTION_webManagement::setHiddenTag('address', $address);
	$replace_tag['INPUT_GENDER'] = FUNCTION_webManagement::setHiddenTag('gender', $gender);
	$replace_bracket_tag[$kyh_gender[$gender]] = 'selected';
	$replace_tag['INPUT_SOFT_TENNIS_HISTORY'] = FUNCTION_webManagement::setHiddenTag('soft_tennis_history', $soft_tennis_history);
	$replace_tag['INPUT_TENNIS_HISTORY'] = FUNCTION_webManagement::setHiddenTag('tennis_history', $tennis_history);
	$replace_tag['INPUT_SOFT_TENNIS_LEADER_HISTORY'] = FUNCTION_webManagement::setHiddenTag('soft_tennis_leader_history', $soft_tennis_leader_history);
	$replace_tag['INPUT_TENNIS_LEADER_HISTORY'] = FUNCTION_webManagement::setHiddenTag('tennis_leader_history', $tennis_leader_history);
	$replace_tag['INPUT_MONDAY'] = FUNCTION_webManagement::setHiddenTag('monday', $monday);
	$replace_tag['INPUT_TUESDAY'] = FUNCTION_webManagement::setHiddenTag('tuesday', $tuesday);
	$replace_tag['INPUT_WEDNESDAY'] = FUNCTION_webManagement::setHiddenTag('wednesday', $wednesday);
	$replace_tag['INPUT_THURSDAY'] = FUNCTION_webManagement::setHiddenTag('thursday', $thursday);
	$replace_tag['INPUT_FRIDAY'] = FUNCTION_webManagement::setHiddenTag('friday', $friday);
	$replace_tag['INPUT_SATURDAY'] = FUNCTION_webManagement::setHiddenTag('saturday', $saturday);
	$replace_tag['INPUT_SUNDAY'] = FUNCTION_webManagement::setHiddenTag('sunday', $sunday);
	$replace_tag['INPUT_COMMUTING_DAYS'] = FUNCTION_webManagement::setHiddenTag('commuting_days', $commuting_days);
	$replace_tag['INPUT_CONTENTS'] = FUNCTION_webManagement::setHiddenTag('contents', $contents);
	$replace_tag['INPUT_T09'] = FUNCTION_webManagement::setHiddenTag('t09', $t09);
	$replace_tag['INPUT_T11'] = FUNCTION_webManagement::setHiddenTag('t11', $t11);
	$replace_tag['INPUT_T13'] = FUNCTION_webManagement::setHiddenTag('t13', $t13);
	$replace_tag['INPUT_T15'] = FUNCTION_webManagement::setHiddenTag('t15', $t15);
	$replace_tag['INPUT_T17'] = FUNCTION_webManagement::setHiddenTag('t17', $t17);
	$replace_tag['INPUT_T19'] = FUNCTION_webManagement::setHiddenTag('t19', $t19);
	
	// エラーフラグが設定されている場合
	if($error_flg == True) {
	
		// お問い合わせページを表示する
		$screen_path = $GLOBALS['_SCR_RECRUIT_TOP_'];
		
	} else {
	
		// お客様からのお問い合わせをメール送信
		$result = COMMON_Mail::sendMail('hyodo1011@yahoo.co.jp', 'RECRUIT_SYSTEM', array($name, $email, $phone, $age, $post_num1 . "-" . $post_num2, $address, $gender, $soft_tennis_history, $tennis_history, $soft_tennis_leader_hisotry, $tennis_leader_history, str_replace('<br>', "\r\n", $replace_tag['DAY_OF_WEEK']), str_replace('<br>', "\r\n", $replace_tag['LESSON_TIME']), $commuting_days, $contents));
		
		// お客様に自動メール送信処理
		$result = COMMON_Mail::sendMail($email, 'RECRUIT_USER', array($name));
		
		// 追加開発:::LINE通知
		
	}

}

// リダイレクト画面を表示する
FUNCTION_webManagement::getDisplayScreen($screen_path, $replace_tag, $replace_bracket_tag);