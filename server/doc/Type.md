# 型
PHPは動的型付け言語なので、型を明示的に宣言せずに変数を利用することができる。  

だが、内部的には全ての変数は型を持っている。

動的型付け言語は、型に縛られない柔軟なプログラミングをすることができる。(メリット)  

引数に渡す時等に、自動的にキャストされることがあるので、どの処理が自動的なキャストをするのか把握しないと思わぬバグに繋がる。

※`strict_types =1`を指定することで、クラス単位で自動的にキャストされないようにすることもできる。

PHPには8つの型がある。

## 整数(int)

```php
<?php

// 10進数の10
echo 10;
#=> 10

// 16進数の10, 10進数の16
echo 0x10;
#=> 16

// 8進数の10, 10進数の8
echo 010;
#=> 8

```

PHP7.4以降で使用可能な整数リテラルの形式は以下のようになっている。

```
decimal     : [1-9][0-9]*(_[0-9]+)* | 0

hexadecimal : 0[xX][0-9a-fA-F]+(_[0-9a-fA-F]+)*

octal       : 0[oO]?[0-7]+(_[0-7]+)*

binary      : 0[bB][01]+(_[01]+)*

integer     : decimal | hexadecimal | octal | binary
```

大体はアンダースコアが末尾につかなければ大丈夫そう。


整数の最大値、最小値は定数 `PHP_INT_MAX`、`PHP_INT_MIN`で確認可能。

範囲外の数を指定した場合、`float`として解釈される。  

整数のサイズはプラットフォームに依存する。

32ビットシステムにおける`PHP_INT_MAX` は`2147483647`です。  

`2147483647`を超えるとオーバーフローを起こし float になります。

```php
<?php

$large_number = PHP_INT_MAX; // PHP_INT_MAX=2147483647
var_dump($large_number);     // int(2147483647)

$large_number = PHP_INT_MAX + 1;
var_dump($large_number);     // float(2147483648)

```

64ビットシステムにおける`PHP_INT_MAX`は`9223372036854775807`です。

`9223372036854775807`を超えるとオーバーフローを起こします。

```php
<?php

$large_number = PHP_INT_MAX; // PHP_INT_MAX= 9223372036854775807
var_dump($large_number);     // int(9223372036854775807)

$large_number = 9223372036854775808;
var_dump($large_number);     // float(9.2233720368548E+18)

```

`9.2233720368548E+18`は[科学表記法のE表記](https://miniwebtool.com/ja/scientific-notation-calculator/)です。

`1.2×10^5`は`1.2E+5`または`1.2e5`と記述され、`7.4×10^-8`は`7.4E-8`と記述されます。

ちなみに、PHPは符号なし整数(`unsigned_int`)をサポートしていない。
その為、整数のサイズを超えて`float`になった値を`int`でキャストすると、最小値になる。
これは`float`型の仮数部、桁の精度が14桁で丸められた結果だったりすると思う。(多分、適当)

## 浮動小数点数(float)
PHPの浮動小数点数は`float`と表記されるが、実際には倍精度浮動小数点数`double`である。  

[PHP: 浮動小数点](https://www.php.net/manual/ja/language.types.float.php)

LNUMは Long int NUMber.  

[https://www.sejuku.net/blog/25690](https://www.sejuku.net/blog/25690)  

8byteってことは 64bit で プラットフォームに依存はするが、64bitシステムであれば long int とLNUM の値のサイズ、範囲同じ。

floatのサイズもintと同様にプラットフォームに依存する。
通常は10進数で14桁の精度があり、最大値はおよそ 1.8e308(64bit IEEE フォーマット)

十進数では正確な小数で表せる有理数、たとえば 0.1 や 0.7 は、 二進数の浮動小数点数としては正確に表現できません。 これは、仮数部をいくら大きくしても同じです。 したがって、それを内部的な二進数表現に変換する際には、どうしても多少精度が落ちてしまう。

正確に少数を扱った計算を行いたい場合は、[任意制度数学関数](https://www.php.net/manual/ja/ref.bc.php)などを使用すると良い。

```php
<?php
$foo = 1 + "10.5";                // $foo は float (11.5)
$foo = 1 + "-1.3e3";              // $foo は float (-1299)
$foo = 1 + "bob-1.3e3";           // PHP 8.0.0 以降は TypeError。それより前は、$foo は integer (1)
$foo = 1 + "bob3";                // PHP 8.0.0 以降は TypeError。それより前は、$foo は integer (1)
$foo = 1 + "10 Small Pigs";       // PHP 8.0.0 では $foo は integer (11) で、かつ E_WARNING。それより前は E_NOTICE
$foo = 4 + "10.2 Little Piggies"; // PHP 8.0.0 では $foo は float (14.2) で、かつ E_WARNING。それより前は E_NOTICE
$foo = "10.0 pigs " + 1;          // PHP 8.0.0 では $foo は float (11) で、かつ E_WARNING。それより前は E_NOTICE
$foo = "10.0 pigs " + 1.0;        // PHP 8.0.0 では $foo は float (11) で、かつ E_WARNING。それより前は E_NOTICE
?>
```

float から整数に変換する場合、その数はゼロのほうに丸められる。

```
<?php

var_dump((int)8.4);  // int(8)

var_dump((int)8.5);  // int(8)

var_dump((int)8.6);  // int(8)
```
 PHP 8.1.0 以降では、精度を損なうことになる float から int への暗黙の変換は推奨されなくなり、警告が発生する。

## 文字列

PHPは全て可変長文字列。
C言語のchar型のような文字型は存在しない。

※char型は固定長を表すことが多い。初期のC言語だとASCII文字(7ビット)を格納する為の1バイト整数型を意味していた。
SQLにもchar(10)などの指定ができるが、10文字の固定長文字列を表す。可変長文字列を表したい場合はVARCHAR型を使用する。(character varying)
マルチバイト文字の扱いなどが言語によって違うので気をつけること。

PHPには正規表現リテラルが存在しないため、正規表現を用いた処理を行う場合、正規業限を表す文字列を指定する。

### 文字列リテラル
引用符'(シングルクォート)で括る。
引用符とバックスラッシュをリテラルとして指定するにはバックスラッシュでエスケープする。
それ以外のバックスラッシュはその物として扱われる。\nもそのまま。

二重引用符 "(ダブルクォート)で括る。

特殊な文字として解釈されるエスケープシーケンスに使われるアルファベット。
n, r, t, v, e, f

### 正規表現
\[0-7]{1,3}
\x[0-9A-Fa-f]{1,2}
\u{[0-9A-Fa-f]+}

これ何もわからん