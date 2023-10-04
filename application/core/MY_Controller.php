<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public $site_configs = array();
	public function __construct()
	{
		parent::__construct();

		$this->_hmvc_fixes();

		// $this->load->model('api_model');
		// if (empty($this->input->get_post('domain'))) {
		// 	exit;
		// }

		// $site = $this->api_model->find_api_key($this->input->get_post('domain'));
		// //   echo '<pre>'; print_r($site); exit;
		// if ($site) {
		// 	$this->site_configs = $site;
		// }
		// echo '<pre>'; print_r($this->site_configs);
		// echo '<pre>'; print_r($_POST); exit;
	}

	public function middleware()
	{
		$this->is_logged_in();

		$this->is_permit_in();

		$this->is_alive_in();
	}

	public function is_logged_in()
	{
		$user = $this->session->userdata('user_code');
		if (!isset($user)) {
			// User is logged in.  Do something.
			redirect(site_url('login/ctl_login'));
		}
	}


	public function is_permit_in()
	{
		$this->load->helper('My_permit');
		return check_permit();
	}
	public function is_alive_in()
	{
		$this->load->helper('My_permit');
		return check_userlive();
	}

	function _hmvc_fixes()
	{
		//fix callback form_validation		
		//https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc
		$this->load->library('form_validation');
		$this->form_validation->CI = &$this;
	}
}
