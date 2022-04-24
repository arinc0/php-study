PHPスクリプトを実行します。
<?php

/**
 * サンプルのPHPスクリプト.
 */

$number = mt_rand();

if ($number % 2 === 0) {
    echo $number,"は偶数です。",nl2br(PHP_EOL);
} else {
    echo $number,"は奇数です。",nl2br(PHP_EOL);
}

?>

PHPスクリプトを終了します。