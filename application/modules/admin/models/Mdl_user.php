<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_user extends CI_Model

{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_data_staff()
    {
        $id = $this->input->get('id');

        $sql = $this->db->select('
            employee.NAME as NAME,
            employee.LASTNAME as LASTNAME,
            employee.EMAIL as EMAIL,
            employee.POSITION as POSITION,
            employee.DEPARTMENT as DEPARTMENT,
            employee.SECTION as SECTION,
            concat(employee.NAME," ",employee.LASTNAME) as staff_name,
            staff.ID as ID,
            staff.USERNAME as USERNAME,
            staff.VERIFY as VERIFY,
            staff.DATE_START as DATE_START,
            staff.DATE_UPDATE as DATE_UPDATE,
        ')
            ->join('employee', 'staff.employee_id = employee.id', 'left')
            ->where('staff.verify is not null', null, false)
            ->where('staff.status', 1)
            ->where('staff.id !=', 1)
            ->order_by('staff.id', 'desc');

        if ($id) {
            $sql->where('staff.id', $id);
        }

        $query = $sql->get('staff');

        if (!$id) {
            $result = $query->result();
        } else {
            $result = $query->row();
        }

        return $result;
    }

    /* public function get_user()
    {
        $id = $this->input->get('id');

        $query = $this->db->select('*')
            ->where('id', $id)
            ->where('status', 1)
            ->get('staff');

        return $query->row();
    } */

    public function update_user()
    {
        $date_update = date('Y-m-d H:i:s');
        $user_update = $this->session->userdata('user_code');

        $roles_id = $this->input->post('role');
        $sql_roles = $this->db->where('id', $roles_id)->get('roles');

        $row_roles = $sql_roles->row();
        $roles_name = $row_roles->NAME;
        $roles_level = $row_roles->LEVEL;

        $data_staff = array(
            'ROLES_ID' => $this->input->post('role'),
            'ROLES_NAME' => $roles_name,
            'ROLES_LEVEL' => $roles_level,
            'DATE_UPDATE' =>   $date_update,
            'USER_UPDATE' =>   $user_update,
        );

        $result = array();

        $id = $this->input->post('id');

        if ($id) {
            $sql_staff = $this->db->select('employee_id')
                ->where('id', $id)
                ->get('staff');
            $row_staff = $sql_staff->row();
            $employee_id = $row_staff->employee_id;

            $data_employee = array(
                'NAME' => trim($this->input->post('name')),
                'LASTNAME' => trim($this->input->post('lastname')),
                'DATE_UPDATE' =>   $date_update,
                'USER_UPDATE' =>   $user_update,
            );
            $this->db->where('id', $employee_id);
            $this->db->update('employee', $data_employee);

            $this->db->where('id', $id);
            $this->db->update('staff', $data_staff);

            #
            # helpdesk only
            # insert user for helpdesk
            # if role = 8 (helpdesk) will clear roles_focus
            if (trim($this->input->post('role')) == 8) {
                $this->db->delete('roles_focus',array('staff_owner'=>$id));

                $userfocus = trim($this->input->post('userfocus'));
                if ($userfocus) {
                    $explode_userfocus = explode(",", $userfocus);
                    foreach ($explode_userfocus as $value) {

                        $data_rolefocus = array(
                            'staff_child'       => trim($value),
                            'staff_owner'       => $id,
                            'user_starts'       => $this->session->userdata('user_code')
                        );
                        $this->db->insert('roles_focus', $data_rolefocus);
                    }
                }
            }

            // keep log
            log_data(array('update user', 'update', $this->db->last_query()));

            // insert permit_control
            $this->load->model('mdl_permit');
            $this->mdl_permit->update_data($id);

            $result = array(
                'role' =>   $data_staff['ROLE'],
                'name' =>   $data_employee['NAME'],
                'last_name' =>   $data_employee['LASTNAME'],

            );
        }

        return $result;
    }

    public function delete_user()
    {
        $data_array = array(
            'ID' => $this->input->post('id'),
            'DATE_UPDATE' =>   date('Y-m-d H:i:s'),
            'STATUS' =>   '0',

        );

        if ($this->input->post('id')) {
            $id = $data_array['ID'];

            $this->db->where('id', $id);
            $this->db->update('staff', $data_array);

            // keep log
            log_data(array('delete', 'update', $this->db->last_query()));

            $result = array(
                'error' =>   0,
                'text' => 'ลบสำเร็จแล้ว',
                'id' => $data_array['ID'],
            );
        } else {
            $result = array(
                'error' =>   1,
                'text' => 'ไม่พบ ID',
                'id' => null,
            );
        }

        return $result;
    }
}
