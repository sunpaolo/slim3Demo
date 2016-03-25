#项目基于slim3
参考：
https://github.com/zacao/slimvc
https://github.com/slimphp/Slim-Skeleton/
https://github.com/akrabat/slim3-skeleton

apps里通过目录区分多个应用（如基础代码跟配套的Tools）

config里存储独立于应用的配置

data存储应用相关的配置

i18n存储多语言的配置

lib目录用于不同项目使用的公共代码

public里作为入口程序，也通过目录区分应用

storage里存放日志 chmod 777 -R storage/

测试：
php -S localhost:8000 -t public\App
php -S localhost:8000 -t public\Tools

##composer dump-autoload --optimize
