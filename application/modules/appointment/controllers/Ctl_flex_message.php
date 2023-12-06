<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_flex_message extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        // $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_event', 'mdl_staff', 'mdl_visitor'));
        $this->load->library('Flex_message');

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        // $this->load->view('line');
    }

    public function flex_message_reply()
    {
      $userId = textNull($this->input->post('userId'));
      $msg = textNull($this->input->post('msg'));
      if($userId && $msg)
      {
        $return = $this->flex_message->flex_message_reply($userId,$msg);
        echo json_encode($return);
      }
    }
    
    public function flex_message_head()
    {

      $eventData = $this->input->post();
      if(count($eventData))
      {
        $return = $this->flex_message->flex_message_head($eventData);
        echo json_encode($return);
      }

    }

    public function flex_message_action()
    {

      $eventData = $this->input->post();
      if(count($eventData))
      {
        $return = $this->flex_message->flex_message_action($eventData);
        echo json_encode($return);
      }

    }

    public function sentMessage($encodeJson, $datas)
    {
        $datasReturn = [];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $datas['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $encodeJson,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $datas['token'],
                "cache-control: no-cache",
                "content-type: application/json; charset=UTF-8",
            ),
        ));

        $response = curl_exec($curl);
        // dd($response);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $datasReturn['result'] = 'E';
            $datasReturn['message'] = $err;
        } else {
            if ($response == "{}") {
                $datasReturn['result'] = 'S';
                $datasReturn['message'] = 'Success';
            } else {
                $datasReturn['result'] = 'E';
                $datasReturn['message'] = $response;
            }
        }

        return $datasReturn;
    }
}