<?php

class Session {

    protected $mcache = null;
    public $_SESSION = array();
    protected $activated = false;
    public $SSID = null;

    public function __construct() {
        $this->SSID = 'session.' . K::L('System/Cookie')->GUID;
        $this->start();
    }

    public function start() {
        if (!$this->activated) {
            session_start();
            $this->_SESSION = &$_SESSION;
            $this->SSID = session_id();
            $this->_SESSION['SSID'] = &$this->SSID;
            register_shutdown_function(array($this, 'update'));
        }
        return $this;
    }

    public function set($key, $val = null) {
        if (is_array($key) && $val === null) {
            $this->_SESSION = array_merge($this->_SESSION, $key);
        } else {
            $this->_SESSION[$key] = $val;
        }
    }

    public function get($key) {
        return isset($this->_SESSION[$key]) ? $this->_SESSION[$key] : null;
    }

    public function delete($k) {
        unset($this->_SESSION[$k]);
    }

    public function clean() {
        $this->_SESSION = array();
        $this->isclean = true;
    }

    public function fetch_all() {
        return $this->_SESSION;
    }

    public function update() {
        
    }

}
