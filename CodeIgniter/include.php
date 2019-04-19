<?php

header("Content-Type: text/html; charset=utf-8;");
date_default_timezone_set('Asia/Shanghai');


defined('ENVIRONMENT')?'':define('ENVIRONMENT', 'production');
defined('__TIME')?'':define('__TIME', time());

switch (ENVIRONMENT)
{
	case 'development':
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_STRICT & ~E_USER_NOTICE);
		ini_set('display_errors', 1);
	break;

	case 'testing':
		error_reporting(E_ALL  );
		ini_set('display_errors', 1);
		break;
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		}
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

$system_path = 'system';

$application_folder = 'application';

$view_folder = 'views';

$code_igniter_path = dirname(__FILE__);
	
$code_igniter_path = rtrim(str_replace("\\","/",$code_igniter_path),  '/\\');

define('CIPATH', $code_igniter_path.  '/'); //E:/Znizao/CodeIgniter/

$system_path = CIPATH . $system_path.'/'; //E:/Znizao/CodeIgniter/system/

if ( ! is_dir($system_path))
{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
	exit(3); // EXIT_CONFIG
}

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME)); //include.php

// Path to the system directory
define('BASEPATH', $system_path); // E:/Znizao/CodeIgniter/system/

//FCPATH 每个网站自己的 include.php 定义好了
//define('FCPATH', str_replace("\\","/",dirname(__FILE__).DIRECTORY_SEPARATOR)); // E:/Znizao/shenghuopindao/

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH)); // system

$application_folder = FCPATH.$application_folder;


if (!is_dir($application_folder))
{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
	exit(3); // EXIT_CONFIG
}

define('APPPATH', str_replace("\\","/",$application_folder.DIRECTORY_SEPARATOR)); // E:/Znizao/shenghuopindao/application/

$view_folder = FCPATH.$view_folder;

if (!is_dir($view_folder))
{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
	exit(3); // EXIT_CONFIG
}

define('VIEWPATH', str_replace("\\","/",$view_folder.DIRECTORY_SEPARATOR)); // E:/Znizao/shenghuopindao/views/

define('EXT', '.php');

define('CONFIG',APPPATH.'config/'); // E:/Znizao/shenghuopindao/application/config/

define('RESOURCE',FCPATH.'resource'); // E:/Znizao/shenghuopindao/resource
	
$script = $_SERVER['SCRIPT_NAME'];
define('WEB', substr($script,0, strrpos($script,'/') )); // /shenghuopindao
define('ROOT', str_replace(WEB, '' , FCPATH) ); //E:/Znizao/

if(!defined('PREFIX')){
	define('PREFIX','');//resource view 的前缀目录
}
		$prefix = empty(PREFIX) ? '' : trim(PREFIX,'/');

		define('VIEWS', rtrim(VIEWPATH.$prefix,'/')); //当前模板文件的路径 E:/Znizao/shenghuopindao/views
		
		define('UPLOAD', RESOURCE.'/upload'); //图片上传的绝对路径 不要前缀 F:/Znizao/canyin/resource/upload

		define('UPLOAD_PATH',WEB.'/resource/upload'); //  /canyin/resource/upload 不要前缀
		
		define('RES_COMMON', WEB.'/resource/common' );
		define('RES_PATH', rtrim(WEB.'/resource/'. $prefix,'/')); //  /canyin/resource/m
 
		define('CSS_PATH',RES_PATH.'/css');//  /canyin/resource/m/css

		define('JS_PATH',RES_PATH.'/js');//  /canyin/resource/m/js

		define('IMG_PATH',RES_PATH.'/images');//  /canyin/resource/m/images
		define('COMMON_JS', WEB.'/resource/common'); //公共的js路径 /canyin/resource/common


require_once BASEPATH.'core/Import.php';
require_once BASEPATH.'core/Magic.php';
require_once BASEPATH.'core/CodeIgniter.php';

