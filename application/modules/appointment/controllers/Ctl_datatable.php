<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_datatable extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_calendar', 'mdl_event', 'mdl_role_focus', 'mdl_visitor', 'mdl_rooms', 'mdl_staff', 'mdl_employee'));
        $this->load->libraries(array('generate_event_code', 'crud_valid', 'format_date'));

    }

    public function index()
    {
        $role_focus = [];
        $staff = [];

        $optionnal_staff['where'] = array(
            'staff.employee_id' => $this->user_emp,
        );

        $staff[] = (array) $this->mdl_staff->get_dataShow(null, $optionnal_staff, "row");

        $optionnal_role['where'] = array(
            'staff_owner' => $this->user_emp,
        );
        $role_focus = $this->mdl_role_focus->get_data(null, $optionnal_role);
        if (count($role_focus)) {
            foreach ($role_focus as $key => $val) {
                $optionnal_rolef['where'] = array(
                    'staff.employee_id' => $val->STAFF_CHILD,
                );
                $staff1 = (array) $this->mdl_staff->get_dataShow(null, $optionnal_rolef, "row");
                if ($staff1) {
                    $staff[] = $staff1;
                }
            }
        }

        $data['staff'] = $staff;

        $data['time'] = $this->mdl_calendar->get_time();

        /* $optionnalr['where'] = array(
        'branch' => "สำนักงานรังสิต",
        ); */
        $data['room'] = $this->mdl_rooms->get_data( /* null, $optionnalr */);
        $data['employee'] = $this->mdl_employee->get_dataShow();

        $this->template->set_layout('lay_datatable');
        $this->template->title($this->_title);
        $this->template->build('datatable', $data);
    }

    public function get_dataQueue()
    {
        $array = $this->input->post();
        $optionnal['where']['event.date_begin <> '] = "0000-00-00";
        $optionnal['where']['event.date_end <> '] = "0000-00-00";
        $optionnal['where']['event.type_id < '] = 4;
        $optionnal['select'] = "event.id as ID,
        event.code as CODE,
        event.staff_id as STAFF_ID,
        event.type_id as TYPE_ID,
        event.event_name as TOPIC,
        event.date_begin as DATE_BEGIN,
        event.date_end as DATE_END,
        event.time_begin as TIME_BEGIN,
        event.time_end as TIME_END,
        event_meeting.rooms_id as ROOMS_ID,
        event_meeting.rooms_name as ROOMS_NAME,
        event_car.car_id as CAR_ID,
        event_car.car_name as CAR_NAME,
        event_car.driver_id as DRIVER_ID,
        event_car.driver_name as DRIVER_NAME";

        if (count($array)) {
            $user = $array['user'];

            if ($user) {
                $optionnal['where']['event.staff_id'] = $user;
            }

        }

        

            $result = array(
                "recordsTotal" => count($dataReturn),
                "recordsFiltered" => $dataall,
                "data" => $dataReturn,
            );
            echo json_encode($result);
        
    }

    public function status($status_complete, $child = null)
    {
        $status_pending_soft = "bg-pending-soft";
        $status_pending = "bg-pending";
        $status_success = "bg-success";
        $status_failure_soft = "bg-failure-soft";
        $status_failure = "bg-failure";
        $status_process = "bg-process";
        $status_cancle = "bg-cancle";
        $event_color = "";
        $event_status = "";
        $color_child = "";
        $color = "";
        $status = "";
        $status_child = "";
        $status_vis = "";

        if ($status_complete == 1) {
            $color = $status_pending;
            $color_child = $status_pending_soft;
            $status = "รอดำเนินการ";
            $status_vis = "รอตอบรับ";
            $status_child = "รออนุมัติ";
        } else if ($status_complete == 2) {
            $color = $status_success;
            $color_child = $status_success;
            $status = "ดำเนินการสำเร็จ";
            $status_vis = "เข้าร่วม";
            $status_child = "อนุมัติ";
        } else if ($status_complete == 3) {
            $color = $status_failure;
            $color_child = $status_failure_soft;
            $status = "ดำเนินการไม่สำเร็จ";
            $status_vis = "ปฏิเสธ";
            $status_child = "ไม่อนุมัติ";
        } else if ($status_complete == 4) {
            $color = $status_cancle;
            $color_child = $status_cancle;
            $status = "ยกเลิก";
            $status_vis = "ยกเลิก";
            $status_child = "ยกเลิก";
        } else if ($status_complete == 5) {
            $color = $status_process;
            $color_child = $status_process;
            $status = "กำลังดำเนินการ";
            $status_vis = "กำลังดำเนินการ";
            $status_child = "กำลังดำเนินการ";
        }

        //
        // ตรวจสอบ สถานะ
        if ($child == "me" || $child == "owner") {
            $event_color = $color;
            $event_status = $status;
        } else if ($child == "other") {
            $event_color = $color_child;
            $event_status = $status;
        } else if ($child == "child") {
            $event_color = $color_child;
            $event_status = $status_child;
        } else if ($child == "vis") {
            $event_color = $color_child;
            $event_status = $status_vis;
        }
        $return = array(
            'status' => $event_status,
            'color' => $event_color,
        );

        return $return;
    }

    public function check_role_of_card($event_id)
    {
        $optionnal_emp['select'] = "event.staff_id as STAFF_ID,event.user_start as USER_START";
        $event_emp = $this->mdl_event->get_dataShow($event_id, $optionnal_emp, "row");

        $optionnal_vis['select'] = "event_visitor.event_visitor as EVENT_VISITOR";
        $optionnal_vis['join'] = false;
        $optionnal_vis['where'] = array(
            'event_visitor.event_id' => $event_id,
        );
        $event_vis = $this->mdl_visitor->get_dataShow(null, $optionnal_vis, "row");

        if ($event_vis->EVENT_VISITOR == $this->user_code) {
            $state = 'vis';
        } else if ($event_emp['STAFF_ID'] == $this->user_code && $event_emp['USER_START'] == $this->user_code) {
            $state = "me";
        } else if ($event_emp['STAFF_ID'] != $this->user_code && $event_emp['USER_START'] != $this->user_code) {
            $state = 'other';
        } else if ($event_emp['STAFF_ID'] != $this->user_code && $event_emp['USER_START'] == $this->user_code) {
            $state = 'owner';
        } else if ($event_emp['STAFF_ID'] == $this->user_code && $event_emp['USER_START'] != $this->user_code) {
            $state = 'child';
        }

        return $state;

    }

    public function foreach_loop($dataShow)
    {
        $i = 0;
        $DataTable = array();

        if ($dataShow) {
            foreach ($dataShow as $key => $val) {

                if ($val) {
                    foreach ($val as $sub_key => $value) {
                        $dataVal = (array) $value;
// $i = $value->ID;
                        $state = $this->check_role_of_card($dataVal['ID']);

                        $attr = $this->status($dataVal["STATUS_COMPLETE"], $state);

                        $optionnal_emp['select'] = "employee.ID as EMP_ID,employee.NAME as NAME,employee.LASTNAME as LASTNAME";
                        $emp = $this->mdl_staff->get_dataShow($dataVal['USER_START'], $optionnal_emp, "row");

                        $head = $this->mdl_staff->get_dataShow($dataVal['STAFF_ID'], $optionnal_emp, "row");

                        $DataTable[$i] = $dataVal;
                        $DataTable[$i]['EMP_ID'] = $head->EMP_ID;
                        $DataTable[$i]['DATE_BEGIN_SHOW'] = toThaiDateTimeString($dataVal['DATE_BEGIN']);
                        $DataTable[$i]['DATE_END_SHOW'] = toThaiDateTimeString($dataVal['DATE_END']);
                        $DataTable[$i]['TIME_BEGIN_SHOW'] = date('H:i', strtotime($dataVal['TIME_BEGIN']));
                        $DataTable[$i]['TIME_END_SHOW'] = date('H:i', strtotime($dataVal['TIME_END']));
                        $DataTable[$i]['HEAD_NAME'] = $head->NAME;
                        $DataTable[$i]['HEAD_LNAME'] = $head->LASTNAME;
                        $DataTable[$i]['HEAD_FULLNAME'] = $head->NAME . " " . $head->LASTNAME;
                        $DataTable[$i]['USER_START_NAME'] = $emp->NAME;
                        $DataTable[$i]['USER_START_LNAME'] = $emp->LASTNAME;
                        $DataTable[$i]['USER_START_FULLNAME'] = $emp->NAME . " " . $emp->LASTNAME;
                        $DataTable[$i]['start'] = $dataVal["DATE_BEGIN"];
                        $DataTable[$i]['end'] = date('Y-m-d', strtotime($dataVal["DATE_END"] . "+ 1 days"));
                        $DataTable[$i]['title'] = $dataVal["EVENT_NAME"];
                        $DataTable[$i]['className'] = $attr['color'];
                        $DataTable[$i]['STATUS_SHOW'] = $dataVal['TYPE_NAME'] . " #" . $dataVal['CODE'] . "<br>" . $dataVal['STATUS_COMPLETE_NAME'];
                        $DataTable[$i]['class'] = $state;
                        // $DataTable[$i]['test_day'] = date('W', strtotime($dataVal['DATE_END']));

                        $optionnals['select'] = "event_visitor.*,employee.NAME as NAME,employee.LASTNAME as LASTNAME";
                        $optionnals['join'] = true;
                        $optionnals['where'] = array(
                            'event_visitor.event_code' => $dataVal["CODE"],
                        );
                        $visitor = $this->mdl_visitor->get_dataShow(null, $optionnals);
                        // echo $this->db->last_query();
                        if (count($visitor)) {
                            $j = 0;
                            foreach ($visitor as $vis_val) {

                                $optionnal_vis['select'] = "employee.NAME as NAME,employee.LASTNAME as LASTNAME";
                                $optionnal_vis['where'] = array(
                                    'employee.id' => $vis_val->EVENT_VISITOR,
                                );
                                $vis_emp = $this->mdl_employee->get_dataShow(null, $optionnal_vis, "row");

                                $DataTable[$i]['VISITOR'][$j]['EID'] = $vis_val->ID;
                                $DataTable[$i]['VISITOR'][$j]['VID'] = $vis_val->EVENT_VISITOR;
                                $DataTable[$i]['VISITOR'][$j]['VNAME'] = $vis_emp->NAME;
                                $DataTable[$i]['VISITOR'][$j]['VLNAME'] = $vis_emp->LASTNAME;
                                $DataTable[$i]['VISITOR'][$j]['VSTATUS'] = $vis_val->STATUS_COMPLETE;
                                $DataTable[$i]['VISITOR'][$j]['VREMARK'] = $vis_val->STATUS_REMARK;

                                $j++;
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        return $DataTable;
    }

    public function get_data()
    {
        $DataTable = [];
        $dataShow = [];
        $dataReturn = [];
        $array = $this->input->post();

        if ($this->input->get("event_id") != "") {

            $optionnal['join'] = "all";
            $optionnal['select'] = "event.*
        ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
        ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

            $dataShow = $this->mdl_event->get_dataShow($this->input->get('event_id'), $optionnal, "row");

            if (count($dataShow)) {
                $optionnal_emp['select'] = "employee.ID as EMP_ID,employee.NAME as NAME,employee.LASTNAME as LASTNAME";
                $emp = $this->mdl_staff->get_dataShow($dataShow['USER_START'], $optionnal_emp, "row");
                $state = $this->check_role_of_card($dataShow['ID']);
                $attr = $this->status($dataShow["STATUS_COMPLETE"], $state);
                $head = $this->mdl_staff->get_dataShow($dataShow['STAFF_ID'], $optionnal_emp, "row");

                $DataTable = $dataShow;
                $DataTable['EMP_ID'] = $head->EMP_ID;
                $DataTable['DATE_BEGIN_SHOW'] = toThaiDateTimeString($dataShow['DATE_BEGIN']);
                $DataTable['DATE_END_SHOW'] = toThaiDateTimeString($dataShow['DATE_END']);
                $DataTable['TIME_BEGIN_SHOW'] = date('H:i', strtotime($dataShow['TIME_BEGIN']));
                $DataTable['TIME_END_SHOW'] = date('H:i', strtotime($dataShow['TIME_END']));
                $DataTable['HEAD_NAME'] = $head->NAME;
                $DataTable['HEAD_LNAME'] = $head->LASTNAME;
                $DataTable['HEAD_FULLNAME'] = $head->NAME . " " . $head->LASTNAME;
                $DataTable['USER_START_NAME'] = $emp->NAME;
                $DataTable['USER_START_LNAME'] = $emp->LASTNAME;
                $DataTable['USER_START_FULLNAME'] = $emp->NAME . " " . $emp->LASTNAME;
                $DataTable['start'] = $dataShow["DATE_BEGIN"];
                $DataTable['end'] = $dataShow["DATE_END"];
                $DataTable['title'] = $dataShow["EVENT_NAME"];
                $DataTable['className'] = $attr['color'];
                $DataTable['STATUS_SHOW'] = $dataShow['TYPE_NAME'] . " #" . $dataShow['CODE'] . "<br>" . $dataShow['STATUS_COMPLETE_NAME'];
                $DataTable['class'] = $state;

                $optionnals['select'] = "event_visitor.*";
                $optionnals['where'] = array(
                    'event_visitor.event_code' => $dataShow["CODE"],
                );
                $visitor = $this->mdl_visitor->get_dataShow(null, $optionnals);
                // echo $this->db->last_query();
                if (count($visitor)) {
                    $j = 0;
                    foreach ($visitor as $vis_val) {

                        $optionnal_vis['select'] = "employee.NAME as NAME,employee.LASTNAME as LASTNAME";
                        $optionnal_vis['where'] = array(
                            'employee.id' => $vis_val->EVENT_VISITOR,
                        );
                        $vis_emp = $this->mdl_employee->get_dataShow(null, $optionnal_vis, "row");

                        $DataTable['VISITOR'][$j]['EID'] = $vis_val->ID;
                        $DataTable['VISITOR'][$j]['VID'] = $vis_val->EVENT_VISITOR;
                        $DataTable['VISITOR'][$j]['VNAME'] = $vis_emp->NAME;
                        $DataTable['VISITOR'][$j]['VLNAME'] = $vis_emp->LASTNAME;
                        $DataTable['VISITOR'][$j]['VSTATUS'] = $vis_val->STATUS_COMPLETE;
                        $DataTable['VISITOR'][$j]['VREMARK'] = $vis_val->STATUS_REMARK;

                        $j++;
                    }
                }
                // $DataTable = $this->foreach_loop($dataShow);
            }
            /* echo "<pre>";
            print_r($DataTable);
            echo "</pre>"; */
            echo json_encode($DataTable);

        } else {
            $optionnal['where']['event.date_begin <> '] = "0000-00-00";
            $optionnal['where']['event.date_end <> '] = "0000-00-00";
            $optionnal['where']['event.type_id < '] = 4;
            $optionnal['select'] = "event.*
            ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
            ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

            if (count($array)) {
                $dates = $array['dates'];
                $datee = $array['datee'];
                $times = $array['times'];
                $timee = $array['timee'];
                $user = $array['user'];
                $permit = $array['permit'];
                $status = $array['status'];
                $area = $array['area'];
                $type = $array['type'];

                if ($dates && $datee) {
                    $optionnal['where']['(event.date_begin BETWEEN "' . $dates . '" AND "' . $datee . '")'] = null;
                    $optionnal['where']['(event.date_end BETWEEN "' . $dates . '" AND "' . $datee . '")'] = null;

                } else {

                    if ($dates) {
                        $optionnal['where']['event.date_begin'] = $dates;
                    }

                    if ($datee) {
                        $optionnal['where']['event.date_end'] = $datee;
                    }

                }

                if ($times && $timee) {
                    $optionnal['where']['(event.time_begin BETWEEN "' . $times . '" AND "' . $timee . '")'] = null;
                    $optionnal['where']['(event.time_end BETWEEN "' . $times . '" AND "' . $timee . '")'] = null;

                } else {

                    if ($times) {
                        $optionnal['where']['event.time_begin'] = $times;
                    }

                    if ($timee) {
                        $optionnal['where']['event.time_end'] = $timee;
                    }

                }

                if ($status) {
                    if ($area == "event") {
                        $optionnal_status['emp']['event.status_complete'] = $status;
                        $optionnal_status['child']['event.status_complete'] = null;
                        $optionnal_status['vis']['event_visitor.STATUS_COMPLETE'] = null;
                    } elseif ($area == "approve") {
                        $optionnal_status['emp']['event.status_complete'] = null;
                        $optionnal_status['vis']['event_visitor.STATUS_COMPLETE'] = null;

                        if (!$user) {
                            $user = $this->user_code;
                        }

                        if ($status == 1) {
                            $optionnal_status['child']['event.approve_date'] = null;
                            $optionnal_status['child']['event.disapprove_date'] = null;
                            $optionnal_status['child']['event.cancle_date'] = null;
                            $optionnal_status['child']['event.status_complete'] = 1;
                        } elseif ($status == 2) {
                            $optionnal_status['child']['event.approve_date <>'] = null;
                        } elseif ($status == 3) {
                            $optionnal_status['child']['event.disapprove_date <>'] = null;
                        }
                    } elseif ($area == "visitor") {
                        $optionnal_status['emp']['event.status_complete'] = null;
                        $optionnal_status['child']['event.status_complete'] = null;
                        $optionnal_vis['where']['event_visitor.STATUS_COMPLETE'] = $status;

                        if (!$user) {
                            $user = $this->user_code;
                            // $optionnal['where']['event.staff_id <> '] = $this->user_code;
                        }
                    }
                }

                if ($user) {
                    $optionnal['where']['event.staff_id'] = $user;
                }

                if ($permit) {
                    $optionnal['where']['event.user_start'] = $permit;
                }
                if ($type) {
                    $optionnal['where']['event.type_id'] = $type;
                }

            } else {
                $optionnal_status = null;
            }

            $optionnal_e = $optionnal;
            $optionnal_c = $optionnal;
            $optionnal_v = $optionnal;

            if ($user && $user != $this->user_code) {
                $dataShow['me'] = null;

                if ($optionnal_status['child']) {
                    $optionnal_c['where'] = $optionnal_status['child'];
                }

                $optionnal_c['where']['event.staff_id'] = $user;

                $optionnal_c['join'] = "all";

                $dataChild = (array) $this->mdl_event->get_dataShow(null, $optionnal_c);
                if (count($dataChild)) {
                    for ($c = 0; $c < count($dataChild); $c++) {
                        $dataShow['child'][$c] = (array) $dataChild[$c];
                    }
                }

            } elseif ($user && $user == $this->user_code) {
                if ($optionnal_status['emp']) {
                    $optionnal_e['where'] = $optionnal_status['emp'];
                }
                $optionnal_e['where']['event.staff_id'] = $this->user_code;
                $optionnal_e['join'] = "all";

                $dataShow['me'] = $this->mdl_event->get_dataShow(null, $optionnal_e);

                $dataShow['child'] = null;

            } else {
                if ($optionnal_status['emp']) {
                    $optionnal_e['where'] = $optionnal_status['emp'];
                }
                $optionnal_e['where']['event.staff_id'] = $this->user_code;
                $optionnal_e['join'] = "all";

                $dataShow['me'] = $this->mdl_event->get_dataShow(null, $optionnal_e);

                $optionnal_child['where']['roles_focus.staff_owner'] = $this->user_emp;
                $optionnal_child['select'] = "roles_focus.*,employee.NAME,employee.LASTNAME";
                $optionnal_child['join'] = true;
                $child = $this->mdl_role_focus->get_data(null, $optionnal_child);

                $dataChild = [];
                if (count($child)) {

                    $s = 0;
                    foreach ($child as $sid) {
                        $optionnal_staff['where'] = array(
                            'staff.employee_id' => $sid->STAFF_CHILD,
                        );

                        $staff = $this->mdl_staff->get_dataShow(null, $optionnal_staff, "row");

                        if ($optionnal_status['child']) {
                            $optionnal_c['where'] = $optionnal_status['child'];
                        }

                        $optionnal_c['where']['event.staff_id'] = $staff->ID;
                        $optionnal_c['join'] = "all";

                        $dataChild = (array) $this->mdl_event->get_dataShow(null, $optionnal_c);
                        if (count($dataChild)) {
                            for ($c = 0; $c < count($dataChild); $c++) {
                                $dataShow['child'][$s] = (array) $dataChild[$c];
                                $s++;
                            }
                        }

                    }
                }
            }

            $optionnal_vis['select'] = "event_visitor.EVENT_VISITOR,event_visitor.EVENT_CODE,event_visitor.STATUS_COMPLETE,event_visitor.STATUS_REMARK";
            $optionnal_vis['where']['event_visitor.event_visitor'] = $this->user_code;

            $optionnal_vis['join'] = true;
            $vis = $this->mdl_visitor->get_dataShow(null, $optionnal_vis);

            $dataVis = [];
            $data_visitor = [];
            if (count($vis)) {
                $v = 0;
                foreach ($vis as $key => $sid) {
                    $optionnal_v['where']['event.code'] = $sid->EVENT_CODE;
                    $optionnal_v['where']['event.APPROVE_DATE <>'] = null;

                    $optionnal_v['join'] = "all";

                    $dataVis = (array) $this->mdl_event->get_dataShow(null, $optionnal_v);
                    if (count($dataVis)) {
                        foreach ($dataVis as $key => $array) {
                            $data_visitor[$v] = (array) $array;
                            $data_visitor[$v]['VIS_STATUS_COMPLETE'] = $sid->STATUS_COMPLETE;
                            $data_visitor[$v]['VIS_STATUS_REMARK'] = $sid->STATUS_REMARK;
                            $v++;
                        }
                        $dataShow['vis'] = $data_visitor;
                    }
                }
            }
            if (count($dataShow)) {
                $dataall = $this->mdl_event->get_data_all(null, $optionnal);
                $DataTable = $this->foreach_loop($dataShow);
                if ($DataTable) {
                    foreach ($DataTable as $key => $val) {
                        if (!in_array($val, $dataReturn)) {
                            $dataReturn[$key] = $val;
                            $dataReturn[$key]['date_datatable'] = array(
                                "display" => $val['DATE_BEGIN_SHOW'],
                                "timestamp" => date('Y-m-d', strtotime($val['DATE_BEGIN'])),
                            );
                        }

                    }
                }

                $result = array(
                    "recordsTotal" => count($dataReturn),
                    "recordsFiltered" => $dataall,
                    "data" => $dataReturn,
                );
                echo json_encode($result);
            }
        }
    }

    public function get_data_draft()
    {
        $DataTable = [];
        $dataVal = [];
        $dataShow = [];

        if ($this->input->get("event_id") != "") {

            $optionnal['join'] = "all";
            $optionnal['select'] = "event.*
        ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
        ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

            $dataShow[] = $this->mdl_event->get_dataShow($this->input->get('event_id'), $optionnal, "row");

            if (count($dataShow)) {
                $optionnal_emp['select'] = "employee.ID as EMP_ID,employee.NAME as NAME,employee.LASTNAME as LASTNAME";
                $emp = $this->mdl_staff->get_dataShow($dataShow[0]['USER_START'], $optionnal_emp, "row");

                $head = $this->mdl_staff->get_dataShow($dataShow[0]['STAFF_ID'], $optionnal_emp, "row");

                $DataTable = $dataShow;
                $DataTable[0]['EMP_ID'] = $head->EMP_ID;
                $DataTable[0]['USER_START_NAME'] = $emp->NAME;
                $DataTable[0]['USER_START_LNAME'] = $emp->LASTNAME;
                $DataTable[0]['class'] = "draft";
                $DataTable[0]['STATUS_SHOW'] = "แบบร่าง" . $dataShow[0]['TYPE_NAME'] . " #" . $dataShow[0]['CODE'] . "<br>" . $dataShow[0]['STATUS_COMPLETE_NAME'];

                $optionnals['where'] = array(
                    'event_visitor.event_code' => $dataShow[0]["CODE"],
                );
                $visitor = $this->mdl_visitor->get_dataShow(null, $optionnals);
                if (count($visitor)) {
                    $j = 0;
                    foreach ($visitor as $vis_val) {
                        $optionnal_vemp['select'] = "employee.NAME as NAME,employee.LASTNAME as LASTNAME";
                        $optionnal_vemp['where'] = array(
                            'staff.employee_id' => $vis_val->EVENT_VISITOR,
                        );
                        $vis_emp = $this->mdl_staff->get_dataShow(null, $optionnal_vemp, "row");

                        $DataTable[0]['VISITOR'][$j]['EID'] = $vis_val->ID;
                        $DataTable[0]['VISITOR'][$j]['VID'] = $vis_val->EVENT_VISITOR;
                        $DataTable[0]['VISITOR'][$j]['VNAME'] = $vis_emp->NAME;
                        $DataTable[0]['VISITOR'][$j]['VLNAME'] = $vis_emp->LASTNAME;
                        $DataTable[0]['VISITOR'][$j]['VSTATUS'] = $vis_val->STATUS_COMPLETE;
                        $DataTable[0]['VISITOR'][$j]['VREMARK'] = $vis_val->STATUS_REMARK;

                        $j++;
                    }
                }

            }
        } else {

            $optionnal['where'] = array(
                'event.user_start' => $this->user_code,
                'event.type_id >' => 3,
            );
            $optionnal['join'] = "all";
            $optionnal['select'] = "event.*
            ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
            ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

            $dataShow['me'] = $this->mdl_event->get_dataShow(null, $optionnal);

            if (count($dataShow)) {
                $DataTable = $this->foreach_loop($dataShow);
            }
        }

        echo json_encode($DataTable);

    }

    public function insert_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->user_code;
            $code = $this->generate_event_code->gen_code();

            $returns = $this->crud_valid->insert_data($data, $code);
            echo json_encode($returns);
        }
    }

    public function update_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->user_code;
            $code = $data['code'];

            $returns = $this->crud_valid->update_data($data, $code);
            echo json_encode($returns);
        }
    }

    public function delete_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->user_code;

            if ($data['vid']) {
                $returns = $this->crud_valid->reject_visitor($data);
            } else {
                $returns = $this->crud_valid->delete_data($data);
            }
            echo json_encode($returns);
        } else {
            echo "no";
        }
    }

    public function approval()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->user_code;

            $returns = $this->crud_valid->approval($data);
            echo json_encode($returns);
        }
    }

    public function invitation()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->user_code;

            $returns = $this->crud_valid->invitation($data);
            echo json_encode($returns);
        }
    }

    public function processing()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->user_code;

            $returns = $this->crud_valid->processing($data);
            echo json_encode($returns);
        }
    }

    public function restore()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->user_code;

            $returns = $this->crud_valid->restore($data);
            echo json_encode($returns);
        }
    }
}
