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
                    $return['role'] = 'vis';
                    $return['vid'] = $event_vis['VID'];
                }

            }
        }

        echo json_encode($return);

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
            event.status_complete as STATUS";

            $optionnalm['join'] = "all";

            $eventData = (array) $this->mdl_event->get_dataShow($event_id, $optionnalm, "row");

            $optionnale['select'] = 'staff.user_id as userId,staff.id as ID';

            $data = (array) $this->mdl_staff->get_dataShow($eventData['HEAD'], $optionnale, "row");

            if ($data['userId']) {
                $userId[$eventData['HEAD']] = $data['userId'];
            }

            $optionnalv['select'] = "event_visitor.event_visitor as VISITOR";
            $optionnalv['where']['event_id'] = $event_id;
            $visitor = (array) $this->mdl_visitor->get_dataShow(null, $optionnalv);

            if ($visitor && count($visitor)) {
                foreach ($visitor as $key => $value) {
                    $optionnale['where']['staff.employee_id'] = $value->VISITOR;
                    $visitor_userId = (array) $this->mdl_staff->get_dataShow(null, $optionnale, "row");
                    if ($visitor_userId['userId']) {
                        $userId[$visitor_userId['ID']] = $visitor_userId['userId'];
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

            $eventData['userId'] = $userId;
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
                        echo json_encode($return);
                    } else {
                        $event = $this->get_userId($array['id'], true);
                        $eventData = $event['eventData'];
                        $eventData['user_action'] = $array['user_action'];
                        if ($eventData['userId'] && count($eventData['userId'])) {
                            // echo "11111-------------------------------";
                            $userId = $eventData['userId'];
                            $head_userId = '';
                            $visitor_userId = '';
                            $VID = '';
                            foreach ($userId as $key => $val) {
                                if (!empty($val)) {
                                    if ($key == $array['user_action']) {
                                        // echo "44444-------------------------------";
                                        $head_userId = $val;
                                        // print_r($eventData);
                                    } else {
                                        // echo "55555-------------------------------";
                                        $visitor_userId = $val . " " . $key . " " . $visitor_userId;
                                        $VID = $key . " " . $VID;

                                    }
                                }
                            }

                            echo $VID."<br>";
                            echo $visitor_userId."<br>";
                            if ($head_userId) {
                                $eventData['userId'] = null;
                                $eventData['userId'] = $head_userId;
                                $eventData['role'] = "head";
                                // $this->flex_message->flex_message_head($eventData);
                            }

                            if ($visitor_userId && $VID) {
                                $eventData['userId'] = null;
                                $eventData['userId'] = textShow($visitor_userId);
                                $eventData['vid'] = textShow($VID);
                                $eventData['role'] = "visitor";
                                // $this->flex_message->flex_message_action($eventData);
                            }
                        }
                    }

                } else {
                    $return = array(
                        'error' => 1,
                        'txt' => 'ไม่สามารถทำรายการซ้ำได้',
                    );
                    echo json_encode($return);
                }
            } elseif ($array['role'] == 'vis') { // ถ้าเป็นผู้เข้าร่วม
                $data['vid'] = $array['vid'];
                if ($array['reason']) {
                    $data['reason'] = $array['reason'];
                } else {
                    $data['reason'] = null;
                }

                $return = $this->crud_valid->invitation($data);
                $this->get_userId_respond($array, $return);
                echo json_encode($return);
            }

        }

    }

    public function get_userId_respond($array = [], $return = [])
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
            $optionnale['where'] = array(
                'staff.employee_id' => $array['user_action'],
            );

            $data = $this->mdl_staff->get_dataShow(null, $optionnale, "row");
            if ($data->userId) {
                $userId = $data->userId;
            } else {
                $optionnali['select'] = 'staff.user_id as userId';
                $datai = $this->mdl_staff->get_dataShow($array['user_action'], $optionnali, "row");
                if ($datai->userId) {
                    $userId = $datai->userId;
                }
            }

            if ($array['role'] == 'head') {
                if ($array['data'] == 3) {
                    $eventData['DETAIL'] = 'ไม่อนุมัติการ' . $eventData['TYPE'] . ' สำเร็จแล้ว';
                } elseif ($array['data'] == 2) {
                    $eventData['DETAIL'] = 'อนุมัติการ' . $eventData['TYPE'] . ' สำเร็จแล้ว';
                }
                // $eventData['userId'] = $userId;
            } elseif ($array['role'] == 'vis') {
                if ($array['data'] == 3) {
                    $eventData['DETAIL'] = 'คุณปฏิเสธการเข้าร่วมการ' . $eventData['TYPE'] . ' เนื่องจาก' . $array['reason'];
                } elseif ($array['data'] == 2) {
                    $eventData['DETAIL'] = 'คุณได้เข้าร่วมการ' . $eventData['TYPE'] . ' สำเร็จแล้ว';
                }
                $this->flex_message->flex_message_reply($userId, $eventData['DETAIL']);
            }
        }
        // echo json_encode($return);
    }

    // public function get_userId_all($event_id = null, $eventData = [])
    // {
    //     $event_vis = [];
    //     $data = [];
    //     $return = [];
    //     $userId = [];
    //     $array = [];
    //     if ($event_id && count($eventData)) {

    //         $optionnals['select'] = "event_visitor.event_visitor as VISITOR";
    //         $optionnals['where']['event_visitor.event_id'] = $event_id;
    //         $event_vis = (array) $this->mdl_visitor->get_dataShow(null, $optionnals);

    //         if ($event_vis) {
    //             foreach ($event_vis as $key => $value) {
    //                 $optionnale['select'] = 'staff.user_id as userId';
    //                 $optionnale['where'] = array(
    //                     'staff.employee_id' => $value->VISITOR,
    //                 );

    //                 $data = $this->mdl_staff->get_dataShow(null, $optionnale, "row");
    //                 if ($data->userId) {
    //                     $userId[$value->VISITOR] = $data->userId;
    //                 }

    //             }
    //         }
    //     } else {
    //         $array = $this->input->post();
    //         if (count($array)) {

    //             $optionnalm['select'] = "event.id as ID,event.code as CODE,event.type_id as TYPE_ID,event.event_name as TOPIC,event.event_description as DETAIL,event.staff_id as HEAD,event.user_start as OWN,event.date_begin as DBEGIN,event.date_end as DEND,event.time_begin as TBEGIN,event.time_end as TEND";

    //             $optionnalm['join'] = "all";

    //             $eventData = (array) $this->mdl_event->get_dataShow($array['id'], $optionnalm, "row");

    //             $optionnale['select'] = 'staff.user_id as userId';

    //             $data = $this->mdl_staff->get_dataShow($eventData['HEAD'], $optionnale, "row");
    //             if ($data->userId) {
    //                 $eventData['userId'] = $eventData['userId'] . "," . $data->userId;
    //             }

    //             $optionnals['select'] = "event_visitor.event_visitor as VISITOR";
    //             $optionnals['where']['event_visitor.event_id'] = $array['id'];
    //             $event_vis = (array) $this->mdl_visitor->get_dataShow(null, $optionnals);

    //             if ($event_vis) {
    //                 foreach ($event_vis as $key => $value) {
    //                     $optionnale['select'] = 'staff.user_id as userId';
    //                     $optionnale['where'] = array(
    //                         'staff.employee_id' => $value->VISITOR,
    //                     );

    //                     $data = $this->mdl_staff->get_dataShow(null, $optionnale, "row");
    //                     if ($data->userId) {
    //                         $eventData['userId'] = $eventData['userId'] . "," . $data->userId;
    //                     }

    //                 }
    //             }

    //             $select['select'] = "employee.name as NAME,employee.lastname as LASTNAME";
    //             $emp_data = $this->mdl_staff->get_dataShow($eventData['HEAD'], $select, "row");
    //             $eventData['HEAD_NAME'] = $emp_data->NAME . " " . $emp_data->LASTNAME;

    //             if ($eventData['TYPE_ID'] == 1) {
    //                 $eventData['TYPE'] = "จองห้อง #" . $eventData['CODE'];
    //             } elseif ($eventData['TYPE_ID'] == 2) {
    //                 $eventData['TYPE'] = "จองรถ #" . $eventData['CODE'];
    //             } elseif ($eventData['TYPE_ID'] == 3) {
    //                 $eventData['TYPE'] = "นัดหมาย #" . $eventData['CODE'];
    //             }
    //         }
    //     }

    //     if (count($eventData)) {
    //         $return = $this->flex_message->flex_message_action($eventData);
    //     } else {
    //         $return = array(
    //             'txt' => 'ไม่พบข้อมูล',
    //         );
    //     }

    //     echo json_encode($return);

    // }

}
