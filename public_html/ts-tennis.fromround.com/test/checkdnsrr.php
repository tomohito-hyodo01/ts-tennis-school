<?php 
// checkdnsrr(string $hostname, string $type = "MX"): bool

// 文字列
$email = "hyodo1011@yahoo.co.jp";

// ドメインのみ抽出
$domain = substr($email, strpos($email, "@") + 1);

echo "ドメイン = " . $domain . "<br>";

echo checkdnsrr($domain, "MX");