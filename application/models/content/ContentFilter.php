<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ContentFilter {

    public static function addslashes($str, $force = false) {
        if (!defined('MAGIC_QUOTES_GPC')) {
            define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
        }
        if (!MAGIC_QUOTES_GPC || $force) {
            if (is_array($str)) {
                foreach ($str as $key => $val) {
                    $str[$key] = self::addslashes($val, $force);
                }
            } else {
                $str = addslashes(trim($str));
            }
        }
        return $str;
    }

    public static function stripslashes($str, $force = false) {
        if (!defined('MAGIC_QUOTES_GPC')) {
            define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
        }
        if (MAGIC_QUOTES_GPC || $force) {
            if (is_array($str)) {
                foreach ($str as $key => $val) {
                    $str[$key] = self::stripslashes($val, $force);
                }
            } else {
                $str = stripslashes($str);
            }
        }
        return $str;
    }

    public static function replace_null($str) {

        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = str_replace(array('&', '"', '<', '>', "'", '\\'), '', $val);
            }
        } else {
            $str = str_replace(array('&', '"', '<', '>', "'", '\\'), '', $str);
        }

        return $str;
    }
    
    //key val 都会被替换
    public static function replace_all_null($strs) {

        if (is_array($strs)) {
            $result = array();
            foreach ($strs as $key => $val) {
                $key2 = self::replace_all_null($key);
                $result[$key2] = self::replace_all_null($val);
            }
            return $result;
        } else {
            $strs = str_replace(array('&', '"', '<', '>', "'", '\\'), '', $strs);
        }

        return $strs;
    }

}
