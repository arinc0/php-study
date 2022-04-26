PHPスクリプトを実行します。
<?php

/**
 * サンプルのPHPスクリプト.
 */

$number = mt_rand();

$br = nl2br(PHP_EOL);

echo $br;
echo '<-- ここからPHPの出力 -------------------------------------->', $br, $br;


if ($number % 2 === 0) {
    echo $number,"は偶数です。", $br;
} else {
    echo $number,"は奇数です。", $br;
}

// 真偽値の出力テスト
$a = true;
$b = false;

echo 'true を var_dump() して出力', var_dump((string) $a), $br;
echo 'false を va_dump() して出力', var_dump((string) $b), $br;

$var = 'test';
$var_name = 'var';

echo "可変変数テスト: ", ${$var_name}, $br;

$foo = 1;

function localScopeCheck(): void
{
    global $foo;
    $foo = 10;
    $bar = 20;
}

localScopeCheck();

// global でグローバル変数を読み込むと参照を取得するみたい。
echo '$foo: ', $foo, 'グローバル変数 $foo が、ローカルでアクセスできなければ、$foo === 1 となる。', $br;

// echo '$bar: ', $bar, 'ローカル変数 $bar が、グローバルからアクセスできなければ、エラーが発生する。', $br;

echo '<pre>';
var_dump(getallheaders());
echo $br;
echo '</pre>';

echo $br;
echo '<-- ここまでPHPの出力 -------------------------------------->', $br;
?>

PHPスクリプトを終了します。