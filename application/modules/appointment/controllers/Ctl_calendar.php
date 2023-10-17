<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_calendar extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_calendar', 'mdl_event', 'mdl_role_focus'));

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        $data['time'] = $this->mdl_calendar->get_time();
        $optionnal['join'] = "";
        /* $data['getdata'] = $this->mdl_event->get_data(null, $optionnal);
        echo "<pre>";
        print_r($data['getdata']);
        exit; */
        $this->template->set_layout('lay_calendar');
        $this->template->title($this->_title);
        $this->template->build('calendar', $data);
    }
    public function get_data()
    {
        $dataShow = [];
        $optionnal['where'] = array(
            'event.staff_id' => 0,
        );
        $optionnal['join'] = "all";
        $optionnal['select'] = "event.*
        ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
        ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

        $dataShow[] = $this->mdl_event->get_dataShow(null, $optionnal);
        
        $owner = $this->mdl_role_focus->get_data();
        
        if (count($owner)) {
            foreach ($owner as $sid) {
                $optionnal['where'] = array(
                    'event.staff_id' => $sid->STAFF_CHILD,
                );
                $optionnal['join'] = "all";

                $dataShow[] = $this->mdl_event->get_dataShow(null, $optionnal);

            }
        }

        echo json_encode($dataShow);

        // int $id = null, array $optionnal = [], string $type = "result"

        //  $optionnal['select'] = "*";
        //  $optionnal['where'] = array(
        //      'column' => 'value',
        //      'column' => 'value',
        //      'column' => 'value',
        // )
    }

}
