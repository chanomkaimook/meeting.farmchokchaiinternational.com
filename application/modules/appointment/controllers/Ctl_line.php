<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_line extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        // $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_event', 'mdl_staff', 'mdl_employee', 'mdl_visitor'));
        $this->load->libraries(array('crud_valid'));

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index($data)
    {
        $this->load->view('line', $data);
    }

    public function url_respond()
    {
        $array = $this->input->get();
        if (count($array)) {
            $data = [];
            $return = [];
            $optionnal['select'] = "event.staff_id as HEAD,event.user_start as OWN";

            $optionnal['where']['event.id'] = $array['id'];
            $optionnal['where']['event.code'] = $array['code'];

            $event_main = $this->mdl_event->get_dataShow(null, $optionnal, "row");

            $optionnals['select'] = "event_visitor.event_visitor as VISITOR";
            $optionnals['where']['event_visitor.event_id'] = $array['id'];
            $optionnals['where']['event_visitor.event_code'] = $array['code'];
            $optionnals['where']['event_visitor.event_visitor'] = $array['user_action'];
            $event_vis = (array) $this->mdl_visitor->get_dataShow(null, $optionnals,"row");

            $data['item_id'] = $array['id'];
            $data['item_code'] = $array['code'];
            $data['item_data'] = $array['data'];
            $data['user_action'] = $array['user_action'];

            if ($array['user_action'] == $event_main->HEAD && $array['user_action'] != $event_main->OWN) {
                $return = $this->crud_valid->approval($data);
            }elseif($event_vis['VISITOR']){
                $return = $this->crud_valid->invitation($data);
            }

        }
        $this->index($return);
    }

    public function get_userID()
    {
        $event_main = [];
        $event_vis = [];
        $data = [];
        $eventData = [];
        $return = [];
        $userId = [];
        $array = $this->input->post();
        if (count($array)) {
            $optionnalm['select'] = "event.type_name as TYPE,event.event_name as TOPIC,event.event_description as DETAIL,event.staff_id as HEAD,event.user_start as OWN";

            $optionnal['select'] = "event.staff_id as HEAD,event_car.DRIVER_ID as DRIVER";
            $optionnal['join'] = "all";
            $optionnal['where']['event.id'] = $array['id'];
            $optionnal['where']['event.code'] = $array['code'];

            $optionnalm['where'] = $optionnal['where'];

            $eventData = $this->mdl_event->get_dataShow(null, $optionnalm, "row");
            $event_main = $this->mdl_event->get_dataShow(null, $optionnal, "row");

            $optionnals['select'] = "event_visitor.event_visitor as VISITOR";
            $optionnals['where']['event_visitor.event_id'] = $array['id'];
            $optionnals['where']['event_visitor.event_code'] = $array['code'];
            $event_vis = (array) $this->mdl_visitor->get_dataShow(null, $optionnals);

            if ($event_vis) {
                foreach ($event_vis as $key => $value) {
                    $optionnale['select'] = 'staff.user_id as userId';
                    $optionnale['where'] = array(
                        'staff.employee_id' => $value->VISITOR,
                    );
                    $data = $this->mdl_staff->get_dataShow(null, $optionnale, "row");
                    if ($data->userId) {
                        $userId[] = $data->userId;
                    }

                }
            }

            foreach ($event_main as $key => $value) {
                $optionnale['select'] = 'staff.user_id as userId';
                $optionnale['where'] = array(
                    'staff.employee_id' => $value,
                );
                $data = $this->mdl_staff->get_dataShow(null, $optionnale, "row");
                if ($data->userId) {
                    $userId[] = $data->userId;
                }
            }

            $select['select'] = "employee.name as NAME,employee.lastname as LASTNAME";
            $emp_data = $this->mdl_employee->get_dataShow($eventData['HEAD'], $select, "row");
            $eventData['HEAD_NAME'] = $emp_data->NAME . " " . $emp_data->LASTNAME;
        }
        // print_r($userId);
        // echo json_encode($userId);
        $return = $this->line_push_message($userId, $eventData);
        echo json_encode($return);

    }

    public function line_push_message($userId = [], $eventData = [])
    {
        $return['error'] = "ไม่พบข้อมูล";
        if (count($userId) && count($eventData)) {
            $return = [];
            $head = $eventData['HEAD_NAME'];
            $topic = $eventData['TOPIC'];
            $msg = $eventData['TYPE'];
            $detail = $eventData['DETAIL'];
            /*
            {
            "type": "text",
            "text": "' . $detail . '",
            }
             */
            $uri = "https://www.google.com/?&bih=738&biw=1536&rlz=1C1CHBF_enTH1030TH1030&hl=th";
            $JsonData = '{
                "type": "flex",
                "altText": "' . $msg . '",
                "contents": {
                  "type": "carousel",
                  "contents": [
                    {
                        "type": "bubble",
                        "body": {
                          "type": "box",
                          "layout": "vertical",
                          "spacing": "md",
                          "contents": [
                            {
                              "type": "text",
                              "text": "' . $topic . '",
                              "weight": "bold",
                              "size": "xl",
                              "gravity": "center",
                              "wrap": true,
                              "contents": []
                            },
                            {
                              "type": "box",
                              "layout": "vertical",
                              "spacing": "sm",
                              "margin": "lg",
                              "contents": [
                                {
                                  "type": "box",
                                  "layout": "baseline",
                                  "spacing": "sm",
                                  "contents": [
                                    {
                                      "type": "text",
                                      "text": "เนื้อหา",
                                      "size": "sm",
                                      "color": "#AAAAAA",
                                      "flex": 1,
                                      "contents": []
                                    },
                                    {
                                      "type": "text",
                                      "text": "' . $detail . '",
                                      "size": "sm",
                                      "color": "#666666",
                                      "flex": 1,
                                      "wrap": true,
                                      "contents": []
                                    }
                                  ]
                                },
                                {
                                  "type": "box",
                                  "layout": "baseline",
                                  "spacing": "sm",
                                  "contents": [
                                    {
                                      "type": "text",
                                      "text": "นำโดย",
                                      "size": "sm",
                                      "color": "#AAAAAA",
                                      "flex": 2,
                                      "contents": []
                                    },
                                    {
                                      "type": "text",
                                      "text": "' . $head . '",
                                      "size": "sm",
                                      "color": "#666666",
                                      "flex": 2,
                                      "wrap": true,
                                      "contents": []
                                    }
                                  ]
                                }
                              ]
                            }
                          ]
                        },
                        "footer": {
                          "type": "box",
                          "layout": "vertical",
                          "spacing": "md",
                          "contents": [
                            {
                              "type": "button",
                              "style": "primary",
                              "action": {
                                "type": "uri",
                                "label": "ตกลง",
                                "uri": "' . $uri . '"
                              }
                            },
                            {
                              "type": "button",
                              "style": "secondary",
                              "action": {
                                "type": "uri",
                                "label": "ปฏิเสธ",
                                "uri": "' . $uri . '"
                              }
                            }
                          ]
                        }
                      }
                  ]
                }
              }';
            /* "contents": [
            {
            "type": "button",
            "action": {
            "type": "uri",
            "label": "ดูข้อมูล",
            "uri": "' . $uri . '"
            },
            "color": "#E30614",
            "height": "sm",
            "style": "primary"
            },
            {
            "type": "button",
            "action": {
            "type": "uri",
            "label": "ดูข้อมูล",
            "uri": "' . $uri . '"
            },
            "color": "#E30614",
            "height": "sm",
            "style": "primary"
            }
            ]
            }
            ] */
            foreach ($userId as $val) {
                $decode = json_decode($JsonData, true);
                $datas['url'] = "https://api.line.me/v2/bot/message/push";
                // $datas['token'] = "02ejLbhxaoS4P7XL4JNk0jXGlVC3cXaBOGOGz4YGUahQs/87sipArCHt9AWUL+MsQBADAp4Lnn4kdT/xI8GdbpRf4msSrV85qGm/Sb3AlRrZdaDXAHMoTHa0Wb2bkQK5BpuXOIp8ZZJIiM/JYMnGZgdB04t89/1O/w1cDnyilFU=";
                $datas['token'] = "O7Om2QF6Mf6akoAWlgoaLbznke7k+Mt9sxOWz7T0o16M93/q998eecerKEw3//kkLd2yfc+YKWAdUIyu7VCCIxG//o9m9R7nhowUdKbYgWHX/dIXK/rJuvWt/rhgej1UQbn8ZiO0bTRQ+HjbNRrWjAdB04t89/1O/w1cDnyilFU=";
                $messages['to'] = $val;
                $messages['messages'][] = $decode;
                $encode = json_encode($messages);
                $return[] = $this->sentMessage($encode, $datas);
            }
        }
        return $return;
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