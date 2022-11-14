<?php

    try {
        // DB接続
        $dbConnection = new PDO('mysql:host=db;dbname=online_bbs;charset=utf8', 'docker', 'docker');
    } catch (\Exception $e) {
        // mysql_error()
        var_dump($e->getMessage());
    }

    if (!$dbConnection) {
        die('データベースに接続できません');
    }

    //mysql_select_db('online_bbs', $dbConnection);
    $errors = [];

    // POST なら保存処理実行
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // name バリデーション
        $name = null;
        if (!isset($_POST['name']) || !strlen($_POST['name'])) {
            $errors['name'] = '名前を入力してください';
        } elseif (strlen($_POST['name']) > 40) {
            $errors['name'] = '名前は40文字以内で入力してください';

        } else {
            $name = $_POST['name'];
        }

        // comment バリデーション
        $comment = null;
        if (!isset($_POST['comment']) || !strlen($_POST['comment'])) {
            $errors['comment'] = 'ひとことを入力してください';
        } elseif (strlen($_POST['comment']) > 200) {
            $errors['comment'] = '名前は200文字以内で入力してください';

        } else {
            $comment = $_POST['comment'];
        }

        // バリデーションエラーがなければ保存処理
        if (empty($errors)) {
            // エスケープ
            $escapedName = $dbConnection->quote($name);
            $escapedComment = $dbConnection->quote($comment);
            $escapedCreatedAt = $dbConnection->quote(date('Y-m-d H:i:s'));

            $sql = <<<SQL
            INSERT INTO posts (name, comment, created_at)
            VALUES ($escapedName, $escapedComment, $escapedCreatedAt);
            SQL;

            $dbConnection->query($sql);
        }

    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja">
    <head>
        <title>ひとこと掲示板</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1>ひとこと掲示板</h1>
        <!-- 投稿フォーム -->
        <form action="bbs.php" method="post">
            <?php if (count($errors)): ?>
                <ul class="error_list">
                    <?php foreach ($errors as $error): ?>
                        <li>
                            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            名前：　<input type="text" name="name"/><br/>
            ひとこと：　<input type="text" name="comment" size="60"/><br/>
            <input type="submit" name="submit" value="送信"/>
        </form>
        <!-- 投稿一覧 -->
        <?php
            $postIndexSql = <<<SQL
            SELECT 
                * 
            FROM 
                posts
            ORDER BY  
                created_at DESC
            SQL;
            $postIndexResult = $dbConnection->query($postIndexSql);
        ?>
        <?php if ($postIndexResult !== false && $postIndexResult->rowCount() > 0): ?>
            <ul>
                <?php while ($post = $postIndexResult->fetch()): ?>
                    <li>
                        <?php echo htmlspecialchars($post['name'],ENT_QUOTES, 'UTF-8')?>
                        <?php echo htmlspecialchars($post['comment'],ENT_QUOTES, 'UTF-8')?>
                        - <?php echo htmlspecialchars($post['created_at'],ENT_QUOTES, 'UTF-8')?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
        <?php
            // SQL結果を保持していたメモリを解放、MySQL接続を閉じる
            $postIndexResult = null;
            $dbConnection = null;
        ?>
    </body>
</html>
