# bithitkit

## API ローカルサーバー起動
```
cd api
docker-compose up -d
```

## DB CREATE TABLE
```
cd api/www/html/bithitkit-app
php artisan make:migration create_[TABLENAME]_table
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
