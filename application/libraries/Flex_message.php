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
        // $return = $this->sentMessage();
        // return $return;
        $return['error'] = "ไม่พบข้อมูล";

        if (count($eventData)) {
            if ($eventData['TYPE_ID'] < 4) {
                $userId = [];

                $return = [];

                $id = $eventData['ID'];
                $code = $eventData['CODE'];
                $head = $eventData['HEAD'];
                $head_name = $eventData['HEAD_NAME'];
                $topic_full = $eventData['TOPIC'];
                $detail_full = $eventData['DETAIL'];
                $role = $eventData['role'];
                $user_action = '';

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

                if ($role == "head") {
                    $userId[0] = $eventData['userId'];
                    $msg = "แบบฟอร์มขออนุมัติการ" . $eventData['TYPE'];
                    $txt2 = "อนุมัติ";
                    $txt3 = "ไม่อนุมัติ";
                    $user_action = $head;
                } elseif ($role == "visitor") {
                    $userId = explode(" ", $eventData['userId']);
                    $msg = "แบบฟอร์มเชิญเข้าร่วมการ" . $eventData['TYPE'];
                    $txt2 = "เข้าร่วม";
                    $txt3 = "ไม่เข้าร่วม";
                }
                for ($i = 0; $i < count($userId); $i++) {
                    $JsonData = "";
                    if (!empty($userId[$i])) {
                        if ($eventData['vid']) {
                            $vid = explode(" ", $eventData['vid']);
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
                          "to": "' . $userId[$i] . '",
                          "messages": [
                              {
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
                                                          "wrap": true
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
                                                                          "flex": 1
                                                                      },
                                                                      {
                                                                          "type": "text",
                                                                          "text": "' . $topic_full . '",
                                                                          "size": "sm",
                                                                          "color": "#666666",
                                                                          "flex": 1,
                                                                          "wrap": true
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
                                                                          "flex": 1
                                                                      },
                                                                      {
                                                                          "type": "text",
                                                                          "text": "' . $detail_full . '",
                                                                          "size": "sm",
                                                                          "color": "#666666",
                                                                          "flex": 1,
                                                                          "wrap": true
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
                                                                          "flex": 1
                                                                      },
                                                                      {
                                                                          "type": "text",
                                                                          "text": "' . $head_name . '",
                                                                          "size": "sm",
                                                                          "color": "#666666",
                                                                          "flex": 1,
                                                                          "wrap": true
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
                                                                          "flex": 1
                                                                      },
                                                                      {
                                                                          "type": "text",
                                                                          "text": "' . $date . '",
                                                                          "size": "sm",
                                                                          "color": "#666666",
                                                                          "flex": 1,
                                                                          "wrap": true
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
                                                                          "flex": 2
                                                                      },
                                                                      {
                                                                          "type": "text",
                                                                          "text": "' . $time . '",
                                                                          "size": "sm",
                                                                          "color": "#666666",
                                                                          "flex": 2,
                                                                          "wrap": true
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
                              }
                          ]
                      }';
                        // $decode = json_decode($JsonData);
                        // echo $JsonData;
                        $datas['url'] = "https://api.line.me/v2/bot/message/push";
                        // $datas['token'] = "sSuLH67pPta+bU11+f+aYHBF+fICPUduaMbR6MWQ6Cc7xPbY2PEwqyXw7nkakXRDnDgR8mvZ0oE29XFqU8Ltg8Aov7E+U718d+DyuOfpJBimnqTuN8O6Be9/S5l7vebvBJM+AUbBSoneqyTMzhFYaQdB04t89/1O/w1cDnyilFU="; // Chanel M
                        $datas['token'] = "BDFZcdubjHuFoyWRYgRfBCf0c1ZQZMhJwOsdhfVmO/ymoW4PwoOFOP4QPFWkxTRkdgeDZQfCdZyHyw7+qR0toFR9Hm+OJ/eqrpp1vwYs/8zM0zQ3JVR3Ll6yZrQIT1y0Bh7GZeBvhM0Nb43b5NCIZgdB04t89/1O/w1cDnyilFU="; // Chanel S
                        // $datas['token'] = "O7Om2QF6Mf6akoAWlgoaLbznke7k+Mt9sxOWz7T0o16M93/q998eecerKEw3//kkLd2yfc+YKWAdUIyu7VCCIxG//o9m9R7nhowUdKbYgWHX/dIXK/rJuvWt/rhgej1UQbn8ZiO0bTRQ+HjbNRrWjAdB04t89/1O/w1cDnyilFU="; // Chanel O

                        $return = $this->sentMessage($JsonData, $datas);

                        $return['error'] = null;
                        $return['msg'] = 'สำเร็จ';
                        $return['id'] = $id;
                        $return['sid'] = $user_action;
                        $return['user_action'] = $user_action;
                    }

                }

            }
        }
        return $return;
    }

    public function flex_message_head($eventData)
    {
        $return['error'] = "ไม่พบข้อมูล";
// print_r($eventData);die;
        if (count($eventData)) {
            if ($eventData['TYPE_ID'] < 4) {
                $userId = $eventData['userId'];
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

                // $uri1 = "http://127.0.0.1/meeting.farmchokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&user_action=" . $eventData['user_action'];
                // $uri1 = "https://meeting.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&user_action=" . $eventData['user_action'];
                $uri1 = "https://booking.chokchaiinternational.com/appointment/ctl_line_data?id=" . $id . "&code=" . $code . "&user_action=" . $eventData['user_action'];
                $JsonData = '{
                  "to": "' . $userId . '",
                  "messages": [
                    {
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
                                  "wrap": true
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
                                          "flex": 1
                                        },
                                        {
                                          "type": "text",
                                          "text": "' . $topic_full . '",
                                          "size": "sm",
                                          "color": "#666666",
                                          "flex": 1,
                                          "wrap": true
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
                                          "flex": 1
                                        },
                                        {
                                          "type": "text",
                                          "text": "' . $detail . '",
                                          "size": "sm",
                                          "color": "#666666",
                                          "flex": 1,
                                          "wrap": true
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
                                          "flex": 1
                                        },
                                        {
                                          "type": "text",
                                          "text": "' . $head_name . '",
                                          "size": "sm",
                                          "color": "#666666",
                                          "flex": 1,
                                          "wrap": true
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
                                          "flex": 1
                                        },
                                        {
                                          "type": "text",
                                          "text": "' . $date . '",
                                          "size": "sm",
                                          "color": "#666666",
                                          "flex": 1,
                                          "wrap": true
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
                                          "flex": 2
                                        },
                                        {
                                          "type": "text",
                                          "text": "' . $time . '",
                                          "size": "sm",
                                          "color": "#666666",
                                          "flex": 2,
                                          "wrap": true
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
                    }
                  ]
                }';
// echo $JsonData;
                $datas['url'] = "https://api.line.me/v2/bot/message/push";
                // $datas['token'] = "sSuLH67pPta+bU11+f+aYHBF+fICPUduaMbR6MWQ6Cc7xPbY2PEwqyXw7nkakXRDnDgR8mvZ0oE29XFqU8Ltg8Aov7E+U718d+DyuOfpJBimnqTuN8O6Be9/S5l7vebvBJM+AUbBSoneqyTMzhFYaQdB04t89/1O/w1cDnyilFU="; // Chanel M
                $datas['token'] = "BDFZcdubjHuFoyWRYgRfBCf0c1ZQZMhJwOsdhfVmO/ymoW4PwoOFOP4QPFWkxTRkdgeDZQfCdZyHyw7+qR0toFR9Hm+OJ/eqrpp1vwYs/8zM0zQ3JVR3Ll6yZrQIT1y0Bh7GZeBvhM0Nb43b5NCIZgdB04t89/1O/w1cDnyilFU="; // Chanel S
                // $datas['token'] = "O7Om2QF6Mf6akoAWlgoaLbznke7k+Mt9sxOWz7T0o16M93/q998eecerKEw3//kkLd2yfc+YKWAdUIyu7VCCIxG//o9m9R7nhowUdKbYgWHX/dIXK/rJuvWt/rhgej1UQbn8ZiO0bTRQ+HjbNRrWjAdB04t89/1O/w1cDnyilFU="; // Chanel O

                $return = $this->sentMessage($JsonData, $datas);

                $return['error'] = null;
                $return['msg'] = 'สำเร็จ';
                $return['id'] = $id;
                $return['sid'] = $head;
                $return['user_action'] = $eventData['user_action'];

            }
        }

        return $return;
    }

    public function flex_message_reply($eventData)
    {
        $return['error'] = "ไม่พบข้อมูล";
        if ($eventData && count($eventData)) {
            $return['error'] = null;
            $return['msg'] = 'สำเร็จ';
            $JsonData = '{
              "to": "' . $eventData['userId'] . '",
              "messages":  [
               {
                          "type": "text",
                          "text": "' . $eventData['msg'] . '"
                        }
              ]
            }';

            $datas['url'] = "https://api.line.me/v2/bot/message/push";
            // $datas['token'] = "sSuLH67pPta+bU11+f+aYHBF+fICPUduaMbR6MWQ6Cc7xPbY2PEwqyXw7nkakXRDnDgR8mvZ0oE29XFqU8Ltg8Aov7E+U718d+DyuOfpJBimnqTuN8O6Be9/S5l7vebvBJM+AUbBSoneqyTMzhFYaQdB04t89/1O/w1cDnyilFU="; // Chanel M
            $datas['token'] = "BDFZcdubjHuFoyWRYgRfBCf0c1ZQZMhJwOsdhfVmO/ymoW4PwoOFOP4QPFWkxTRkdgeDZQfCdZyHyw7+qR0toFR9Hm+OJ/eqrpp1vwYs/8zM0zQ3JVR3Ll6yZrQIT1y0Bh7GZeBvhM0Nb43b5NCIZgdB04t89/1O/w1cDnyilFU="; // Chanel S
            // $datas['token'] = "O7Om2QF6Mf6akoAWlgoaLbznke7k+Mt9sxOWz7T0o16M93/q998eecerKEw3//kkLd2yfc+YKWAdUIyu7VCCIxG//o9m9R7nhowUdKbYgWHX/dIXK/rJuvWt/rhgej1UQbn8ZiO0bTRQ+HjbNRrWjAdB04t89/1O/w1cDnyilFU="; // Chanel O

            $return = $this->sentMessage($JsonData, $datas);

            $return['error'] = null;
            $return['msg'] = 'สำเร็จ';
            $return['id'] = $eventData['ID'];
            $return['sid'] = $eventData['sid'];
            $return['user_action'] = $eventData['user_action'];
            if ($eventData['dnt']) {
                $return['dnt'] = "true";
            } else {
                $return['dnt'] = null;
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
            // CURLOPT_POSTFIELDS => json_encode($encodeJson),
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
        // $datasReturn['json'] = $encodeJson;
        return $datasReturn;
    }

}
