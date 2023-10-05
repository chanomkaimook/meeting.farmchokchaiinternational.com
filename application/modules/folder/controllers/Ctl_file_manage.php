<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_file_manage extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'File management';

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        $this->template->set_layout('lay_datatable');
        $this->template->title($this->_title);
        $this->template->build('file_manage');
    }

}
