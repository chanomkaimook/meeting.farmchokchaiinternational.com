<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mdl_datatable extends CI_Model

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

    public function get_datatable($array)
    {
        $id = $this->session->userdata('user_code');
        $emp_id = $this->session->userdata('user_emp');
        $date = $array['date'];
        $time = $array['time'];
        $status = $array['status'];
        // $visitor = $array['visitor'];


        $sql = $this->db->select('event.*,employee.emp_name as name,employee.emp_lastname as lastname,employee.id as emp_id')
            ->from('staff')
            ->join('event', 'event.staff_id=staff.id', 'left')
            ->join('employee', 'staff.emp_id=employee.id', 'left')
            ->where('event.staff_id', $id)
            ->where('event.status', 1)
            ->where('employee.status', 1)
            ->order_by('event.id DESC');
        // ->where('(staff.id =' . $id . ' or staff.owner1=' . $emp_id . ' or staff.owner2=' . $emp_id . ' or staff.owner3=' . $emp_id . ')')

        if ($date && $time && $status) { // && $visitor
            $sql->where('(event.date_start = "' . $date . '")', null, false);
            $sql->where('(event.time_start = "' . $time . '")', null, false);
            $sql->where('(event.status = "' . $status . '")', null, false);
            // $sql->where('(event.user_create = "' . $visitor . '")', null, false);
        } else {

            if (!$date && !$time && !$status) { //&& !$visitor 
            }

            if ($date) {
                $sql->where('(event.date_start = "' . $date . '")', null, false);
            }

            if ($time) {
                $sql->where('(event.time_start = "' . $time . '")', null, false);
            }

            if ($status) {
                $sql->where('(event.status = "' . $status . '")', null, false);
            }

            /* if ($visitor) {
                $sql->where('(event.user_create = "' . $visitor . '")', null, false);
            } */
        }

        $sql_get = $sql->get();
        $query = $sql_get->result();

        $datatable_result = [];

        foreach ($query as $row) {

            $sql_visitor = $this->db->select('*')
                ->where('event_id', $row->ID)
                ->get('event_visitor')
                ->result();

            $visitor = [];
            foreach ($sql_visitor as $vst) {
                $visitor[]['ID'] = $vst->event_visitor;
                $visitor[]['FULNAME'] = $vst->event_visitor;
                $visitor[]['STATUS COMPLETE'] = $vst->event_visitor;
            }

            $item = [];
            $item['ID'] = $row->ID;
            $item['EMP_ID'] = $row->STAFF_ID;
            $item['EVENT_NAME'] = $row->EVENT_NAME;
            $item['EVENT_DESCRIPTION'] = $row->EVENT_DESCRIPTION;
            $item['DATE_CREATE'] = date('Y-m-d', strtotime($row->DATE_CREATE));
            $item['DATE_START'] = $row->DATE_START;
            // $item['DATE_END'] = $row->DATE_END;
            $item['TIME_START'] = date('H:i', strtotime($row->TIME_START));
            $item['TIME_END'] = date('H:i', strtotime($row->TIME_END));
            $item['STATUS'] = $row->STATUS_COMPLETE;
            $item['VISITOR'] = $visitor;
            $item['NAME'] = $row->name;
            $item['LASTNAME'] = $row->lastname;
            $item['FULLNAME'] = $row->name . " " . $row->lastname;

            $datatable_result[] = $item;
        }
        $result = array(
            "recordsTotal" => count($datatable_result),
            "recordsFiltered" => count($datatable_result),
            "data" => $datatable_result
        );

        return $result;
    }
}
