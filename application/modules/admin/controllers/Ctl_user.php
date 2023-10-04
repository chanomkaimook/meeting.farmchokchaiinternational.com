<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_user extends MY_Controller
{
    public $test;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_user');
        $this->load->model('mdl_register');
        $this->load->model('mdl_staff');
        $this->load->model('mdl_role_focus');

        $this->middleware();
    }

    public function index()
    {
        #
        # session
        /* $user_level = $this->session->userdata('role_level');

        $role = $this->db->where('level >=',$user_level)->get('roles');
        $data['role'] = $role->result();

        $optional['select'] = "
        employee.name as MEMBER_NAME,
        employee.lastname as MEMBER_LASTNAME,
        staff.id as STAFF_ID,
        ";

        $level = $this->db->get('level');
        $data['level'] = $level->result(); */

        $data['role'] = "";
        $data['level'] = "";
        $this->template->set_layout('lay_datatable');
        $this->template->title('ผู้ใช้งาน');
        $this->template->build('users',$data);
    }

    public function fetch_data()
    {
        $this->load->helper('my_date');
        $data = $this->mdl_user->get_data_staff();

        $icon_head = '<i class="mdi mdi-star text-warning mdi-18px" title="verified user"></i>';

        $data_result = [];
        if ($data) {
            foreach ($data as $row) {
                #
                # check level
                # 1 = operator
                if($row->LEVEL_ID == 1){
                    $level_name = $row->LEVEL_NAME;
                }else{
                    $level_name = $icon_head.$row->LEVEL_NAME;
                }

                $sub_data = [];

                $date_start = toThaiDateTimeString($row->DATE_START, 'datetime');
                $date_update = $row->DATE_UPDATE ? toThaiDateTimeString($row->DATE_UPDATE, 'datetime') : "";

                $sub_data['ID'] = $row->ID;
                $sub_data[] = $row->ROLES_NAME;
                $sub_data[] = $level_name;
                $sub_data[] = $row->NAME;
                $sub_data[] = $row->LASTNAME;
                $sub_data[] = $row->USERNAME;
                $sub_data[] = $date_start;
                $sub_data[] = $date_update;
                $sub_data[] = $row->VERIFY;

                $data_result[] = $sub_data;
            }
        }
        $result = array(
            'data' => $data_result
        );

        echo json_encode($result);
    }

    public function get_user()
    {
        $data = $this->mdl_user->get_data_staff();
        $data_role_focus = $this->mdl_role_focus->get_data();
        $result = array(
            'data' => $data,
            'data_role_focus' => $data_role_focus
        );
        echo json_encode($result);
    }

    public function update_user()
    {
        $data = $this->mdl_user->update_user();
        $result = array(
            'data' => $data
        );

        echo json_encode($result);
    }

    public function delete_user()
    {
        $data = $this->mdl_user->delete_user();
        $result = array(
            'data' => $data
        );

        echo json_encode($result);
    }
}
