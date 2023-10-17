<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_calendar extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ตารางนัดหมาย';
        $this->load->model('mdl_calendar');

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        $data['time'] = $this->mdl_calendar->get_time();
        
        $this->template->set_layout('lay_calendar');
        $this->template->title($this->_title);
        $this->template->build('calendar',$data);
    }

}
