selenium-test-for-symfony
=========================

## Description
symfony2でphpunit + seleniumを利用するテストプログラム
動作環境は
php5.6,mysql 5.6.31
動作確認画面はdoctrineのCRUD自動生成コマンドで作成。
`php app/console doctrine:generate:crud`
### dockerコンテナ

#### Apache
* Apacheのログは/app/logsにaccess\_log、error\_logが出力されます
	* 出力先を変えたい場合は `docker-compose.yml` のvolumesを変更してコンテナを再作成してください
* コンテナ内部では `/var/www/app` で ホスト./をマウントしています
* ポートは8000番をバインドしています、変えたい場合は`docker-compose.yml`のportsを変えてコンテナを再作成してください

#### MySQL

* MySQLの公式DockerImageを使用しています
	* mysql:5.6.31を使用
* `docker/db_init` を `/docker-entrypoint-initdb.d`にマウントすることでDBの初期化を行っています
	* 1.create\_database.sql、2.create\_table.sql
* コンテナの3306とホストの3306をバインドしています、ツールなどからコンテナに接続することが出来ます
	* root / passwordでログインできます
	* \# mysql -h 127.0.0.1 -uroot -ppassword

#### SeleniumHQ/docker-selenium

* SeleniumHQ/selenium/standalone-chrome-debugを利用しています
    * docker内にselenium サーバーとchromeがインストール済みパッケージ。
    * コンテナの4444,5900とホストの4444,5900をバインドしています。
    * 立ち上げると4444ポートでselenium serverが立ち上がり、5900ポートでVNCが立ち上がります。Finder→移動→サーバへ接続→サーバアドレス[vnc://localhost:5900]でVNCに接続できます(passwordはsecret)

#### サンプルテスト実行
- レポジトリのルートディレクトリ`docker-compose exec apache php bin/phpunit -c app` で実行出来ます。

## Requirement
php,docker,docker-compose

## Install

- dockerで開発環境をコンテナ作成
```
docker-compose up -d
```
-  composerを実行する
symfonyの依存ファイルをinstallする  

```
docker-compose exec apache php composer.phar -n --dev install
```

## note

- 再実行してうまく動かない場合はapp/cacheのキャッシュ削除して、最新のソースを反映してください。

## access

- 下記URLにアクセスすると動作を確認出来ます
- http://localhost:8000/todo

## Qiita
- http://qiita.com/yutaChaos/items/4a1da5d55a3bf0df889e

## Licence

[MIT](https://github.com/tcnksm/tool/blob/master/LICENCE)

## Author

yutaChaos(https://github.com/yutachaos)