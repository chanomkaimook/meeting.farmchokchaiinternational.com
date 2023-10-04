<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mdl_login extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authorization_token');
    }

    public function check_login()
    {
        if (trim($this->input->post('user_name')) && trim($this->input->post('user_password'))) {
            $user_name = trim($this->input->post('user_name'));
            $user_password = md5(trim($this->input->post('user_password')));

            $sql = $this->db->select('
                employee.ID as EMPLOYEE_ID,
                employee.NAME as NAME,
                employee.LASTNAME as LASTNAME,
                employee.DEPARTMENT as DEPARTMENT,
                employee.SECTION as SECTION,

                staff.ID as ID,
                staff.USERNAME as USERNAME,
                staff.ROLES_ID as ROLES_ID,
                staff.DATE_START as DATE_START,
                section.ID as SECTION_ID,
                department.ID as DEPARTMENT_ID,
            ')
                ->join('employee', 'staff.employee_id = employee.id', 'left')
                ->join('section', 'section.name = employee.section', 'left')
                ->join('department', 'department.name = employee.department', 'left')
                ->where('staff.username', $user_name)
                ->where('staff.password', $user_password)
                ->where('staff.verify is not null',null,false)
                ->where('staff.status', 1)
                ->get('staff');
            $number = $sql->num_rows();  //num_rows() นับจำนวนแถว

            if ($number == 1) {
                $row = $sql->row();

                $staff_id = $row->ID;

                $sql_permit = $this->db->select('*')
                    ->from('permit_control')
                    ->where('staff_id', $staff_id)
                    ->where('status_offview is null', null, false);

                $query_permit = $sql_permit->get();
                $num_permit = $query_permit->num_rows();

                $permit_json = "";

                if ($num_permit) {
                    $permit_allow = [];
                    $permit_ban = [];
                    /* foreach ($query_permit->result() as $row_permit) {

                        #
                        # select permit from json data 
                        # convert to array
                        $permit_name = $row_permit->permit_name;

                        if($permit_name){
                            $json = json_decode($permit_name);
                            if (count($json->data)) {
                                foreach ($json->data as $key => $value) {
                                    $permit_allow[] = $value;
                                }
                            }
                        }

                        # select permit bane from json data
                        $permit_name_ban = $row_permit->permit_name_ban;

                        if($permit_name_ban){
                            $json_bane = json_decode($permit_name_ban);
                            if (count($json_bane->data)) {
                                foreach ($json_bane->data as $key => $value) {
                                    $permit_ban[] = $value;
                                }
                            }
                        }
                    } */

                    #
                    # fill data ban out
                    $permit = array_values(array_diff($permit_allow,$permit_ban));

                    #
                    # set permit convert to json data
                    $permit_json = json_encode($permit);

                    
                }
                $array = array(
                    'permit'    => '123456789'
                );
                
                if (strnatcmp($user_name, $row->USERNAME) == 0) {

                    $result = array(
                        'error' => 0,
                        'data' => $sql->row(),
                        'permit' => $permit_json,
                        'token' => $this->authorization_token->generateToken($array)
                    );
                } else {
                    $result = array(
                        'error' => 1,
                        'text' => 'ชื่อผู้ใช้ ไม่ถูกต้อง',
                        'data' => ''
                    );
                }
            } else {
                $result = array(
                    'error' => 1,
                    'text' => 'ไม่พบข้อมูล',
                    'data' => ''
                );
            }
        } else {
            $result = array(
                'error' => 1,
                'text' => 'กรุณากรอกข้อมูลให้ครบ',
                'data' => ''
            );
        }

        return $result;
    }
}
