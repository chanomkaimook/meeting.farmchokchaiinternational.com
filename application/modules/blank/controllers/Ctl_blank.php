<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_blank extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'blank page';

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        $this->template->set_layout('lay_main');
        $this->template->title($this->_title);
        $this->template->build('blank');
    }

}
