<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Flex_message
{
    // private $path_barcode = FCPATH . 'asset/image/barcode/';

    public function __construct()
    {

        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $ci->load->model(array('mdl_event', 'mdl_staff'));
    }

    public function flex_message_action($eventData)
    {
        $return['error'] = "ไม่พบข้อมูล";
        $decode = null;
        $datas = null;
        $messages = null;
        $encode = null;

        // die;
        // $eventData = $this->input->post();
        if (count($eventData)) {
            if ($eventData['TYPE_ID'] < 4) {

                $userId = explode(" ", $eventData['userId']);
                $vid = explode(" ", $eventData['vid']);
                
                $return = [];
                $return['error'] = null;
                $return['msg'] = 'สำเร็จ';
                $id = $eventData['ID'];
                $code = $eventData['CODE'];
                $head = $eventData['HEAD'];
                $head_name = $eventData['HEAD_NAME'];
                $topic_full = $eventData['TOPIC'];
                // $msg = $eventData['TYPE'];
                $detail_full = $eventData['DETAIL'];
                $role = $eventData['role'];

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

                for ($i = 0; $i < count($userId); $i++) {
                    if (!empty($userId[$i])) {

                        if ($role == "head") {
                            $msg = "แบบฟอร์มขออนุมัติการ" . $eventData['TYPE'];
                            $txt2 = "อนุมัติ";
                            $txt3 = "ไม่อนุมัติ";
                            $user_action = $head;
                        } elseif ($role == "visitor") {
                            $msg = "แบบฟอร์มเชิญเข้าร่วมการ" . $eventData['TYPE'];
                            $txt2 = "เข้าร่วม";
                            $txt3 = "ไม่เข้าร่วม";
                            $user_action = $vid[$i];
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
                              },
                              {
                              "type": "box",
                              "layout": "baseline",
                              "spacing": "sm",
                              "contents": [
                                {
                                  "type": "text",
                                  "text": "รหัสผู้ถูกเชิญ",
                                  "size": "sm",
                                  "color": "#AAAAAA",
                                  "flex": 1,
                                  "contents": []
                                },
                                {
                                  "type": "text",
                                  "text": "' . $user_action . '",
                                  "size": "sm",
                                  "color": "#666666",
                                  "flex": 1,
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
                        // $messages['to'] = null;
                        $messages['to'] = $userId[$i];
                        $messages['messages'][] = $decode;
                        $encode = json_encode($messages);
                        $this->sentMessage($encode, $datas);
                    }

                }
            }
        }
        echo json_encode($return);
    }

    public function flex_message_head($eventData)
    {
        $return['error'] = "ไม่พบข้อมูล";
        $decode = null;
        $datas = null;
        $messages = null;
        $encode = null;

        if (count($eventData)) {
            if ($eventData['TYPE_ID'] < 4) {
                $userId = $eventData['userId'];
                /* echo "-----------------------------------------------".$userId;
                die; */
                // $return = [];
                $return['error'] = null;
                $return['msg'] = 'สำเร็จ';
                $id = $eventData['ID'];
                $code = $eventData['CODE'];
                $head = $eventData['HEAD'];
                $head_name = $eventData['HEAD_NAME'];
                $topic_full = $eventData['TOPIC'];
                $msg = $eventData['TYPE'];
                $detail_full = $eventData['DETAIL'];

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

                $uri1 = "http://127.0.0.1/meeting.farmchokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&user_action=" . $eventData['user_action'];
                // $uri1 = "https://meeting.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&user_action=" . $key;
                // $uri1 = "https://booking.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&user_action=" . $key;
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
                $messages['to'] = $userId;
                $messages['messages'][] = $decode;
                $encode = json_encode($messages);
                $this->sentMessage($encode, $datas);
            }
        }

        return $return;
    }

    public function flex_message_reply($userId, $msg)
    {
        $return['error'] = "ไม่พบข้อมูล";
        if ($userId && $msg) {
            $return['error'] = null;
            $return['msg'] = 'สำเร็จ';
            // $return = [];
            $JsonData = '{
              "type": "flex",
              "altText": "' . $msg . '",
              "contents": {
                "type": "bubble",
                "body": {
                  "type": "box",
                  "layout": "vertical",
                  "contents": [
                    {
                      "type": "text",
                      "text": "' . $msg . '",
                      "size": "sm",
                      "wrap": true,
                      "weight": "regular",
                      "color": "#000000"
                    }
                  ]
                }
              }
            }';

            $decode = json_decode($JsonData, true);
            $datas['url'] = "https://api.line.me/v2/bot/message/push";
            // $datas['token'] = "02ejLbhxaoS4P7XL4JNk0jXGlVC3cXaBOGOGz4YGUahQs/87sipArCHt9AWUL+MsQBADAp4Lnn4kdT/xI8GdbpRf4msSrV85qGm/Sb3AlRrZdaDXAHMoTHa0Wb2bkQK5BpuXOIp8ZZJIiM/JYMnGZgdB04t89/1O/w1cDnyilFU=";
            $datas['token'] = "O7Om2QF6Mf6akoAWlgoaLbznke7k+Mt9sxOWz7T0o16M93/q998eecerKEw3//kkLd2yfc+YKWAdUIyu7VCCIxG//o9m9R7nhowUdKbYgWHX/dIXK/rJuvWt/rhgej1UQbn8ZiO0bTRQ+HjbNRrWjAdB04t89/1O/w1cDnyilFU=";
            $messages['to'] = $userId;
            $messages['messages'][] = $decode;
            $encode = json_encode($messages);
            $this->sentMessage($encode, $datas);
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
