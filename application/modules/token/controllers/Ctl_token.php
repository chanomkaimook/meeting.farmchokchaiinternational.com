<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_token extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'blank page';
        $this->load->model(array('mdl_employee')); //'mdl_calendar', 'mdl_event', 'mdl_role_focus', 'mdl_visitor', 'mdl_rooms', ,'mdl_token'
        $this->load->libraries(array('crud_valid'));

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        // $this->template->set_layout('lay_main');
        // $this->template->title($this->_title);
        // $this->template->build('token');
        $optional['where'] = array(
            'check_line is null' => null
        );
        $data['employee'] = $this->mdl_employee->get_dataShow(null,$optional);

        $this->load->view('token',$data);

    }

    public function update_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            // $data['user_action'] = $this->my_id;
            // $code = $data['code'];

            $returns = $this->crud_valid->token($data);
            echo json_encode($returns);
        }
    }


}