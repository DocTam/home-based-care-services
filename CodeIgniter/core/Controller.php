<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 公共 Controller
 */
class Controller extends CI_Controller {

    protected $layout = '';
	protected $tpl_error = '';
    
    public function __construct() {
        parent::__construct();
        
        $this->layout = defined('LAYOUT')?LAYOUT:'';
		$this->tpl_error = defined('TPL_ERROR')?TPL_ERROR:'';
    }
    
    function replace_body($body){
		$pattern = array('/\<\!--(.*?)--\>/is');
        
        $body = preg_replace_callback($pattern, "replace_empty" , $body);

        $pattern = array('/\{\{\{style(.*?)style\}\}\}/is');
        
        $body = preg_replace_callback($pattern, "replace_style" , $body);
        
        $pattern = array('/\{\{\{script(.*?)script\}\}\}/is');
        
        $body = preg_replace_callback($pattern, "replace_script", $body);
        return $body;
    }

    protected function render($file = NULL, $data = null) {
        $body = $this->load->view($file, $data, TRUE);
        //替换script, style
        $body = $this->replace_body($body);
        
 		load_body($body);
        $this->load->view($this->layout);
    }
    
    protected function render_error($msg){
        $data = array(
            'error' => $msg,
        );
		
        $this->render($this->tpl_error,$data);
    }

}

function replace_empty(){
    return '';
}

function replace_script($match){
    if(!empty($match[0])){
         load_script($match[1]);
    }
    return '';
}

function replace_style($match){
    if(!empty($match[0])){
         load_style($match[1]);
    }
    return '';
}

function get_vars($key){
    if (empty($key)) {
        return '';
    }
    $CI = get_instance();
    $vars = $CI->load->get_var('load_vars');
    return  isset($vars[$key])? $vars[$key]: '';
}

function render_vars(){
    $num = func_num_args();         //输出参数个数
    if ($num <= 0) {
        return;
    }
    $varArray = func_get_args();
    
    $CI = get_instance();
    $vars = $CI->load->get_var('load_vars');
    
    foreach ($varArray as $v) {
        echo isset($vars[$v])?$vars[$v]:'';
    }
}

//在视图中输出css内容
function render_css(){
    $CI = get_instance();
    $css = $CI->load->get_var('load_css_files');
	$t = rand(1000,9999);
    if(!empty($css)) {
        foreach ($css as $v) {
            echo "<link href='{$v}?t={$t}' rel='stylesheet' type='text/css'> \n";
        }
    }
}

//在视图中输出css内容
function render_js(){
    $CI = get_instance();
    $js = $CI->load->get_var('load_js_files');
	$t = rand(1000,9999);
    if(!empty($js)) {
        foreach ($js as $v) {
			if(strpos($v,'/') !== false){
				echo "<script type='text/javascript' src='{$v}'></script>\n";
			} else if(strpos($v,'?') === false){
				if(ENVIRONMENT == 'development'){
					$s = JS_PATH.'/content/'.$v.'.js';
				} else {
					$s = JS_PATH.'/min/'.$v.'.min.js';
				}
				echo "<script type='text/javascript' src='{$s}?t={$t}'></script>\n";
			} else {
				echo "<script type='text/javascript' src='{$v}'></script>\n";
			}
        }
    }
}

//$val 视图中需要加载的js文件
function load_js(){
    
    $num = func_num_args();         //输出参数个数
    if ($num <= 0) {
        return;
    }
    $varArray = func_get_args();    
    load_some('load_js_files', $varArray);
}

//$val 视图中需要加载的css文件
function load_css(){
    $num = func_num_args();         //输出参数个数
    if ($num <= 0) {
        return;
    }    
    $varArray = func_get_args();    
    load_some('load_css_files', $varArray);
}

function load_style($val){
    load_some('load_styles', $val);
}

function render_style(){
    render_some('load_styles');
}

function load_script($val){
    load_some('load_scripts', $val);
}

function render_script(){
    render_some('load_scripts');
}

function load_body($val){
	load_some('body', $val);
}

function render_body(){
	render_some('body');
}

function load_some($key ,$val){
    $CI = get_instance();
    $vals = $CI->load->get_var($key);
    if(empty($vals)){//不存在
        $vals = array(); 
    }
    if(is_array($val)){
        foreach ($val as $v) {
            $vals[] = $v;
        }
    } else {
        $vals[] = $val;
    }
    $CI->load->vars($key,$vals);
}


function render_some($key){
    $CI = get_instance();
    $vals = $CI->load->get_var($key);
    if(!empty($vals)) {
        foreach ($vals as $v) {
            echo $v,"\n";
        }
    }
}

//在视图中可以直接用这个设置变量
function load_vars($key,$val){
    if(empty($key)){
        return;
    }
    $CI = get_instance();
    $vars = $CI->load->get_var('load_vars');
    if(empty($vars)){//不存在
        $vars = array(); 
    }
    $vars[$key] = $val;
    $CI->load->vars('load_vars',$vars);
}

function add_js() {

    $num = func_num_args();         //输出参数个数
    if ($num <= 0) {
        return;
    }
    $varArray = func_get_args();

    foreach ($varArray as $v) {
        echo "<script type='text/javascript' src='" . $v . "'></script>\n";
    }
}

function add_css() {
    $num = func_num_args();         //输出参数个数
    if ($num <= 0) {
        return;
    }
    $varArray = func_get_args();

    foreach ($varArray as $v) {
        echo "<link href='" . $v . "' rel='stylesheet' type='text/css'>";
    }
}

function str_cut($str, $len, $point = true) {
    if (mb_strlen($str, 'utf-8') > $len) {
        $str = mb_substr($str, 0, $len, 'utf-8');
        if ($point) {
            $str .= '...';
        }
    }
    return $str;
}

function str_explode($str) {
    $ss = explode(' ', $str);
    $result = array();
    foreach ($ss as $key => $value) {
        $ss2 = explode(',', $value);
        $result = array_merge($result, $ss2);
    }

    return $result;
}

//获取输入流 返回数组格式
function get_input_stream($field = null) {
    $content = file_get_contents("php://input");
    return json_decode($content, true);
}

//返回结果数据
function echo_json($result) {
    echo json_encode($result);
}
