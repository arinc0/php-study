# パーフェクトPHPを勉強する為の環境
  
## DBの設定
rootユーザーでログイン
```shell
# pass は root
mysql -h127.0.0.1 -uroot -p
```

初期ユーザーにDB作成権限を付与
```sql
grant all privileges on *.* to 'docker'@'%';
```

権限を付与したら下記のようにデータベース作成、テーブル作成
```shell
# db
mysql -h127.0.0.1 -udocker -p < sql/create_online_bbs_db.sql
# table
mysql -h127.0.0.1 -udocker -p online_bbs  < sql/create_posts_table.sql 
```