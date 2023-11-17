<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_calendar extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_calendar', 'mdl_event', 'mdl_role_focus', 'mdl_visitor', 'mdl_rooms', 'mdl_employee'));
        $this->load->libraries(array('generate_event_code', 'crud_valid', 'format_date'));

    }

    public function index()
    {
        // echo $this->my_id."----------------------------------------------------";
        $optionnals['where'] = array(
            'roles_focus.staff_owner = ' . $this->my_id . ' OR employee.id = ' . $this->my_id => null,
        );
        $optionnals['select'] = "roles_focus.*,employee.NAME,employee.LASTNAME";
        $optionnals['join'] = true;
        $data['staff'] = $this->mdl_role_focus->get_data(null, $optionnals);

        $data['time'] = $this->mdl_calendar->get_time();

        $optionnalr['where'] = array(
            'branch' => "สำนักงานรังสิต",
        );
        $data['room'] = $this->mdl_rooms->get_data(null, $optionnalr);
        $data['employee'] = $this->mdl_employee->get_dataShow();

        $this->template->set_layout('lay_calendar');
        $this->template->title($this->_title);
        $this->template->build('calendar', $data);
    }

    public function status($status_complete, $child = null)
    {
        $status_pending_soft = "bg-pending-soft";
        $status_pending = "bg-pending";
        $status_success_soft = "bg-success-soft";
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
// print_r($child);
        // die;
        if ($status_complete == 1) {
            $color = $status_pending;
            $color_child = $status_pending_soft;
            $status = "รอดำเนินการ";
            $status_vis = "รอตอบรับ";
            $status_child = "รออนุมัติ";
        } else if ($status_complete == 2) {
            $color = $status_success;
            $color_child = $status_success_soft;
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
            $color = $status_pending;
            $color_child = $status_pending_soft;
            $status = "กำลังดำเนินการ";
            $status_vis = "กำลังดำเนินการ";
            $status_child = "กำลังดำเนินการ";
        }

        //
        // ตรวจสอบ สถานะ
        if ($child == "me" || $child == "child") {
            $event_color = $color;
            $event_status = $status;
        } else if ($child == "other") {
            $event_color = $color_child;
            $event_status = $status;
        } else if ($child == "owner") {
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

    public function foreach_loop($dataShow)
    {
        $i = 0;

        $Calendar = array();

        // print_r($dataShow);die;
        if ($dataShow) {
            foreach ($dataShow as $key => $val) {

                if ($val) {
                    foreach ($val as $sub_key => $value) {
                        $dataVal = (array) $value;
                        if ($dataVal['VIS_STATUS_COMPLETE']) {
                            $state = 'vis';
                        } else if ($dataVal['STAFF_ID'] == $this->my_id && $dataVal['USER_START'] == $this->my_id) {
                            $state = "me";
                        } else if ($dataVal['STAFF_ID'] != $this->my_id && $dataVal['USER_START'] != $this->my_id) {
                            $state = 'other';
                        } else if ($dataVal['STAFF_ID'] != $this->my_id && $dataVal['USER_START'] == $this->my_id) {
                            $state = 'owner';
                        } else if ($dataVal['STAFF_ID'] == $this->my_id && $dataVal['USER_START'] != $this->my_id) {
                            $state = 'child';
                        }

                        $attr = $this->status($dataVal["STATUS_COMPLETE"], $state);

                        $optionnal_emp['select'] = "employee.NAME as NAME,employee.LASTNAME as LASTNAME";
                        $emp = $this->mdl_employee->get_dataShow($dataVal['USER_START'], $optionnal_emp);

                        $head = $this->mdl_employee->get_dataShow($dataVal['STAFF_ID'], $optionnal_emp);

                        $Calendar[$i] = $dataVal;
                        $Calendar[$i]['DATE_BEGIN_SHOW'] = toThaiDateTimeString($dataVal['DATE_BEGIN']);
                        $Calendar[$i]['DATE_END_SHOW'] = toThaiDateTimeString($dataVal['DATE_END']);
                        $Calendar[$i]['TIME_BEGIN_SHOW'] = date('H:i', strtotime($dataVal['TIME_BEGIN']));
                        $Calendar[$i]['TIME_END_SHOW'] = date('H:i', strtotime($dataVal['TIME_END']));
                        $Calendar[$i]['HEAD_NAME'] = $head[0]->NAME;
                        $Calendar[$i]['HEAD_LNAME'] = $head[0]->LASTNAME;
                        $Calendar[$i]['HEAD_FULLNAME'] = $head[0]->NAME . " " . $head[0]->LASTNAME;
                        $Calendar[$i]['USER_START_NAME'] = $emp[0]->NAME;
                        $Calendar[$i]['USER_START_LNAME'] = $emp[0]->LASTNAME;
                        $Calendar[$i]['USER_START_FULLNAME'] = $emp[0]->NAME . " " . $emp[0]->LASTNAME;
                        $Calendar[$i]['start'] = $dataVal["DATE_BEGIN"];
                        $Calendar[$i]['end'] = date('Y-m-d', strtotime($dataVal["DATE_END"] . "+ 1 days"));
                        $Calendar[$i]['title'] = $dataVal["EVENT_NAME"];
                        $Calendar[$i]['className'] = $attr['color'];
                        $Calendar[$i]['STATUS_SHOW'] = $attr['status'];
                        $Calendar[$i]['class'] = $state;
                        // $Calendar[$i]['test_day'] = date('W', strtotime($dataVal['DATE_END']));

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
                                $Calendar[$i]['VISITOR'][$j]['EID'] = $vis_val->ID;
                                $Calendar[$i]['VISITOR'][$j]['VID'] = $vis_val->EVENT_VISITOR;
                                $Calendar[$i]['VISITOR'][$j]['VNAME'] = $vis_val->NAME;
                                $Calendar[$i]['VISITOR'][$j]['VLNAME'] = $vis_val->LASTNAME;
                                $Calendar[$i]['VISITOR'][$j]['VSTATUS'] = $vis_val->STATUS_COMPLETE;
                                $Calendar[$i]['VISITOR'][$j]['VREMARK'] = $vis_val->STATUS_REMARK;

                                $j++;
                            }
                        }
                        $i++;
                    }
                }
                // echo "<pre>";
                // print_r($dataVal);
            }
        }
        return $Calendar;
    }

    public function get_data()
    {
        $Calendar = [];
        $dataShow = [];
        $array = $this->input->post();

        $optionnal['where']['event.date_begin <> '] = "0000-00-00";
        $optionnal['where']['event.date_end <> '] = "0000-00-00";
        $optionnal['where']['event.type_id <'] = 4;
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
                        $user = $this->my_id;
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
                        $optionnal['where']['event.staff_id <> '] = $this->my_id;
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
            // $optionnal['where']['event.staff_id'] = $this->my_id;
        }

        $optionnal_e = $optionnal;
        $optionnal_c = $optionnal;
        $optionnal_v = $optionnal;

        if ($user && $user != $this->my_id) {
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

        } elseif ($user && $user == $this->my_id) {
            if ($optionnal_status['emp']) {
                $optionnal_e['where'] = $optionnal_status['emp'];
            }
            $optionnal_e['where']['event.staff_id'] = $this->my_id;
            $optionnal_e['join'] = "all";

            $dataShow['me'] = $this->mdl_event->get_dataShow(null, $optionnal_e);

            $dataShow['child'] = null;

        } else {
            if ($optionnal_status['emp']) {
                $optionnal_e['where'] = $optionnal_status['emp'];
            }
            $optionnal_e['where']['event.staff_id'] = $this->my_id;
            $optionnal_e['join'] = "all";

            $dataShow['me'] = $this->mdl_event->get_dataShow(null, $optionnal_e);

            $optionnal_child['where']['roles_focus.staff_owner'] = $this->my_id;
            $optionnal_child['select'] = "roles_focus.*,employee.NAME,employee.LASTNAME";
            $optionnal_child['join'] = true;
            $child = $this->mdl_role_focus->get_data(null, $optionnal_child);

            $dataChild = [];
            if (count($child)) {

                foreach ($child as $sid) {
                    if ($optionnal_status['child']) {
                        $optionnal_c['where'] = $optionnal_status['child'];
                    }
                    $optionnal_c['where']['event.staff_id'] = $sid->STAFF_CHILD;
                    $optionnal_c['join'] = "all";

                    $dataChild = (array) $this->mdl_event->get_dataShow(null, $optionnal_c);
                    if (count($dataChild)) {
                        for ($c = 0; $c < count($dataChild); $c++) {
                            $dataShow['child'][$c] = (array) $dataChild[$c];
                        }
                    }

                }
            }
        }

        $optionnal_vis['select'] = "event_visitor.EVENT_VISITOR,event_visitor.EVENT_CODE,event_visitor.STATUS_COMPLETE,event_visitor.STATUS_REMARK";
        $optionnal_vis['where']['event_visitor.event_visitor'] = $this->my_id;

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
            $Calendar = $this->foreach_loop($dataShow);
            echo json_encode($Calendar);
        }
    }

    public function get_data_draft()
    {
        $Calendar = [];
        $dataVal = [];
        $dataShow = [];

        if ($this->input->get("event_id") != "") {

            $optionnal['join'] = "all";
            $optionnal['select'] = "event.*
        ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
        ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

            $dataShow[] = $this->mdl_event->get_dataShow($this->input->get('event_id'), $optionnal, "row");

            if (count($dataShow)) {
                $optionnal_emp['select'] = "employee.NAME as NAME,employee.LASTNAME as LASTNAME";
                $emp = $this->mdl_employee->get_dataShow($dataShow[0]['USER_START'], $optionnal_emp);

                $Calendar = $dataShow;
                $Calendar[0]['USER_START_NAME'] = $emp[0]->NAME;
                $Calendar[0]['USER_START_LNAME'] = $emp[0]->LASTNAME;
                $Calendar[0]['class'] = "draft";
                $Calendar[0]['STATUS_SHOW'] = "แบบร่าง";

                $optionnals['where'] = array(
                    'event_visitor.event_code' => $dataShow[0]["CODE"],
                );
                $visitor = $this->mdl_visitor->get_dataShow(null, $optionnals);
                if (count($visitor)) {
                    $j = 0;
                    foreach ($visitor as $vis_val) {
                        $Calendar[0]['VISITOR'][$j]['EID'] = $vis_val->ID;
                        $Calendar[0]['VISITOR'][$j]['VID'] = $vis_val->EVENT_VISITOR;
                        $Calendar[0]['VISITOR'][$j]['VNAME'] = $vis_val->NAME;
                        $Calendar[0]['VISITOR'][$j]['VLNAME'] = $vis_val->LASTNAME;
                        $Calendar[0]['VISITOR'][$j]['VSTATUS'] = $vis_val->STATUS_COMPLETE;
                        $Calendar[0]['VISITOR'][$j]['VREMARK'] = $vis_val->STATUS_REMARK;

                        $j++;
                    }
                }

            }
        } else {

            $optionnal['where'] = array(
                'event.user_start' => $this->my_id,
                'event.type_id >' => 3,
            );
            $optionnal['join'] = "all";
            $optionnal['select'] = "event.*
            ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
            ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

            $dataShow['me'] = $this->mdl_event->get_dataShow(null, $optionnal);

            // echo $this->db->last_query();
            $optionnal_child['where'] = array(
                'staff_owner' => $this->my_id,
            );

            $optionnal_child['select'] = "roles_focus.*,employee.NAME,employee.LASTNAME";
            $optionnal_child['join'] = true;
            $child = $this->mdl_role_focus->get_data(null, $optionnal_child);

            $dataChild = [];
            if (count($child)) {
                foreach ($child as $sid) {
                    $optionnal['where'] = array(
                        'event.staff_id' => $sid->STAFF_CHILD,
                        'event.user_start' => $this->my_id,
                        'event.type_id >' => 3,
                    );
                    $optionnal['join'] = "all";

                    $dataChild = (array) $this->mdl_event->get_dataShow(null, $optionnal);
                    if (count($dataChild)) {
                        $dataShow['child'] = $dataChild;
                    }
                }
            }

            if (count($dataShow)) {
                $Calendar = $this->foreach_loop($dataShow);
            }
        }

        echo json_encode($Calendar);
    }

    public function insert_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->my_id;
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
            $data['user_action'] = $this->my_id;
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
            $data['user_action'] = $this->my_id;

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
            $data['user_action'] = $this->my_id;

            $returns = $this->crud_valid->approval($data);
            echo json_encode($returns);
        }
    }

    public function invitation()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->my_id;

            $returns = $this->crud_valid->invitation($data);
            echo json_encode($returns);
        }
    }

    public function processing()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->my_id;

            $returns = $this->crud_valid->processing($data);
            echo json_encode($returns);
        }
    }

    public function restore()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
            $data['user_action'] = $this->my_id;

            $returns = $this->crud_valid->restore($data);
            echo json_encode($returns);
        }
    }
}
