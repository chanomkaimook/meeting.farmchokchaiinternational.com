<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_permit extends CI_Model

{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * insert data on permit_control
     *
     * @param integer|null $item_id = staff_id
     * @return void
     */
    public function insert_data(int $item_id = null)
    {
        $result = array(
            'error' => 1,
            'txt'   => ''
        );

        if ($item_id) {

            // setting
            $role_id = '';
            $role_name = '';
            $permit_name = '';

            $sql = $this->db->select('
            staff.roles_id as roles_id,
            staff.roles_name as roles_name,
            roles_control.pages as pages,
            ')
                ->from('staff')
                ->join('roles_control', 'staff.roles_id=roles_control.id', 'left')
                ->where('staff.id', $item_id);
            $query = $sql->get();
            $num = $query->num_rows();
            if ($num) {
                $row = $query->row();

                $role_id = $row->roles_id;
                $role_name = $row->roles_name;
                $permit_name = $row->pages;
            }

            # level
            $data = array(
                'staff_id'       => $item_id,
                'role_id'        => $role_id,
                'role_name'      => $role_name,
                'permit_name'      => $permit_name,
                'user_starts'      => $this->session->userdata('code'),

            );
            $this->db->insert('permit_control', $data);
            $new_id = $this->db->insert_id();
            if ($new_id) {
                // keep log
                log_data(array('insert permit', 'insert', $this->db->last_query()));

                $result = array(
                    'error' => 0,
                    'txt'   => ''
                );
            }
        }

        return $result;
    }

    /**
     * update data permit_control
     *
     * @param integer|null $item_id = staff_id
     * @return void
     */
    public function update_data(int $item_id = null)
    {
        $result = array(
            'error' => 1,
            'txt'   => ''
        );

        if ($item_id) {

            // setting
            $role_id = '';
            $role_name = '';
            $permit_name = '';

            $sql = $this->db->select('
            staff.roles_id as roles_id,
            staff.roles_name as roles_name,
            roles_control.pages as pages,
            ')
                ->from('staff')
                ->join('roles_control', 'staff.roles_id=roles_control.id', 'left')
                ->where('staff.id', $item_id);
            $query = $sql->get();
            $num = $query->num_rows();
            if ($num) {
                $row = $query->row();

                $role_id = $row->roles_id;
                $role_name = $row->roles_name;
                $permit_name = $row->pages;
            }

            # level
            $data = array(
                'role_id'        => $role_id,
                'role_name'      => $role_name,
                'permit_name'      => $permit_name,

                'date_update'      => date('Y-m-d H:i:s'),
                'user_update'      => $this->session->userdata('code'),
            );

            $this->db->where('staff_id', $item_id);
            $this->db->update('permit_control', $data);
            $new_id = $this->db->insert_id();
            if ($new_id) {
                // keep log
                log_data(array('update permit', 'update', $this->db->last_query()));

                $result = array(
                    'error' => 0,
                    'txt'   => ''
                );
            }
        }

        return $result;
    }
}
