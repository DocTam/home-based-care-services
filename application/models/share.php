<?php

/**
 * 公共model
 */
require_once(CIPATH . 'model/Common_model.php');

class Share extends Common_model {

    function __construct() {
        parent::__construct();
    }

	//将 ' \ " # -- 替换为空
    function replace_null($content) {
        return str_replace(array("'", '"', '\\', '#', '--'), '', $content);
    }
}

?>