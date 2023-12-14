<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_meeting extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ข้อมูลการนัดหมายกิจกรรม';

        $this->load->model('mdl_event');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {

        $data["btndate"] = $this->get_date();
        $data["year"] = $this->get_year();


        $this->template->set_layout('lay_rich');
        $this->template->title($this->_title);
        $this->template->build('meeting',$data);
        // $this->load->view('room');

    }

    public function get_date()
    {
        $year = date("Y");
        $date = date("Y-m-d");
        $week1 = date("W", strtotime($date));

        $date = new DateTime();
        $date->setISODate($year, $week1);
        $start = $date->format("Y-m-d");
        $date->setISODate($year, $week1, 7);
        $end = $date->format("Y-m-d");

        $result = array(
            'day' => date("Y-m-d"),
            'tmr' => date("Y-m-d",strtotime("+1 days")),
            'weekds' => $start,
            'weekde' => $end,
            'monthds' => date('Y-m-01'),
            'monthde' => date("Y-m-t"),
            /* 'yeards' => date('Y-01-01'),
            'yearde' => date("Y-12-31"), */
        );

        return $result;
    }

    public function get_year()
    {
        $optionnal["select"] = "DISTINCT YEAR(`DATE_BEGIN`) as `YEARS`,YEAR(`DATE_END`) as `YEARE`";
        $year_all = (array) $this->mdl_event->get_dataShow(null,$optionnal);

        return $year_all;
    }

}
