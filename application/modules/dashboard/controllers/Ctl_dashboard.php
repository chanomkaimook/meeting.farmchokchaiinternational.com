<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->template->set_layout('lay_dashboard');
        $this->template->title('Dashboard');
        $this->template->build('dashboard');

    }

}
