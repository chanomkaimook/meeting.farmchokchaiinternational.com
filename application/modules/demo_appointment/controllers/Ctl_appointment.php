<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_appointment extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ตารางนัดหมาย';
        $this->load->model('mdl_appointment');

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        $data['time'] = $this->mdl_appointment->get_time();
        
        $this->template->set_layout('lay_calendar');
        $this->template->title($this->_title);
        $this->template->build('appointment',$data);
    }

}
