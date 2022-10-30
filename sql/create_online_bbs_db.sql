-- 初期ユーザーにDB作成権限を与えたいのでrootユーザーでログイン後に下記コマンドを実行しておく必要がある
-- grant all privileges on *.* to 'docker'@'%';
CREATE DATABASE IF NOT EXISTS `online_bbs` DEFAULT CHARACTER SET utf8mb4;
