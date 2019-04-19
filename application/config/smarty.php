<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['cache_lifetime'] = 60;
$config['caching'] = false;
$config['template_dir'] = APPPATH . 'views';
$config['compile_dir'] = APPPATH . 'views/templates_c';
$config['cache_dir'] = APPPATH . 'views/cache';
$config['config_dir'] = APPPATH . 'views/config';
$config['use_sub_dirs'] = false; //子目录变量(是否在缓存文件夹中生成子目录)
$config['left_delimiter'] = '<{';
$config['right_delimiter'] = '}>';

