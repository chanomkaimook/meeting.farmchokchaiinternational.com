<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_calendar extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'ตารางนัดหมาย';
        $this->load->model(array('mdl_calendar', 'mdl_event', 'mdl_role_focus', 'mdl_visitor', 'mdl_rooms'));
        $this->load->libraries(array('generate_event_code', 'crud_valid'));

    }

    public function index()
    {
        $optionnals['where'] = array(
            'roles_focus.staff_owner = 0 OR employee.id = 0' => null,
        );
        $optionnals['select'] = "roles_focus.*,employee.NAME,employee.LASTNAME";
        $optionnals['join'] = true;
        $data['staff'] = $this->mdl_role_focus->get_data(null, $optionnals);

        $data['time'] = $this->mdl_calendar->get_time();

        $optionnalr['where'] = array(
            'branch' => "สำนักงานรังสิต",
        );
        $data['room'] = $this->mdl_rooms->get_data(null, $optionnalr);

        $this->template->set_layout('lay_calendar');
        $this->template->title($this->_title);
        $this->template->build('calendar', $data);
    }

    public function status_color($status_complete, $child = null)
    {
        $status_pending_soft = "bg-pending-soft";
        $status_pending = "bg-pending";
        $status_success_soft = "bg-success-soft";
        $status_success = "bg-success";
        $status_failure_soft = "bg-failure-soft";
        $status_failure = "bg-failure";
        $status_other = "bg-other";
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
        } else {
            $color = $status_process;
            $color_child = $status_process;
            $status = "กำลังดำเนินการ";
            $status_vis = "";
            $status_child = "";
        }

        //
        // ตรวจสอบ สถานะ
        if ($child == "other") {
            $event_color = $status_other;
            $event_status = "";
        } else if ($child == "vis") {
            $event_color = $color_child;
            $event_status = $status_vis;
        } else if ($child == "child") {
            $event_color = $color_child;
            $event_status = $status_child;
        } else {
            $event_color = $color;
            $event_status = $status;
        }
        $return = array(
            'status' => $event_status,
            'color' => $event_color,
        );

        return $return;
    }

    public function get_data()
    {
        $Calendar = [];
        $dataVal = [];
        $dataShow = [];

        $optionnal['where'] = array(
            'event.staff_id' => 0,
            'event.type_id <' => 3,
        );
        $optionnal['join'] = "all";
        $optionnal['select'] = "event.*
        ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
        ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

        $dataShow[] = $this->mdl_event->get_dataShow(null, $optionnal);

        $optionnal_child['where'] = array(
            'staff_owner' => 0,
        );
        $optionnal_child['select'] = "roles_focus.*,employee.NAME,employee.LASTNAME";
        $optionnal_child['join'] = true;
        $child = $this->mdl_role_focus->get_data(null, $optionnal_child);

        if (count($child)) {
            foreach ($child as $sid) {
                $optionnal['where'] = array(
                    'event.staff_id' => $sid->STAFF_CHILD,
                    'event.type_id <' => 3,
                );
                $optionnal['join'] = "all";

                $dataShow['child'][] = $this->mdl_event->get_dataShow(null, $optionnal, 'row');
            }
        }

        $optionnal_vis['select'] = "event_visitor.EVENT_CODE";
        $optionnal_vis['where'] = array(
            "event_visitor.event_visitor" => 0,
        );
        $optionnal_vis['join'] = true;
        $vis = $this->mdl_visitor->get_dataShow(null, $optionnal_vis);
// echo $this->db->last_query();
        if (count($vis)) {
            foreach ($vis as $sid) {
                $optionnal['where'] = array(
                    'event.code' => $sid->EVENT_CODE,
                    'event.type_id <' => 3,
                );
                $optionnal['join'] = "all";

                $dataShow['vis'][] = $this->mdl_event->get_dataShow(null, $optionnal, 'row');
            }
        }

        if (count($dataShow)) {
            $i = 0;
            foreach ($dataShow as $key => $val) {
                foreach ($val as $sub_key => $value) {
                    $dataVal = (array) $value;
                    if ($dataVal['STAFF_ID'] == 0) {
                        $child = null;
                    } else if ($dataVal['STAFF_ID'] != 0 && $dataVal['USER_START'] == 0) {
                        $child = 'child';
                    } else if ($dataVal['STAFF_ID'] != 0 && $dataVal['USER_START'] != 0 && $key != 'vis') {
                        $child = 'other';
                    } else if ($key == "vis") {
                        $child = 'vis';
                    }

                    $attr = $this->status_color($dataVal["STATUS_COMPLETE"], $child);

                    $Calendar[$i] = $dataVal;
                    $Calendar[$i]['start'] = $dataVal["DATE_BEGIN"];
                    $Calendar[$i]['end'] = $dataVal["DATE_END"];
                    $Calendar[$i]['title'] = $dataVal["EVENT_NAME"];
                    $Calendar[$i]['className'] = $attr['color'];
                    $Calendar[$i]['STATUS_SHOW'] = $attr['status'];
                    $Calendar[$i]['class'] = $child;

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
                // print_r($key);
            }
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
                $i = 0;
                foreach ($dataShow as $key => $value) {
                    $dataVal = (array) $value;
                    $Calendar[$i] = $dataVal;

                    $optionnals['where'] = array(
                        'event_visitor.event_code' => $dataVal["CODE"],
                    );
                    $visitor = $this->mdl_visitor->get_dataShow(null, $optionnals);
                    if (count($visitor)) {
                        foreach ($visitor as $vis_val) {
                            $Calendar[$i]['VISITOR'][] = $vis_val->EVENT_VISITOR;
                        }
                    }
                    $i++;
                }
            }
        } else {

            $optionnal['where'] = array(
                'event.staff_id' => 0,
                'event.type_id >' => 2,
            );
            $optionnal['join'] = "all";
            $optionnal['select'] = "event.*
            ,event_meeting.ROOMS_ID,event_meeting.ROOMS_NAME
            ,event_car.CAR_ID,event_car.CAR_NAME,event_car.DRIVER_ID,event_car.DRIVER_NAME";

            $dataShow[] = $this->mdl_event->get_dataShow(null, $optionnal);

            $optionnal_child['where'] = array(
                'staff_owner' => 0,
            );
            $optionnal_child['select'] = "roles_focus.*,employee.NAME,employee.LASTNAME";
            $optionnal_child['join'] = true;
            $child = $this->mdl_role_focus->get_data(null, $optionnal_child);

            if (count($child)) {
                foreach ($child as $sid) {
                    $optionnal['where'] = array(
                        'event.staff_id' => $sid->STAFF_CHILD,
                        'event.type_id >' => 2,
                    );
                    $optionnal['join'] = "all";

                    $dataShow[] = $this->mdl_event->get_dataShow(null, $optionnal);
                }
            }

            if (count($dataShow)) {
                $i = 0;
                foreach ($dataShow as $index => $item) {
                    foreach ($item as $key => $value) {
                        $dataVal = (array) $value;
                        $Calendar[$i] = $dataVal;
                        $Calendar[$i]['start'] = $dataVal["DATE_BEGIN"];
                        $Calendar[$i]['end'] = $dataVal["DATE_END"];
                        $Calendar[$i]['title'] = $dataVal["EVENT_NAME"];

                        $optionnals['where'] = array(
                            'event_visitor.event_code' => $dataVal["CODE"],
                        );
                        $visitor = $this->mdl_visitor->get_dataShow(null, $optionnals);
                        if (count($visitor)) {
                            foreach ($visitor as $vis_val) {
                                $Calendar[$i]['VISITOR'][] = $vis_val->EVENT_VISITOR;
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        // echo $this->db->last_query();
        echo json_encode($Calendar);
    }

    public function insert_data()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();
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

            $returns = $this->crud_valid->delete_data($data);
            echo $returns;
        } else {
            echo "no";
        }
    }

    public function approval()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();

            $returns = $this->crud_valid->approval($data);
            echo json_encode($returns);
        }
    }

    public function invitation()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();

            $returns = $this->crud_valid->invitation($data);
            echo json_encode($returns);
        }
    }

    public function processing()
    {
        # code...
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $data = $this->input->post();

            $returns = $this->crud_valid->processing($data);
            echo $returns;
        } else {
            echo "no";
        }
    }
}
