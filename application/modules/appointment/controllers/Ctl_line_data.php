<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_line_data extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        // $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_event', 'mdl_staff', 'mdl_visitor'));
        $this->load->library(array('crud_valid', 'Flex_message'));
        // $this->load->library();

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
                    /* $optionnal_emp['where'] = array(
                    'staff.employee_id' => $val->EVENT_VISITOR,
                    ); */

                    $vis = $this->mdl_employee->get_dataShow($val->EVENT_VISITOR, $optionnal_emp, "row");

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

            $event_main = $this->mdl_event->get_dataShow($array['id'], $optionnal, "row");

            $return['item_id'] = $array['id'];
            $return['item_code'] = $array['code'];
            $return['item_data'] = $array['data'];
            $return['user_action'] = $array['user_action'];

            // เช็คว่าเป็นใครใน card
            if ($array['user_action'] == $event_main['HEAD']) { // ประธาน

                $return['role'] = 'head';
                $return['status'] = $event_main['STATUS'];

            } else { // ผู้เข้าร่วม

                $vis_optionnal['select'] = 'staff.employee_id as VID';
                $vis_optionnal['where']['staff.id'] = $array['user_action'];
                $vis_id = (array) $this->mdl_staff->get_dataShow(null, $vis_optionnal, "row");
                if ($vis_id['VID']) {
                    $optionnals['select'] = "event_visitor.id as VID ,event_visitor.event_visitor as VISITOR ";
                    $optionnals['where']['event_visitor.event_id'] = $array['id'];
                    $optionnals['where']['event_visitor.event_code'] = $array['code'];
                    $optionnals['where']['event_visitor.event_visitor'] = $vis_id['VID'];
                    $event_vis = (array) $this->mdl_visitor->get_dataShow(null, $optionnals, "row");
                    $return['role'] = 'visitor';
                    $return['vid'] = $event_vis['VID'];
                }

            }
        }
// print_r($event_main);
        echo json_encode($return);

    }

    public function visitor_delete()
    {
        // echo json_encode("test");
        $data = $this->input->post();
        if (count($data)) {

            $event = $this->get_userId($data[0], true);
            $eventData = $event['eventData'];
            // print_r($eventData);die;
            $dataReply['msg1'] = "คุณได้ถูกยกเลิกคำเชิญให้เข้าร่วมการ" . $eventData['TYPE'] . " แล้ว";
            $dataReply['msg2'] = "";
            $dataReply['msg3'] = "";
            $dataReply['user_action'] = $eventData['OWN'];
            $dataReply['dnt'] = "true";
            $dataReply['id'] = $data[0];

            for ($i = 1; $i < count($data); $i++) {

                $optionnal['select'] = "staff.id as ID,staff.user_id as userId";
                $optionnal['where']['staff.employee_id'] = $data[$i];

                $user = (array) $this->mdl_staff->get_dataShow(null, $optionnal, "row");
                if ($user) {
                    $dataReply['sid'] = $user['ID'];
                    $dataReply['userId'] = $user['userId'];
                }

                if ($eventData['APPROVE']) {
                    $return = $this->flex_message->flex_message_reply($dataReply);
                } else {
                    $return['msg'] = "ไม่สามารถส่งข้อความได้เนื่องจากประธานยังไม่อนุมัติ";
                }

            }
            echo json_encode($return);
        }
    }

    public function get_userId($id = null, $callback = false)
    {
        $data = [];
        $eventData = [];
        $userId = [];
        $return = [];
        if ($this->input->post('id')) {
            $event_id = $this->input->post('id');
        } else {
            $event_id = $id;
        }
        if ($event_id) {

            $optionnalm['select'] = "event.id as ID,
            event.code as CODE,
            event.type_id as TYPE_ID,
            event.event_name as TOPIC,
            event.event_description as DETAIL,
            event.staff_id as HEAD,
            event.user_start as OWN,
            event.date_begin as DBEGIN,
            event.date_end as DEND,
            event.time_begin as TBEGIN,
            event.time_end as TEND,
            event.approve_date as APPROVE,
            event.disapprove_date as DISAPPROVE,
            event.cancle_date as CANCEL,
            event.status_complete as STATUS";

            $optionnalm['join'] = "all";

            $eventData = (array) $this->mdl_event->get_dataShow($event_id, $optionnalm, "row");

            $optionnale['select'] = 'staff.user_id as userId,staff.id as ID';

            $data = (array) $this->mdl_staff->get_dataShow($eventData['HEAD'], $optionnale, "row");

            if ($data['userId']) {
                $eventData['userId'] = $data['userId'];
            }

            $optionnalv['select'] = "event_visitor.event_visitor as VISITOR,event_visitor.status_complete as VSTATUS";
            $optionnalv['where']['event_id'] = $event_id;
            $visitor = (array) $this->mdl_visitor->get_dataShow(null, $optionnalv);

            if ($visitor && count($visitor)) {
                $i = 0;
                foreach ($visitor as $key => $value) {
                    $optionnale['where']['staff.employee_id'] = $value->VISITOR;
                    $visitor_userId = (array) $this->mdl_staff->get_dataShow(null, $optionnale, "row");
                    if ($visitor_userId['userId']) {
                        // $userId[$visitor_userId['ID']] = $visitor_userId['userId'];
                        $eventData['VISITOR'][$i]['VUserId'] = $visitor_userId['userId'];
                        $eventData['VISITOR'][$i]['STATUS'] = $value->VSTATUS;
                        $eventData['VISITOR'][$i]['VID'] = $visitor_userId['ID'];
                    }
                    $i++;
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

            // $eventData['userId'] = $userId;
            $return = array(
                'error' => 0,
                'step' => 1,
                'eventData' => $eventData,
            );

        } else {
            $return = array(
                'error' => 1,
                'step' => 2,
                'txt' => 'ไม่พบข้อมูล',
            );
        }

        if ($callback == true) {
            return $return;
        } else {
            echo json_encode($return);
        }

    }

    public function url_respond()
    {
        $array = $this->input->post();
        if (count($array)) {
            $data = [];
            $return = [];
            $data['item_id'] = $array['id'];
            $data['item_code'] = $array['code'];
            $data['item_data'] = $array['data'];
            $data['user_action'] = $array['user_action'];

            if ($array['role'] == 'head') { // ถ้าเป็นประธาน
                if ($array['status'] == 1) {
                    $return = $this->crud_valid->approval($data);

                    if ($array['data'] == 3) {
                        // echo json_encode($return);
                    } else {
                        $event = $this->get_userId($array['id'], true);
                        $eventData = $event['eventData'];
                        $eventData['user_action'] = $array['user_action'];

                        $eventData['userId'] = $eventData['userId'];
                        $eventData['role'] = "head";
                        // print_r($eventData);die;
                        $this->flex_message->flex_message_head($eventData);

                        if ($eventData['VISITOR']) {
                            $visitor_userId = '';
                            $VID = '';
                            for ($i = 0; $i < count($eventData['VISITOR']); $i++) {
                                if (!empty($eventData['VISITOR'][$i]['VUserId'])) {
                                    $visitor_userId = $eventData['VISITOR'][$i]['VUserId'] . " " . $visitor_userId;
                                    $VID = $eventData['VISITOR'][$i]['VID'] . " " . $VID;
                                }
                            }

                            if ($visitor_userId && $VID) {
                                $eventData['userId'] = null;
                                $eventData['userId'] = textShow($visitor_userId);
                                $eventData['vid'] = textShow($VID);
                                $eventData['role'] = "visitor";
                                $this->flex_message->flex_message_action($eventData);
                            }
                        }
                    }
                    // $this->get_user_respond($array['id'], $array['data'], $array['user_action'], "true");
                    // echo json_encode($return);
                } else {
                    $return = array(
                        'error' => 1,
                        'txt' => 'ไม่สามารถทำรายการซ้ำได้',
                    );
                    // echo json_encode($return);
                }
            } elseif ($array['role'] == 'visitor') { // ถ้าเป็นผู้เข้าร่วม
                $data['vid'] = $array['vid'];
                if ($array['reason']) {
                    $data['reason'] = $array['reason'];
                } else {
                    $data['reason'] = null;
                }

                $return = $this->crud_valid->invitation($data);
                $this->get_userId_respond($array, $return);
            }
            // print_r($return);
            $this->get_user_respond($array['id'], $array['data'], $array['user_action'], "true");
            echo json_encode($return);
        }
    }

    public function get_user_respond($event_id = null, $data = null, $action = null, $callback = null)
    {
        /* print_r($this->input->post());
        die; */
        if ($event_id && $data && $action) {
            $id = $event_id;
            $user_action = $action;
        } else {
            $id = $this->input->post('id');
            $user_action = $this->input->post('user_action');
        }
        if ($id) {
            $event = $this->get_userId($id, true);
            $eventData = $event['eventData'];
            // print_r($eventData);
            $respond = 1;
            $return = [];
            $dataReply = [];

            if ($eventData['TYPE_ID'] == 1) {
                $eventData['TYPE'] = "แบบฟอร์มการจองห้อง #" . $eventData['CODE'];
            } elseif ($eventData['TYPE_ID'] == 2) {
                $eventData['TYPE'] = "แบบฟอร์มการจองรถ #" . $eventData['CODE'];
            } elseif ($eventData['TYPE_ID'] == 3) {
                $eventData['TYPE'] = "แบบฟอร์มการนัดหมาย #" . $eventData['CODE'];
            }

            if ($eventData['DBEGIN'] == $eventData['DEND']) {
                $date = "\\n วันที่ " . date("d/m/Y", strtotime($eventData['DBEGIN']));
            } else {
                $date = "\\n วันที่ " . date("d/m/Y", strtotime($eventData['DBEGIN'])) . " - " . date("d/m/Y", strtotime($eventData['DEND']));
            }

            $dataReply['msg2'] = "\\n\\n หัวข้อ " . $eventData['TOPIC'];
            $dataReply['msg3'] = $date . "\\n เวลา " . date("H:i", strtotime($eventData['TBEGIN'])) . " - " . date("H:i", strtotime($eventData['TEND']));

            if ($eventData['VISITOR']) {
                $visitor_userId = '';
                $VID = '';
                for ($i = 0; $i < count($eventData['VISITOR']); $i++) {
                    if (!empty($eventData['VISITOR'][$i]['VUserId'])) {
                        if ($eventData['VISITOR'][$i]['STATUS'] == 1) {
                            $respond = null;
                        }
                        $visitor_userId = $eventData['VISITOR'][$i]['VUserId'] . " " . $visitor_userId;
                        $VID = $eventData['VISITOR'][$i]['VID'] . " " . $VID;
                    }
                }

            }

            if ($eventData['STATUS'] == 5) {
                if ($respond) {
                    $dataP['item_id'] = $id;
                    $dataP['item_code'] = $eventData['CODE'];
                    $dataP['item_data'] = 2;
                    $dataP['user_action'] = $user_action;
                    $this->crud_valid->processing($dataP);
                    $dataReply['msg1'] = $eventData['TYPE'] . " ดำเนินการสำเร็จแล้ว";
                }

            } else if ($eventData['STATUS'] == 2 && $eventData['APPROVE']) {
                $respond = 1;
                $dataReply['msg1'] = $eventData['TYPE'] . " ดำเนินการสำเร็จแล้ว";

            } else if ($eventData['STATUS'] == 3 && $eventData['DISAPPROVE']) {
                $respond = 1;
                $dataReply['msg1'] = $eventData['TYPE'] . " ดำเนินการไม่สำเร็จ";

            } else if ($eventData['STATUS'] == 4 && $eventData['CANCEL']) {
                $respond = 1;
                $dataReply['msg1'] = $eventData['TYPE'] . " ถูกยกเลิกแล้ว";

            } else {
                $return['error'] = 1;
                $return['msg1'] = "รอผู้ที่เกี่ยวข้องตอบกลับ";
            }

            if ($dataReply['msg1'] && $respond) {
                $dataReply['dnt'] = "true";
                $dataReply['id'] = $eventData['ID'];
                $dataReply['sid'] = $eventData['OWN'];
                $dataReply['user_action'] = $user_action;

                if ($eventData['APPROVE']) {
                    // foreach ( as $key => $id) {
                    $dataReply['userId'] = $eventData['userId'];
                    $return = $this->flex_message->flex_message_reply($dataReply);

                    if ($visitor_userId && $VID) {
                        // echo $visitor_userId;
                        $v_userid = explode(" ", $visitor_userId);
                        $v_id = explode(" ", $VID);
                        for ($i = 0; $i < count($v_userid); $i++) {
                            if (!empty($v_userid[$i])) {
                                $dataReply['userId'] = null;
                                $dataReply['userId'] = $v_userid[$i];
                                $dataReply['vid'] = $v_id[$i];
                                $this->flex_message->flex_message_reply($dataReply);
                            }
                        }
                    }
                    // }
                } else {
                    $dataReply['userId'] = $eventData['userId'];
                    $return = $this->flex_message->flex_message_reply($dataReply);

                }

            } else {
                $return['error'] = 1;
                $return['msg'] = "รอผู้ที่เกี่ยวข้องตอบกลับ";
            }

            if ($callback == null) {
                echo json_encode($return);
            }
        }
    }

    public function get_userId_respond($array = [], $return = [])
    {
        if (count($array) && count($return)) {
            $optionnalm['select'] = "event.id as ID,
            event.code as CODE,
            event.type_id as TYPE_ID,
            event.event_name as TOPIC,
            event.staff_id as HEAD,
            event.user_start as OWN,
            event.date_begin as DBEGIN,
            event.date_end as DEND,
            event.time_begin as TBEGIN,
            event.time_end as TEND,
            event.approve_date as APPROVE,
            event.status_complete as STATUS";

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
            $datai = $this->mdl_staff->get_dataShow($array['user_action'], $optionnale, "row");
            if ($datai->userId) {
                $eventData['userId'] = $datai->userId;
            }

            $eventData['user_action'] = $array['user_action'];
            $eventData['sid'] = $array['user_action'];
            $eventData['ID'] = $array['id'];

            if ($array['role'] == 'visitor') {
                if ($array['data'] == 3) {
                    $eventData['msg1'] = 'คุณได้ปฏิเสธการเข้าร่วมการ' . $eventData['TYPE'] . ' เนื่องจาก' . $array['reason'];
                } elseif ($array['data'] == 2) {
                    $eventData['msg1'] = 'คุณได้ตอบรับการเข้าร่วมการ' . $eventData['TYPE'] . ' สำเร็จแล้ว';
                }

                if ($eventData['DBEGIN'] == $eventData['DEND']) {
                    $date = "\\n วันที่ " . date("d/m/Y", strtotime($eventData['DBEGIN']));
                } else {
                    $date = "\\n วันที่ " . date("d/m/Y", strtotime($eventData['DBEGIN'])) . " - " . date("d/m/Y", strtotime($eventData['DEND']));
                }
    
                $eventData['msg2'] = "\\n\\n หัวข้อ " . $eventData['TOPIC'];
                $eventData['msg3'] = $date . "\\n เวลา " . date("H:i", strtotime($eventData['TBEGIN'])) . " - " . date("H:i", strtotime($eventData['TEND']));

                $this->flex_message->flex_message_reply($eventData);
            }
        }
        // echo json_encode($return);
    }

}
