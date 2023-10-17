<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_calendar extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_calendar', 'mdl_event', 'mdl_role_focus', 'mdl_visitor'));

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

        $this->template->set_layout('lay_calendar');
        $this->template->title($this->_title);
        $this->template->build('calendar', $data);
    }
    public function get_data()
    {
        $Calendar = [];
        $dataVal = [];
        $dataShow = [];

        $optionnal['where'] = array(
            'event.staff_id' => 0,
        );
        $optionnal['join'] = "all";
        $optionnal['select'] = "event.*
        ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
        ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

        $dataShow[] = $this->mdl_event->get_dataShow(null, $optionnal);

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
            $i = 0;
            foreach ($dataShow as $index => $item) {
                foreach ($item as $key => $value) {
                    $dataVal = (array) $value;
                    $Calendar[$i] = $dataVal;
                    $Calendar[$i]['start'] = $dataVal["DATE_BEGIN"];
                    $Calendar[$i]['end'] = $dataVal["DATE_END"];
                    $Calendar[$i]['title'] = $dataVal["EVENT_NAME"];

                    $optionnals['where'] = array(
                        'event_visitor.event_code' => $dataVal["CODE"],
                    );
                    $visitor = $this->mdl_visitor->get_dataShow(null, $optionnals);
                    if (count($visitor)) {
                        foreach ($visitor as $vis_val) {
                            $Calendar[$i]['VISITOR'][] = $vis_val->EVENT_VISITOR;
                        }
                    }
                    $i++;
                }
            }
        }
        echo json_encode($Calendar);
    }

    public function insert_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $returns = $this->mdl_event->insert_data();
            echo json_encode($returns);
        }
    }

    public function update_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $returns = $this->mdl_event->update_data();
            echo json_encode($returns);
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
