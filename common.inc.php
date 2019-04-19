<?php
/*
	数据库配置
*/

define('WEB_HTTP', 'http://');//http协议 默认就可以
define('WEB_DOMAIN', 'testadmin.4006689073.com');//访问的域名地址.
define('WEB_PORT', '80');//端口地址 默认即可
define('C_DOMAIN', '.4006689073.com');//域名的顶级域名, 前面需要加 '.' 号

define('DBHOST','211.149.128.16');//数据库ip地址
define('DBUSER','admin_test9073');//数据库用户名
define('DBPWD','E3B2T6r3');//数据库密码
define('DBNAME','admin_test9073');//数据库名
define('DBPORT', '3306');//默认即可
define('DBPREFIX','hh_');//默认即可

define('ENVIRONMENT', 'production');
define('IS_DEBUG',false);
define('SUPER_ADMIN_ID', 1);

define('PAGE_LIMIT', 20); //分页的每页数量

define('WEB_ROOT', WEB_HTTP.WEB_DOMAIN);

define ('CHARSET', 'UTF-8');
define ('SECRET_KEY', 'SECRET_KEY');
define ('Authorize', 'Authorize');
define ('C_PREFIX', 'KK-');

define ('C_PATH', '/');
define ('C_EXPIRE', 2592000);
define ('C_SECURE', false); //https
define ('C_HTTPONLY', true);	 //httponly

?>