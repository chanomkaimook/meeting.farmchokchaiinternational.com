<?php
error_reporting(E_ALL & ~E_NOTICE);

#
# role    | value
#
# 1       | administrator
# 1       | VIP
# 2       | supervisor
# 3       | operator
# 4       | user
# 5       | guest

/**
 * 
 */
function check_session(string $module_name = null)
{
  $ci = &get_instance();
  $ci->load->database();
  # code...

  // echo "<pre>";
  // print_r($ci->session->userdata());exit;
  $role = $ci->session->userdata('role');

  $module = $module_name ? $module_name : $ci->uri->segment(1);
  $result = false;

  // echo $module;

  if ($ci->session->userdata('role_level') <= 1) {
    $result = true;
  } else {
    #
    # convert json data permit to array
    $data_permit = json_decode($ci->session->userdata('permit'));

    if (is_numeric(array_search($module, $data_permit)) && $ci->session->userdata('permit')) {
      $result = true;
    }
  }



  return $result;
}

function check_userlive()
{
  $ci = &get_instance();
  $ci->load->database();
  # code...
  $userid = $ci->session->userdata('user_code');

  $sql = $ci->db->from('staff')
    ->where('id', $userid)
    ->where('(status !=1 or verify is null)', null, false)
    ->get();
  $num = $sql->num_rows();
  if ($num) {
    redirect(site_url('error_permit'));
  }
}

function check_permit()
{
  $ci = &get_instance();
  $ci->load->database();
  # code...

  $result = check_session();

  if (!$result) {
    redirect(site_url('error_permit'));
  }
}

function check_permit_menu(string $module = null)
{
  $result = check_session($module);
  $css_name = '';

  if (!$result) {
    $css_name = 'd-none';
  }

  return $css_name;
}

function check_operator()
{
  $ci = &get_instance();
  $ci->load->database();
  # code...

  $result = false;

  if ($ci->session->userdata('role_level') >= 20 && $ci->session->userdata('role_level') <= 29) {
    $result = true;
    return $result;
  }
}

function check_supervisor()
{
  $ci = &get_instance();
  $ci->load->database();
  # code...

  $result = false;

  if ($ci->session->userdata('role_level') <= 19) {
    $result = true;
    return $result;
  }
}

function check_admin()
{
  $ci = &get_instance();
  $ci->load->database();
  # code...

  $result = false;

  if ($ci->session->userdata('role_level') <= 1) {
    $result = true;
    return $result;
  }
}

function is_Mobile()
{
  $ci = &get_instance();
  $ci->load->database();
  # code...

  include FCPATH . "mobile_detect.php";
  $ci->_detect = new Mobile_Detect();

  return $ci->_detect->isMobile();
}

function check_helpdesk()
{
  $ci = &get_instance();
  $ci->load->database();
  # code...

  $result = false;

  if ($ci->session->userdata('role_level') == 11) {
    $result = true;
    return $result;
  }
}
