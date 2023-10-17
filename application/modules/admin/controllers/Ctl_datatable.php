<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_datatable extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ตารางนัดหมาย';
        $this->load->model('mdl_datatable');

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        $data['time'] = $this->mdl_datatable->get_time();
        
        $this->template->set_layout('lay_datatable');
        $this->template->title($this->_title);
        $this->template->build('datatable',$data);
    }

    public function get_datatable()
    {
        $data_array = array(
            'date' => $this->input->get('date'),
            'time' => $this->input->get('time'),
            'visitor' => $this->input->get('visitor'),
            'status' => $this->input->get('status'),
        );

        $datatable = $this->mdl_datatable->get_datatable($data_array);

        echo json_encode($datatable);
    }

}
