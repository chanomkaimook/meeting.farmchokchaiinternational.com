<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_datatable extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_calendar', 'mdl_event', 'mdl_role_focus'));
    }

    public function index()
    {
        $optionnal['where'] = array(
            'staff_owner' => 0,
        );
        $optionnal['select'] = "roles_focus.*,employee.NAME,employee.LASTNAME";
        $optionnal['join'] = true;

        $data['time'] = $this->mdl_calendar->get_time();
        $data['staff'] = $this->mdl_role_focus->get_data(null, $optionnal);

        $this->template->set_layout('lay_datatable');
        $this->template->title($this->_title);
        $this->template->build('datatable', $data);
    }

    public function get_data()
    {
        $DataTable = [];
        $dataShow = [];

        $optionnal['where'] = array(
            'event.staff_id' => 0,
        );
        $optionnal['join'] = "all";
        $optionnal['select'] = "event.*
        ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
        ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

        $dataShow[] = $this->mdl_event->get_dataShow(null, $optionnal);

        $dataall = $this->mdl_event->get_data_all(null, $optionnal);

        $optionnal_child['where'] = array(
            'staff_owner' => 0,
        );
        $optionnal_child['select'] = "roles_focus.*,employee.NAME,employee.LASTNAME";
        $optionnal_child['join'] = true;
        $child = $this->mdl_role_focus->get_data(null, $optionnal_child);

        if (count($child)) {
            foreach ($child as $sid) {
                $optionnal['where'] = array(
                    'event.staff_id' => $sid->STAFF_CHILD,
                );
                $optionnal['join'] = "all";

                $dataShow[] = $this->mdl_event->get_dataShow(null, $optionnal);
            }
        }

        if (count($dataShow)) {
            foreach ($dataShow as $index => $array) {
                foreach ($array as $key => $value) {
                    $DataTable[] = $value;
                }
            }
        }

        $result = array(
            "recordsTotal" => count($DataTable),
            "recordsFiltered" => $dataall,
            "data" => $DataTable,
        );
        echo json_encode($result);
    }

    public function insert_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $returns = $this->mdl_event->insert_data();
            echo $returns;
        }
    }

    public function update_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $returns = $this->mdl_event->update_data_calendar();
            echo $returns;
        } else {
            echo "no";
        }
    }

    public function delete_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $returns = $this->mdl_event->delete_data_calendar();
            echo $returns;
        } else {
            echo "no";
        }
    }
}
