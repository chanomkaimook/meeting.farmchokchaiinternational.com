<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ctl_get_userId extends MY_Controller
{
    public $_title;

    public function __construct()
    {
        parent::__construct();

        $this->_title = 'userId';
        $this->load->model(array('mdl_event', 'mdl_staff', 'mdl_visitor'));

        // $this->load->model('mdl_user');
        // $this->load->model('mdl_register');
        // $this->load->model('mdl_staff');
        // $this->load->model('mdl_role_focus');

    }

    public function index()
    {
    }

    public function get_data_filter()
    {
        $array = $this->input->post();
        $eventData = [];
        
            if (count($array)) {
                $optionnal_staff['select'] = "staff.employee_id as EID,
                 employee.code as ECODE,
                 employee.name as NAME,
                employee.lastname as LASTNAME";

                $staff = (array) $this->mdl_staff->get_dataShow($array['sid'], $optionnal_staff, "row");
                

                if (count($staff)) {

                    $optionnal_event['select'] = "event.id as ID,
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
                    event.status_complete as STATUS,
                    event.status_complete_name as STATUS_NAME,
                    event_meeting.ROOMS_ID,
                    event_meeting.ROOMS_NAME,
                    event_car.CAR_ID,
                    event_car.CAR_NAME,
                    event_car.DRIVER_ID,
                    event_car.DRIVER_NAME";
                    
                    $optionnal_event['where'] = array(
                        '(event.date_begin BETWEEN "'.$array['dates'].'" AND "'.$array['datee'].'" or event.date_end BETWEEN "'.$array['dates'].'" AND "'.$array['datee'].'")' => null,
                        // '' => null,
                        'event.staff_id' => $array['sid'],
                        'event.type_id' => $array['type_id'],
                    );

                    $optionnal_event['join'] = "all";
                    $event_main = $this->mdl_event->get_dataShow(null, $optionnal_event);

                    // print_r($event_main);

                    $optionnal_visitor['select'] = "event_visitor.id as VID,
                    event_visitor.event_id as EVENT_ID,
                    event_visitor.event_code as EVENT_CODE,
                    event_visitor.status_complete as VSTATUS,
                    event_visitor.status_remark as VREMARK";

                    $optionnal_visitor['where'] = array(
                        'event_visitor.event_visitor' => $staff['EID'],
                    );

                    $data_visitor = $this->mdl_visitor->get_dataShow(null, $optionnal_visitor);

                    $this_month = date("m");
                    $count = 0;
                    if ($event_main && count($event_main)) {
                        for ($index_head = 0; $index_head < count($event_main); $index_head++) {
                                $event_main[$index_head]->DATE_BEGIN_SHOW = toThaiDateTimeString($event_main[$index_head]->DBEGIN);
                                $event_main[$index_head]->DATE_END_SHOW = toThaiDateTimeString($event_main[$index_head]->DEND);
                                $event_main[$index_head]->TIME_BEGIN_SHOW = toTime($event_main[$index_head]->TBEGIN);
                                $event_main[$index_head]->TIME_END_SHOW = toTime($event_main[$index_head]->TEND);
                                $eventData[$count] = $event_main[$index_head];
                            
                                $count++;
                        }
                    }

                    if ($data_visitor && count($data_visitor)) {
                        $optionnal_event['where'] = [];
                        $count += 1;
                        for ($index_vis = 0; $index_vis < count($data_visitor); $index_vis++) {
                            $event_visitor = (array) $this->mdl_event->get_dataShow($data_visitor[$index_vis]->EVENT_ID, $optionnal_event, "row");
                            if ($event_visitor) {
                                    $event_visitor[$index_vis]->DATE_BEGIN_SHOW = toThaiDateTimeString($event_visitor[$index_vis]->DBEGIN);
                                    $event_visitor[$index_vis]->DATE_END_SHOW = toThaiDateTimeString($event_visitor[$index_vis]->DEND);
                                    $event_visitor[$index_vis]->TIME_BEGIN_SHOW = toTime($event_visitor[$index_vis]->TBEGIN);
                                    $event_visitor[$index_vis]->TIME_END_SHOW = toTime($event_visitor[$index_vis]->TEND);
                                    $eventData[$count] = $event_visitor[$index_vis];
                                
                                    $count++;
                            }
                        }
                    }


                    if (!count($eventData)) {
                        $eventData['error'] = 0;
                        $eventData['msg'] = "ไม่มีข้อมูล";
                    }
                    $eventData['sid'] = $array['sid'];

                }
                echo json_encode($eventData);
            }
        
    }

    public function get_data()
    {
        $userId = $this->input->post("userId");
        $type_id = $this->input->post("type_id");
        $eventData = [];
        
            if ($userId || $type_id) {
                $optionnal_staff['select'] = "staff.id as SID,
                 staff.employee_id as EID,
                 employee.code as ECODE,
                 employee.name as NAME,
                employee.lastname as LASTNAME";

                $optionnal_staff['where']["user_id"] = $userId;
                $staff = (array) $this->mdl_staff->get_dataShow(null, $optionnal_staff, "row");

                if (count($staff)) {

                    $optionnal_event['select'] = "event.id as ID,
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
                    event.status_complete as STATUS,
                    event.status_complete_name as STATUS_NAME,
                    event_meeting.ROOMS_ID,
                    event_meeting.ROOMS_NAME,
                    event_car.CAR_ID,
                    event_car.CAR_NAME,
                    event_car.DRIVER_ID,
                    event_car.DRIVER_NAME";

                    $optionnal_event['where'] = array(
                        'event.staff_id' => $staff['SID'],
                        'event.type_id' => $type_id,
                    );

                    $optionnal_event['join'] = "all";
                    $event_main = $this->mdl_event->get_dataShow(null, $optionnal_event);

                    $optionnal_visitor['select'] = "event_visitor.id as VID,
                    event_visitor.event_id as EVENT_ID,
                    event_visitor.event_code as EVENT_CODE,
                    event_visitor.status_complete as VSTATUS,
                    event_visitor.status_remark as VREMARK";

                    $optionnal_visitor['where'] = array(
                        'event_visitor.event_visitor' => $staff['EID'],
                    );

                    $data_visitor = $this->mdl_visitor->get_dataShow(null, $optionnal_visitor);

                    $this_month = date("m");
                    $count = 0;
                    if ($event_main && count($event_main)) {
                        for ($index_head = 0; $index_head < count($event_main); $index_head++) {
                            $months = date("m", strtotime($event_main[$index_head]->DBEGIN));
                            $monthe = date("m", strtotime($event_main[$index_head]->DEND));
                            
                            if ($months == $this_month || $monthe == $this_month) {
                                $event_main[$index_head]->DATE_BEGIN_SHOW = toThaiDateTimeString($event_main[$index_head]->DBEGIN);
                                $event_main[$index_head]->DATE_END_SHOW = toThaiDateTimeString($event_main[$index_head]->DEND);
                                $event_main[$index_head]->TIME_BEGIN_SHOW = toTime($event_main[$index_head]->TBEGIN);
                                $event_main[$index_head]->TIME_END_SHOW = toTime($event_main[$index_head]->TEND);
                                $eventData[$count] = $event_main[$index_head];
                                
                            
                                $count++;
                            }
                        }
                    }

                    if ($data_visitor && count($data_visitor)) {
                        $optionnal_event['where'] = [];
                        $count += 1;
                        for ($index_vis = 0; $index_vis < count($data_visitor); $index_vis++) {
                            $event_visitor = (array) $this->mdl_event->get_dataShow($data_visitor[$index_vis]->EVENT_ID, $optionnal_event, "row");
                            if ($event_visitor) {
                                $months = date("m", strtotime($event_visitor[$index_vis]->DBEGIN));
                                $monthe = date("m", strtotime($event_visitor[$index_vis]->DEND));
                                
                                if ($months == $this_month || $monthe == $this_month) {
                                    $event_visitor[$index_vis]->DATE_BEGIN_SHOW = toThaiDateTimeString($event_visitor[$index_vis]->DBEGIN);
                                    $event_visitor[$index_vis]->DATE_END_SHOW = toThaiDateTimeString($event_visitor[$index_vis]->DEND);
                                    $event_visitor[$index_vis]->TIME_BEGIN_SHOW = toTime($event_visitor[$index_vis]->TBEGIN);
                                    $event_visitor[$index_vis]->TIME_END_SHOW = toTime($event_visitor[$index_vis]->TEND);
                                    $eventData[$count] = $event_visitor[$index_vis];
                                    
                                
                                    $count++;
                                }
                            }
                        }
                    }

                    if (!count($eventData)) {
                        $eventData['error'] = 0;
                        $eventData['msg'] = "ไม่มีข้อมูล";
                    }
                    $eventData['sid'] = $staff['SID'];
                }
                echo json_encode($eventData);
            }
        
    }

}
