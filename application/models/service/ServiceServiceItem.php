<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceServiceItem extends MY_Model {

    protected $_table = 'serviceItem';
    protected $_pk = 'item_id';
    protected $fields = array();

    function update($data, $where) {
        unset($data[$this->_pk]);
        $data = $this->_check_field($data);
        if (empty($data)) {
            return FALSE;
        }
        return parent::update($data, $where);
    }

    function add($data) {
        unset($data[$this->_pk]);
        $data = $this->_check_field($data);
        if (empty($data)) {
            return FALSE;
        }
        $data['dateline'] = __TIME;
        return parent::add($data);
    }

    function getservice($item_id) {

        if ($item = $this->getone("item_id={$item_id}")) {
            $service = K::M('service/service')->getone("service_id={$item['service_id']}");
            if (empty($service)) {
                return false;
            }
            $type = K::M('service/serviceType')->getone("type_id={$service['type_id']}");

            return array(
                'item_id' => $item_id,
                'item_name' => $item['name'],
                'service_id' => $item['service_id'],
                'service_name' => $service['name'],
                'type_id' => $service['type_id'],
                'type_name' => $type['name'],
            );
        }
        return false;
    }

}
