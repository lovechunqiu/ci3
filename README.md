# CI version 3.1.0
支持多目录项目隔离

[测试地址](https://ci.lovechunqiu.com)

## 相关配置

> 修改：dir/config/config.php 中的 base_url 必须填写自己的域名+dir
  其中dir为目录名，默认application不用填写，只需要到domain即可

> 修改：dir/config/database.php 修改数据库配置

> 修改：shared/config/common_url.php 中的static_url【静态资源路径】为自己的 domain

## 后台相关配置

> 将doc中的数据拷贝到admin/cache里面去
  其中要替换到Data/submenu_1.php中的 http://www.ci.om 域名为自己的domain

> 后台初始化密码：admin/admin

> 后台地址：http://domain/admin

## nginx 配置 
根据自己环境灵活修改
```
server
    {

        listen       443 ssl;
        server_name ci.lovechunqiu.com;
        index index.html index.htm index.php;
        access_log  /home/logs/ci/access.log;
        error_log  /home/logs/ci/error.log;
        root  /home/www/ci3;

        ssl_certificate ssh/lovechunqiu/ci.lovechunqiu.com.pem;   #将domain name.pem替换成您证书的文件名。
        ssl_certificate_key ssh/lovechunqiu/ci.lovechunqiu.com.key;   #将domain name.key替换成您证书的密钥文件名。
        ssl_session_timeout 5m;
        ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;  #使用此加密套件。
        ssl_protocols TLSv1 TLSv1.1 TLSv1.2;   #使用该协议进行配置。
        ssl_prefer_server_ciphers on;

        include enable-php-pathinfo.conf;

        location / {
            if (!-e $request_filename){
                rewrite ^/(.*)$ /index.php/$1 last;
                break;
            }
        }
        location ~ /index.php {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root/index.php;
            include        fastcgi_params;
            fastcgi_param APPLICATION_ENV dev;
        }

        location ~ .*\.php$ {
            deny all;
        }

    }


server {
    listen 80;
    server_name ci.lovechunqiu.com;   #将localhost修改为您证书绑定的域名，例如：www.example.com。
    rewrite ^(.*)$ https://$host$1 permanent;   #将所有http请求通过rewrite重定向到https。
}
```
