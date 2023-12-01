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
        $return['error'] = "ไม่พบข้อมูล";
        // die;
        $eventData = $this->input->post();
        if (count($eventData)) {
            if ($eventData['TYPE_ID'] < 4) {

              $userId = explode(",",$eventData['userId']);
        /* print_r($userId);
        die; */
                $return['error'] = null;
                $return['msg'] = 'สำเร็จ';
                $return = [];
                $id = $eventData['ID'];
                $code = $eventData['CODE'];
                $head = $eventData['HEAD'];
                $head_name = $eventData['HEAD_NAME'];
                $topic_full = $eventData['TOPIC'];
                $msg = $eventData['TYPE'];
                $detail_full = $eventData['DETAIL'];
                $user_action = $eventData['user_action'];

                if (strlen($topic_full) > 25) {
                    $topic = substr($topic_full, 0, 25) . "...";
                } else {
                    $topic = $topic_full;
                }

                if (strlen($detail_full) > 100) {
                    $detail = substr($detail_full, 0, 100) . "...";
                } else {
                    $detail = $detail_full;
                }

                if ($eventData['DBEGIN'] == $eventData['DEND']) {
                    $date = date('d/m/Y', strtotime($eventData['DBEGIN']));
                } else {
                    $date = date('d/m/Y', strtotime($eventData['DBEGIN'])) . " - " . date('d/m/Y', strtotime($eventData['DEND']));
                }

                $time = date('H:i', strtotime($eventData['TBEGIN'])) . " - " . date('H:i', strtotime($eventData['TEND'])) . " น.";

                foreach ($userId as $key => $val) {
                    if ($user_action == $head) {
                        $txt2 = "อนุมัติ";
                        $txt3 = "ไม่อนุมัติ";
                    } else {
                        $txt2 = "เข้าร่วม";
                        $txt3 = "ไม่เข้าร่วม";
                    }

                    $uri1 = "http://127.0.0.1/meeting.farmchokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&user_action=" . $user_action;
                    $uri2 = "http://127.0.0.1/meeting.farmchokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&data=2&user_action=" . $user_action;
                    $uri3 = "http://127.0.0.1/meeting.farmchokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&data=3&user_action=" . $user_action;
                    // $uri1 = "https://meeting.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&user_action=" . $user_action;
                    // $uri2 = "https://meeting.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&data=2&user_action=" . $user_action;
                    // $uri3 = "https://meeting.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&data=3&user_action=" . $user_action;
                    // $uri1 = "https://booking.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&user_action=" . $user_action;
                    // $uri2 = "https://booking.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&data=2&user_action=" . $user_action;
                    // $uri3 = "https://booking.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&data=3&user_action=" . $user_action;
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
                              "text": "' . $msg . '",
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
                                      "text": "หัวข้อ",
                                      "size": "sm",
                                      "color": "#AAAAAA",
                                      "flex": 1,
                                      "contents": []
                                    },
                                    {
                                      "type": "text",
                                      "text": "' . $topic . '",
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
                                      "flex": 1,
                                      "contents": []
                                    },
                                    {
                                      "type": "text",
                                      "text": "' . $head_name . '",
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
                                      "text": "วันที่",
                                      "size": "sm",
                                      "color": "#AAAAAA",
                                      "flex": 1,
                                      "contents": []
                                    },
                                    {
                                      "type": "text",
                                      "text": "' . $date . '",
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
                                      "text": "เวลา",
                                      "size": "sm",
                                      "color": "#AAAAAA",
                                      "flex": 2,
                                      "contents": []
                                    },
                                    {
                                      "type": "text",
                                      "text": "' . $time . '",
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
                                "label": "' . $txt2 . '",
                                "uri": "' . $uri2 . '"
                              }
                            },
                            {
                              "type": "button",
                              "style": "secondary",
                              "action": {
                                "type": "uri",
                                "label": "' . $txt3 . '",
                                "uri": "' . $uri3 . '"
                              }
                            },
                            {
                              "type": "button",
                              "style": "link",
                              "height": "sm",
                              "action": {
                                "type": "uri",
                                "label": "ตรวจสอบข้อมูล",
                                "uri": "' . $uri1 . '"
                              }
                            }
                          ]
                        }
                      }
                  ]
                }
              }';

                    $decode = json_decode($JsonData, true);
                    $datas['url'] = "https://api.line.me/v2/bot/message/push";
                    // $datas['token'] = "02ejLbhxaoS4P7XL4JNk0jXGlVC3cXaBOGOGz4YGUahQs/87sipArCHt9AWUL+MsQBADAp4Lnn4kdT/xI8GdbpRf4msSrV85qGm/Sb3AlRrZdaDXAHMoTHa0Wb2bkQK5BpuXOIp8ZZJIiM/JYMnGZgdB04t89/1O/w1cDnyilFU=";
                    $datas['token'] = "O7Om2QF6Mf6akoAWlgoaLbznke7k+Mt9sxOWz7T0o16M93/q998eecerKEw3//kkLd2yfc+YKWAdUIyu7VCCIxG//o9m9R7nhowUdKbYgWHX/dIXK/rJuvWt/rhgej1UQbn8ZiO0bTRQ+HjbNRrWjAdB04t89/1O/w1cDnyilFU=";
                    $messages['to'] = $val;
                    $messages['messages'][] = $decode;
                    $encode = json_encode($messages);
                    $this->sentMessage($encode, $datas);
                }
            }
        }
        echo json_encode($return);
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