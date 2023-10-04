<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_login extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->model('mdl_login');
    }

    public function index()
    {
        // $this->authorization_token->validateToken($headers['Authorization']);
        if ($this->session->userdata('user_code')) {
            // User is logged in.  Do something.
            redirect(site_url('dashboard/ctl_dashboard'));
        }

        $sql = $this->db->get('project');
        $data['project'] = $sql->row();

        $this->load->view('login', $data);
    }

    /**
     * 
     * * 
     * login staff
     * 
     */

    public function check_login()
    {
        $result = array();
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $result = $this->mdl_login->check_login();

            if ($result['error'] == 0) {
                if ($result['data']) {
                    $session = array(
                        'user_code' => $result['data']->ID,
                        'user_emp' => $result['data']->EMPLOYEE_ID,
                        'user_name' => $result['data']->NAME . " " . $result['data']->LASTNAME,

                        'level'    => '',
                        'department'    => $result['data']->DEPARTMENT,
                        'department_id' => $result['data']->DEPARTMENT_ID,
                        'section'       => $result['data']->SECTION,
                        'section_id'    => $result['data']->SECTION_ID,

                        'role'          => $result['data']->ROLES_NAME,
                        'role_level'    => $result['data']->ROLES_LEVEL,
                        'authorization'         => $result['token'],
                    );
                    $this->session->set_userdata($session);

                    // keep log
                    log_data(array('login', '', ''));
                }
            }
        }

        echo json_encode($result);
    }

    function gen_jwt()
    {
        $data = $this->input->post();
        $token = $this->authorization_token->generateToken($data);

        if (!empty($token)) {
            echo $token;
        } else {
            echo "401";
        }
    }

    function working()
    {
        $result = $this->authorization_token->validateToken();
        print_r($result);
    }
}
