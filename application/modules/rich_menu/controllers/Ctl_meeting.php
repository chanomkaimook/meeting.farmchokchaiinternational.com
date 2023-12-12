<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_meeting extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ข้อมูลการนัดหมายกิจกรรม';

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        // $this->template->set_layout('lay_main');
        // $this->template->title($this->_title);
        // $this->template->build('get_userId');
        $this->load->view('meeting');

    }

}
