<?php
$TO = ['bosod2018demo@systena.co.jp', 'myyui_alert_for_docomo-ml@nttdocomo.com'];
$CC = ['hyoudoutp@systena.co.jp'];
$BCC = [];
$SUBJECT = "処理時間、ユーザ数報告 %s";
$BODY = <<<EOD
%s

【処理時間】
発話作成時間：%d秒
出社退社時刻更新処理時間：%d秒
休日判定更新処理時間：%d秒
趣味嗜好推定結果更新処理時間：%d秒

【ユーザ数】
登録済みユーザ数：%s件
発話対象ユーザ数：%s件
Phase3以降のユーザ数：%s件

以上

EOD;
