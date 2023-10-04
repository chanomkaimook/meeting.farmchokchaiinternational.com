<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_register extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url', 'form');
    }

    public function index()
    {

        $this->load->view('register');
    }

    /**
     * 
     * * CRUD
     * register staff
     * 
     */
    public function insert_data_staff()
    {
        $array_text_error = array(
            'name'  => 'ชื่อ',
            'lastname'  => 'นามสกุล',
            'input_username'  => 'ชื่อรหัสผ่าน',
            'input_password'  => 'รหัสผ่าน'
        );

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $request = $this->input->post();

            $count_array = count($request);
            if ($count_array) {

                // ตรวจสอบ error
                foreach ($array_text_error as $key => $value) {
                    if (!$request[$key]) {
                        $result = array(
                            'error' => 1,
                            'txt'   => 'โปรดระบุ ' . $array_text_error[$key],
                        );

                        echo json_encode($result);
                        exit;
                    }
                }

                #
                # ตรวจสอบ username
                $sql = $this->db->from('staff')
                    ->where('username', trim($request['input_username']))
                    ->where('verify is not null', null,false)
                    ->where('status', 1)
                    ->get();
                $num = $sql->num_rows();
                if ($num) {
                    $result = array(
                        'error' => 1,
                        'txt'   => 'ไม่สามารถใช้ชื่อรหัสนี้ได้'
                    );

                    echo json_encode($result);
                    exit;
                }

                #
                # setting
                $request = $_REQUEST;
                $roles_default_id = 5;  // user value default
                $level_default_id = null;  // technician value default

                #
                # check value

                # roles
                $roles_id = trim($request['role']) ? trim($request['role']) : $roles_default_id;
                $sql_roles = $this->db->where('id', $roles_id)->get('roles');
                $row_roles = $sql_roles->row();
                $data_roles_id = $row_roles->ID;
                $data_roles_level = $row_roles->LEVEL;
                $data_roles_name = $row_roles->NAME;

                # level
                if(trim($request['level'])){
                    $level_id = trim($request['level']);
                    $sql_level = $this->db->where('id', $level_id)->get('level');
                    $row_level = $sql_level->row();
                    $data_level_id = $row_level->ID;
                    $data_level_name = $row_level->NAME;
                }else{
                    $data_level_id = null;
                    $data_level_name = null;
                }

                # 
                # employee
                $data_employee = array(
                    'name'      => trim($request['name']),
                    'lastname'  => trim($request['lastname']),
                    'lastname'  => trim($request['lastname']),
                );
                $this->db->insert('employee', $data_employee);
                $new_em_id = $this->db->insert_id();

                # level
                $data_staff = array(
                    'employee_id'       => $new_em_id,
                    'level_id'          => $data_level_id,               // value from table level 
                    'level_name'        => $data_level_name,      // value from table level 
                    'roles_id'          => $data_roles_id,               // value from table role 
                    'roles_name'        => $data_roles_name,          // value from table role 
                    'roles_level'        => $data_roles_level,              // value from table role 
                    'username'  => trim($request['input_username']),
                    'password'  => md5(trim($request['input_password'])),
                );
                $this->db->insert('staff', $data_staff);
                $new_id = $this->db->insert_id();
                if ($new_id) {

                    #
                    # update staff id on data employee
                    $data_update = array(
                        'staff_id' => $new_id
                    );
                    $this->db->where('id', $new_em_id);
                    $this->db->update('employee', $data_update);

                    #
                    # helpdesk only
                    # insert user for helpdesk
                    if($request['userfocus'] && !empty($this->session->userdata('user_code'))){
                        $explode_userfocus = explode(",",$request['userfocus']);
                        if($explode_userfocus && count($explode_userfocus)){
                            foreach($explode_userfocus as $value){
    
                                $data_rolefocus = array(
                                    'staff_child'       => trim($value),
                                    'staff_owner'       => $new_id,
                                    'user_starts'       => $this->session->userdata('user_code')
                                );
                                $this->db->insert('roles_focus', $data_rolefocus);
                            }
                        }
                    }

                    $result = array(
                        'error' => 0,
                        'data'  => $this->db->get_where('staff', array('id' => $new_id))->row(),
                        'txt'   => 'ลงทะเบียนสำเร็จ รอเจ้าหน้าที่ยืนยันสถานะเพื่อเข้าใช้งาน'
                    );

                    echo json_encode($result);
                    exit;
                }
            }



            $result = array(
                'error' => 1,
                'txt'   => 'ไม่พบข้อมูล'
            );

            echo json_encode($result);
            exit;
        }
    }
    public function update_data()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $returns = $this->mdl_register->update_data_login();

            echo $returns;
        } else {
            echo "no";
        }
    }
    public function delete_data()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $returns = $this->mdl_register->delete_data_login();

            echo $returns;
        } else {
            echo "no";
        }
    }
}
