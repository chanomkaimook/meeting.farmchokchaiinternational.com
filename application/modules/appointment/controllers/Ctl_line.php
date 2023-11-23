<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_line extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        // $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_event', 'mdl_staff', 'mdl_visitor'));
        $this->load->libraries(array('crud_valid'));

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
        $this->load->view('line');
    }

    public function get_data()
    {
        $array = $this->input->post();
        if (count($array)) {
            $dataEvent = [];
            $optionnal['select'] = "event.*
          ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
          ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

            $optionnal['where'] = array(
                'event.id' => $array['id'],
                'event.code' => $array['code'],
            );

            $optionnal['join'] = "all";
            $dataEvent = (array) $this->mdl_event->get_dataShow(null, $optionnal, "row");
            $optionnal_vis['select'] = "event_visitor.ID,event_visitor.EVENT_VISITOR,event_visitor.EVENT_CODE,event_visitor.STATUS_COMPLETE,event_visitor.STATUS_REMARK";

            $optionnal_vis['where'] = array(
                'event_visitor.event_id' => $array['id'],
                'event_visitor.event_code' => $array['code'],
            );

            $optionnal_vis['join'] = true;
            $dataVis = $this->mdl_visitor->get_dataShow(null, $optionnal_vis);

            $optionnal_emp['select'] = "employee.NAME as NAME,employee.LASTNAME as LASTNAME";
            $emp = $this->mdl_staff->get_dataShow($dataEvent['USER_START'], $optionnal_emp, "row");
            $head = $this->mdl_staff->get_dataShow($dataEvent['STAFF_ID'], $optionnal_emp, "row");

            $dataEvent['HEAD_FULLNAME'] = $head->NAME . " " . $head->LASTNAME;
            $dataEvent['USER_START_FULLNAME'] = $emp->NAME . " " . $emp->LASTNAME;

            if (count($dataVis)) {
                $v = 0;
                foreach ($dataVis as $key => $val) {
                    $vis = $this->mdl_staff->get_dataShow($val->EVENT_VISITOR, $optionnal_emp, "row");

                    $dataEvent['VISITOR'][$v] = (array) $val;
                    $dataEvent['VISITOR'][$v]['VNAME'] = $vis->NAME;
                    $dataEvent['VISITOR'][$v]['VLNAME'] = $vis->LASTNAME;
                    $dataEvent['VISITOR'][$v]['VFNAME'] = $vis->NAME . " " . $vis->LASTNAME;
                    $v++;
                }
            }

            $dataEvent['DATE_BEGIN'] = date("d/m/Y", strtotime($dataEvent['DATE_BEGIN']));
            $dataEvent['DATE_END'] = date("d/m/Y", strtotime($dataEvent['DATE_END']));
            $dataEvent['TIME_BEGIN'] = date("H:i", strtotime($dataEvent['TIME_BEGIN']));
            $dataEvent['TIME_END'] = date("H:i", strtotime($dataEvent['TIME_END']));

            if (!$dataEvent['DISAPPROVE_DATE'] && !$dataEvent['APPROVE_DATE']) {
                $dataEvent['STATUS_HEAD'] = "รออนุมัติ";
            } else {
                if ($dataEvent['DISAPPROVE_DATE']) {
                    $dataEvent['STATUS_HEAD'] = "ไม่อนุมัติ";
                } elseif ($dataEvent['APPROVE_DATE']) {
                    $dataEvent['STATUS_HEAD'] = "อนุมัติ";
                }
            }

            if ($dataEvent['TYPE_ID'] == 1) {
                $dataEvent['TYPE'] = "จองห้อง #" . $array['code'];
            } elseif ($dataEvent['TYPE_ID'] == 2) {
                $dataEvent['TYPE'] = "จองรถ #" . $array['code'];
            } elseif ($dataEvent['TYPE_ID'] == 3) {
                $dataEvent['TYPE'] = "นัดหมาย #" . $array['code'];
            }
        }
        echo json_encode($dataEvent);
    }

    public function check_role()
    {
        $array = $this->input->post();
        if (count($array)) {
            $data = [];
            $return = [];
            $optionnal['select'] = "event.staff_id as HEAD,event.user_start as OWN,event.status_complete as STATUS";

            // $optionnal['where']['event.id'] = $array['id'];
            // $optionnal['where']['event.code'] = $array['code'];

            $event_main = $this->mdl_event->get_dataShow($array['id'], $optionnal, "row");

            $optionnals['select'] = "event_visitor.id as VID ,event_visitor.event_visitor as VISITOR ";
            $optionnals['where']['event_visitor.event_id'] = $array['id'];
            $optionnals['where']['event_visitor.event_code'] = $array['code'];
            $optionnals['where']['event_visitor.event_visitor'] = $array['user_action'];
            $event_vis = $this->mdl_visitor->get_dataShow(null, $optionnals, "row");

            $return['item_id'] = $array['id'];
            $return['item_code'] = $array['code'];
            $return['item_data'] = $array['data'];
            $return['user_action'] = $array['user_action'];

            if ($array['user_action'] == $event_main['HEAD'] && $array['user_action'] != $event_main['OWN']) {
                $return['role'] = 'child';
                $return['status'] = $event_main['STATUS'];
            } elseif ($event_vis->VISITOR) {
                $return['role'] = 'vis';
                $return['vid'] = $event_vis->VID;
            }

        }

        echo json_encode($return);

    }

    public function url_respond()
    {
        $array = $this->input->post();
        // $return['error'] = 1;
        if (count($array)) {
            $data = [];
            $return = [];
            $data['item_id'] = $array['id'];
            $data['item_code'] = $array['code'];
            $data['item_data'] = $array['data'];
            $data['user_action'] = $array['user_action'];

            if ($array['role'] == 'child') {
                if ($array['status'] == 1) {
                    $return = $this->crud_valid->approval($data);

                    $this->get_userID_respond($array, $return);

                    $this->get_userID($array['id']);

                } else {
                    $return = array(
                        'error' => 1,
                        'txt' => 'ไม่สามารถทำรายการซ้ำได้',
                    );
                    echo json_encode($return);
                }
            } elseif ($array['role'] == 'vis') {
                $data['vid'] = $array['vid'];
                if ($array['reason']) {
                    $data['reason'] = $array['reason'];
                } else {
                    $data['reason'] = null;
                }

                $return = $this->crud_valid->invitation($data);
                $this->get_userID_respond($array, $return);
                echo json_encode($return);
            }

        }

    }

    public function get_userID_respond($array = [], $return = [])
    {
        if (count($array) && count($return)) {
            $optionnalm['select'] = "event.type_id as TYPE_ID,";

            $optionnalm['where']['event.id'] = $array['id'];
            $optionnalm['where']['event.code'] = $array['code'];
            $eventData = $this->mdl_event->get_dataShow(null, $optionnalm, "row");

            if ($eventData['TYPE_ID'] == 1) {
                $eventData['TYPE'] = "จองห้อง #" . $array['code'];
            } elseif ($eventData['TYPE_ID'] == 2) {
                $eventData['TYPE'] = "จองรถ #" . $array['code'];
            } elseif ($eventData['TYPE_ID'] == 3) {
                $eventData['TYPE'] = "นัดหมาย #" . $array['code'];
            }

            $optionnale['select'] = 'staff.user_id as userId';

            $data = $this->mdl_staff->get_dataShow($array['user_action'], $optionnale, "row");
            if ($data->userId) {
                $userId = $data->userId;
            }

            if ($array['role'] == 'child') {
                if ($array['data'] == 3) {
                    $eventData['DETAIL'] = 'ไม่อนุมัติการ' . $eventData['TYPE'] . ' สำเร็จแล้ว';
                } elseif ($array['data'] == 2) {
                    $eventData['DETAIL'] = 'อนุมัติการ' . $eventData['TYPE'] . ' สำเร็จแล้ว';
                }
            } elseif ($array['role'] == 'vis') {
                if ($array['data'] == 3) {
                    $eventData['DETAIL'] = 'คุณปฏิเสธการเข้าร่วมการ' . $eventData['TYPE'] . ' เนื่องจาก' . $array['reason'];
                } elseif ($array['data'] == 2) {
                    $eventData['DETAIL'] = 'คุณได้เข้าร่วมการ' . $eventData['TYPE'] . ' สำเร็จแล้ว';
                }
            }

            $this->flex_message($userId, $eventData);
        }
        // echo json_encode($return);
    }

    public function get_userID($forward = null)
    {
        $data = [];
        $eventData = [];
        $return = [];
        $userId = [];
        $array = [];

        $array = $this->input->post();
        if ($forward) {
            $array['id'] = $forward;
        }
        if (count($array)) {

            $optionnalm['select'] = "event.id as ID,event.code as CODE,event.type_id as TYPE_ID,event.event_name as TOPIC,event.event_description as DETAIL,event.staff_id as HEAD,event.user_start as OWN,event.date_begin as DBEGIN,event.date_end as DEND,event.time_begin as TBEGIN,event.time_end as TEND,event.status_complete as STATUS";

            $optionnalm['join'] = "all";
            $optionnalm['where']['event.id'] = $array['id'];

            $eventData = (array) $this->mdl_event->get_dataShow(null, $optionnalm, "row");

            $optionnale['select'] = 'staff.user_id as userId';

            $data = $this->mdl_staff->get_dataShow($eventData['HEAD'], $optionnale, "row");
            if ($data->userId) {
                $userId[$eventData['HEAD']] = $data->userId;
            }

            $select['select'] = "employee.name as NAME,employee.lastname as LASTNAME";
            $emp_data = $this->mdl_staff->get_dataShow($eventData['HEAD'], $select, "row");
            $eventData['HEAD_NAME'] = $emp_data->NAME . " " . $emp_data->LASTNAME;

            if ($eventData['TYPE_ID'] == 1) {
                $eventData['TYPE'] = "จองห้อง #" . $eventData['CODE'];
            } elseif ($eventData['TYPE_ID'] == 2) {
                $eventData['TYPE'] = "จองรถ #" . $eventData['CODE'];
            } elseif ($eventData['TYPE_ID'] == 3) {
                $eventData['TYPE'] = "นัดหมาย #" . $eventData['CODE'];
            }

            if ($eventData['HEAD'] == $eventData['OWN'] || $eventData['STATUS'] == 5) {
                $return = $this->get_userID_all($array['id'], $eventData);
            } else {
                $return = $this->line_push_message($userId, $eventData);
            }

        } else {
            $return = array(
                'txt' => 'ไม่พบข้อมูล',
            );

            // echo json_encode($return);
        }

    }

    public function get_userID_all($event_id = null, $eventData = [])
    {
        $event_vis = [];
        $data = [];
        $return = [];
        $userId = [];
        $array = [];
        if ($event_id && count($eventData)) {

            $optionnals['select'] = "event_visitor.event_visitor as VISITOR";
            $optionnals['where']['event_visitor.event_id'] = $event_id;
            $event_vis = (array) $this->mdl_visitor->get_dataShow(null, $optionnals);

            if ($event_vis) {
                foreach ($event_vis as $key => $value) {
                    $optionnale['select'] = 'staff.user_id as userId';

                    $data = $this->mdl_staff->get_dataShow($value->VISITOR, $optionnale, "row");
                    if ($data->userId) {
                        $userId[$value->VISITOR] = $data->userId;
                    }

                }
            }
        } else {
            $array = $this->input->post();
            if (count($array)) {

                $optionnalm['select'] = "event.id as ID,event.code as CODE,event.type_id as TYPE_ID,event.event_name as TOPIC,event.event_description as DETAIL,event.staff_id as HEAD,event.user_start as OWN,event.date_begin as DBEGIN,event.date_end as DEND,event.time_begin as TBEGIN,event.time_end as TEND";

                $optionnalm['join'] = "all";

                $eventData = (array) $this->mdl_event->get_dataShow($array['id'], $optionnalm, "row");

                $optionnale['select'] = 'staff.user_id as userId';

                $data = $this->mdl_staff->get_dataShow($eventData['HEAD'], $optionnale, "row");
                if ($data->userId) {
                    $userId[$eventData['HEAD']] = $data->userId;
                }

                $optionnals['select'] = "event_visitor.event_visitor as VISITOR";
                $optionnals['where']['event_visitor.event_id'] = $array['id'];
                $event_vis = (array) $this->mdl_visitor->get_dataShow(null, $optionnals);

                if ($event_vis) {
                    foreach ($event_vis as $key => $value) {
                        $optionnale['select'] = 'staff.user_id as userId';

                        $data = $this->mdl_staff->get_dataShow($value->VISITOR, $optionnale, "row");
                        if ($data->userId) {
                            $userId[$value->VISITOR] = $data->userId;
                        }

                    }
                }

                $select['select'] = "employee.name as NAME,employee.lastname as LASTNAME";
                $emp_data = $this->mdl_staff->get_dataShow($eventData['HEAD'], $select, "row");
                $eventData['HEAD_NAME'] = $emp_data->NAME . " " . $emp_data->LASTNAME;

                if ($eventData['TYPE_ID'] == 1) {
                    $eventData['TYPE'] = "จองห้อง #" . $eventData['CODE'];
                } elseif ($eventData['TYPE_ID'] == 2) {
                    $eventData['TYPE'] = "จองรถ #" . $eventData['CODE'];
                } elseif ($eventData['TYPE_ID'] == 3) {
                    $eventData['TYPE'] = "นัดหมาย #" . $eventData['CODE'];
                }
            }
        }
        if (count($userId)) {
            $return = $this->line_push_message($userId, $eventData);
        } else {
            $return = array(
                'txt' => 'ไม่พบข้อมูล',
            );
        }

        echo json_encode($return);

    }

    public function flex_message($userId = null, $eventData = [])
    {
        $return['error'] = "ไม่พบข้อมูล";
        // echo $userId;
        if ($userId && count($eventData)) {
            $return = [];
            $JsonData = '{
              "type": "flex",
              "altText": "' . $eventData['DETAIL'] . '",
              "contents": {
                "type": "bubble",
                "body": {
                  "type": "box",
                  "layout": "vertical",
                  "contents": [
                    {
                      "type": "text",
                      "text": "' . $eventData['DETAIL'] . '",
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
            $return[] = $this->sentMessage($encode, $datas);
        }
        return $return;
    }

    public function line_push_message($userId = [], $eventData = [])
    {
        $return['error'] = "ไม่พบข้อมูล";
        // die;
        if (count($userId) && count($eventData)) {
            $return = [];
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

            foreach ($userId as $key => $val) {
                if ($key == $head) {
                    $txt2 = "อนุมัติ";
                    $txt3 = "ไม่อนุมัติ";
                } else {
                    $txt2 = "เข้าร่วม";
                    $txt3 = "ไม่เข้าร่วม";
                }

                $uri1 = "https://booking.chokchaiinternational.com/appointment/ctl_line?id=" . $id . "&code=" . $code . "&user_action=" . $key;
                $uri2 = "https://booking.chokchaiinternational.com/appointment/ctl_line?id=" . $id . "&code=" . $code . "&data=2&user_action=" . $key;
                $uri3 = "https://booking.chokchaiinternational.com/appointment/ctl_line?id=" . $id . "&code=" . $code . "&data=3&user_action=" . $key;
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
