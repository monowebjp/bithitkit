# bithitkit

## API ローカルサーバー起動
```
cd api
docker-compose up -d
```

## DB ログイン
```
docker-compose exec mysql8 bash
mysql -u root -p bithitkit
```

## DB SETTING
```
cd api/www/html/bithitkit-app
php artisan make:migration create_[TABLENAME]_table // テーブル作成
Php artisan make:migration add_[COLUMNNAME]_to_[TABLENAME]_table // カラム追加
```


## DB migrate
```
cd api
docker-compose exec php8-litespeed bash
cd www/html/bithitkit-app
php artisan config:cache
php artisan migrate
```

## クライアント開発
```
cd client
yarn dev
```

## DB構造
DB名: bithitkit
