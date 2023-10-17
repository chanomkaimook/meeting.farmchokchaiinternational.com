<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mdl_appointment extends CI_Model

{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_time()
    {
        $sql = $this->db->select('*')
            ->from('time')
            ->get();

        $result = $sql->result();

        $return = [];

        foreach ($result as $val) {
            $array["ID"] = $val->ID;
            $array["START"] = $val->START;
            $array["END"] = $val->END;

            $return[] = $array;
        }

        return $return;
    }
}
