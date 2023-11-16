<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class CRUD_Valid
{
    // private $path_barcode = FCPATH . 'asset/image/barcode/';

    public function __construct()
    {

        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $ci->load->model(array('mdl_event', 'mdl_event_meeting', 'mdl_visitor'));
    }

    public function auto_approve($event_id = null, $event_code = null, $user_action = null)
    {
        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//
        $return = [];
        if ($event_id && $event_code && $user_action) {

            $return['error'] = 0;

            $optionnal['select'] = 'user_start,staff_id';
            $get_data = $ci->mdl_event->get_dataShow($event_id, $optionnal, "row");
            if ($get_data['user_start'] == $get_data['staff_id']) {

                if ($get_data['user_start'] == $user_action || $get_data['staff_id'] == $user_action) {
                    $return['auto_approve'] = 1;
                } else {
                    $return['auto_approve'] = 0;
                }
            } else {
                $return['auto_approve'] = 0;
            }
        } else {
            $return['error'] = 1;
        }
        return $return;
    }

    public function value_not_null($data = [], $type = null, $type_id = null)
    {
        if (count($data) && $type && $type_id) {
            $array = [];
            $attr = [];
            $error = [];
            $result = [];
            if ($type == 'insert') {
                $array = ['insert-name',
                    'insert-head',
                    'insert-description',
                    'insert-dates',
                    'insert-datee',
                    'insert-times',
                    'insert-timee',
                ];

                if ($type_id == 1) {
                    array_push($array, 'insert-rooms-id', 'insert-rooms-name');
                } elseif ($type_id == 2) {
                    array_push($array, 'insert-car-id', 'insert-car-name', 'insert-driver-id', 'insert-driver-name');
                } elseif ($type_id == 3) {
                    array_push($array, 'insert-meeting-id', 'insert-meeting-name');
                } else {
                    $array = ['insert-name',
                        'insert-head',
                    ];
                }

                for ($i = 0; $i < count($array); $i++) {
                    foreach ($data as $key => $value) {
                        $attr[$array[$i]] = "error";
                        if ($key == $array[$i] && $value != "") {
                            $attr[$array[$i]] = null;
                            break;
                        }

                    }

                }
                foreach ($attr as $index => $item) {

                    if ($item) {
                        $error['error'][] = $index;
                    }
                }
                $result = $error;
            } else if ($type == 'update') {
                $array = ['item_id',
                    'code',
                    'update-type-id',
                    'update-type-name',
                    'update-name',
                    'update-head',
                    'update-description',
                    'update-dates',
                    'update-datee',
                    'update-times',
                    'update-timee',
                    'user_action',
                ];
                if ($type_id == 1) {
                    array_push($array, 'update-rooms-id', 'update-rooms-name');
                } elseif ($type_id == 2) {
                    array_push($array, 'update-car-id', 'update-car-name', 'update-driver-id', 'update-driver-name');
                } elseif ($type_id == 3) {
                    array_push($array, 'update-meeting-name');
                } else {
                    $array = ['item_id',
                        'code',
                        'update-type-id',
                        'update-type-name',
                        'update-name',
                        'update-head',
                    ];
                }

                for ($i = 0; $i < count($array); $i++) {
                    foreach ($data as $key => $value) {
                        $attr[$array[$i]] = "error";
                        if ($key == $array[$i] && $value != "") {
                            $attr[$array[$i]] = null;
                            break;
                        }

                    }

                }
                foreach ($attr as $index => $item) {

                    if ($item) {
                        $error['error'][] = $index;
                    }
                }
                $result = $error;
            }
        } else {
            $result['error'][] = 'ไม่พบข้อมูล';
        }
        return $result;
    }

    public function insert_data($data = [], $code)
    {
        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $result['error'][] = 'ไม่มีการทำรายการ';

        if (count($data) && $code) {
            $check = $this->value_not_null($data, "insert", $data['insert-type-id']);
            // echo "<pre>";
            // print_r($check);
            // echo "</pre>";die;
            if (!$check['error']) {
                
                
                $date_begin = null;
                $date_end = null;

                if($data['insert-dates'])
                {
                    $date_begin = $data['insert-dates'];
                }
                if($data['insert-datee'])
                {
                $date_end = $data['insert-datee'];
                }
                

                $type_id = $data['insert-type-id'];
                $type_name = $data['insert-type-name'];
                $event_name = $data['insert-name'];
                $staff_id = $data['insert-head'];
                $event_description = $data['insert-description'];
                // $date_begin = $data['insert-dates'];
                // $date_end = $data['insert-datee'];
                $time_begin = $data['insert-times'];
                $time_end = $data['insert-timee'];
                $rooms_id = $data['insert-rooms-id'];
                $rooms_name = $data['insert-rooms-name'];
                $meeting_id = $data['insert-meeting-id'];
                $meeting_name = $data['insert-meeting-name'];
                $car_id = $data['insert-car-id'];
                $car_name = $data['insert-car-name'];
                $driver_id = $data['insert-driver-id'];
                $driver_name = $data['insert-driver-name'];
                $user_action = $data['user_action'];

                $visitor = $data['visitor'];

                if ($type_id == 1 || $type_id == 4) {
                    $code = "R" . $code;
                } elseif ($type_id == 2 || $type_id == 5) {
                    $code = "C" . $code;
                } elseif ($type_id == 3 || $type_id == 6) {
                    $code = "M" . $code;
                }

                $dataArray = array(
                    'code' => $code,
                    'type_id' => $type_id,
                    'type_name' => $type_name,
                    'event_name' => $event_name,
                    'staff_id' => $staff_id,
                    'event_description' => $event_description,
                    'date_begin' => $date_begin,
                    'date_end' => $date_end,
                    'time_begin' => $time_begin,
                    'time_end' => $time_end,
                    /* 'status_complete' => 1,
                    'status_complete_name' => "รอดำเนินการ", */
                    'status' => 1,
                    'date_start' => date('Y-m-d H:i:s'),
                    'user_start' => $user_action,
                );
                if ($type_id < 4) {
                    if ($staff_id == $user_action) {
                        $dataArray['approve_date'] = date('Y-m-d H:i:s');
                        $dataArray['user_action'] = $user_action;
                        $dataArray['status_complete'] = 5;
                        $dataArray['status_complete_name'] = "กำลังดำเนินการ";
                    } else {
                        $dataArray['status_complete'] = 1;
                        $dataArray['status_complete_name'] = "รอดำเนินการ";
                    }
                } else {
                    $dataArray['status_complete'] = 4;
                    $dataArray['status_complete_name'] = $type_name;
                }

                $main = $ci->mdl_event->insert_data($dataArray);

                if (!$main['error']) {
                    if ($type_id == 1 || $type_id == 4 || $type_id == 3 || $type_id == 6) {
                        $SubDataArray = array(
                            'event_code' => $code,
                            'event_id' => $main['data']['id'],
                            'staff_id' => $staff_id,
                            'date_start' => date('Y-m-d H:i:s'),
                            'status' => 1,

                            'user_start' => $user_action,
                        );

                        if ($type_id == 1 || $type_id == 4) {
                            $SubDataArray['rooms_id'] = $rooms_id;
                            $SubDataArray['rooms_name'] = $rooms_name;
                        } elseif ($type_id == 3 || $type_id == 6) {
                            $SubDataArray['rooms_id'] = $meeting_id;
                            $SubDataArray['rooms_name'] = $meeting_name;
                        }
                        $ci->mdl_event_meeting->insert_data($SubDataArray);

                    } elseif ($type_id == 2 || $type_id == 5) {
                        $SubDataArray = array(
                            'code' => $code,
                            'event_id' => $main['data']['id'],
                            'staff_id' => $staff_id,
                            'car_id' => $car_id,
                            'car_name' => $car_name,
                            'driver_id' => $driver_id,
                            'driver_name' => $driver_name,
                            'date_start' => date('Y-m-d H:i:s'),
                            'status' => 1,

                            'user_start' => $user_action,
                        );

                        // $ci->mdl_event_car->insert_data($SubDataArray);
                    }

                    if ($visitor) {
                        $visArray = explode(",", $visitor);
                        $VisitorArray = '';
                        foreach ($visArray as $sid) {
                            $VisitorArray = array(
                                'event_code' => $code,
                                'event_id' => $main['data']['id'],
                                'event_visitor' => $sid,
                                'status_complete' => 1,
                                'status' => 1,
                                'date_start' => date('Y-m-d H:i:s'),
                                'user_start' => $user_action,
                            );
                            $vis = $ci->mdl_visitor->insert_data($VisitorArray);
                        }
                    }

                    /* if ($dataArray['staff_id'] == $dataArray['user_start']) {
                    $item = [];
                    $item['item_id'] = $main['data']['id'];
                    $item['item_code'] = $code;
                    $item['item_data'] = 2;

                    $this->approval($item);
                    } */
                    $return = $main;
                }
            } else {
                $return = $check;
            }
        }

        return $return;
    }

    public function update_data($data = [], $code)
    {
        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $result['error'][] = 'ไม่มีการทำรายการ';

        if (count($data) && $code) {
            $check = $this->value_not_null($data, "update", $data['update-type-id']);
            // echo "<pre>";
            // print_r($check);
            // echo "</pre>";die;
            if (!$check['error']) {
                $item_id = $data['item_id'];
                $type_id = $data['update-type-id'];
                $type_name = $data['update-type-name'];
                $event_name = $data['update-name'];
                $staff_id = $data['update-head'];
                $event_description = $data['update-description'];
                $date_begin = $data['update-dates'];
                $date_end = $data['update-datee'];
                $time_begin = $data['update-times'];
                $time_end = $data['update-timee'];
                $rooms_id = $data['update-rooms-id'];
                $rooms_name = $data['update-rooms-name'];
                $meeting_id = $data['update-meeting-id'];
                $meeting_name = $data['update-meeting-name'];
                $car_id = $data['update-car-id'];
                $car_name = $data['update-car-name'];
                $driver_id = $data['update-driver-id'];
                $driver_name = $data['update-driver-name'];
                $user_action = $data['user_action'];

                $visitor = $data['visitor'];

                $dataArray = array(
                    'type_id' => $type_id,
                    'type_name' => $type_name,
                    'event_name' => $event_name,
                    'staff_id' => $staff_id,
                    'event_description' => $event_description,
                    'date_begin' => $date_begin,
                    'date_end' => $date_end,
                    'time_begin' => $time_begin,
                    'time_end' => $time_end,
                    'date_update' => date('Y-m-d'),
                    'user_update' => $user_action,
                );

                $main = $ci->mdl_event->update_data($dataArray, $item_id);

                if (!$main['error']) {
                    if ($type_id == 1 || $type_id == 4 || $type_id == 3 || $type_id == 6) {

                        $SubDataArray = array(
                            'staff_id' => $staff_id,

                            'user_update' => $user_action,
                            'date_update' => date('Y-m-d H:i:s'),
                        );

                        if ($type_id == 1 || $type_id == 4) {
                            $SubDataArray['rooms_id'] = $rooms_id;
                            $SubDataArray['rooms_name'] = $rooms_name;
                        } elseif ($type_id == 3 || $type_id == 6) {
                            $SubDataArray['rooms_id'] = $meeting_id;
                            $SubDataArray['rooms_name'] = $meeting_name;
                        }

                        $whereArray = array(
                            'event_code' => $code,
                            'event_id' => $main['data']['id'],
                        );

                        $ci->mdl_event_meeting->update_data($SubDataArray, $whereArray);

                    } elseif ($type_id == 2 || $type_id == 5) {
                        $SubDataArray = array(
                            'staff_id' => $staff_id,
                            'car_id' => $car_id,
                            'car_name' => $car_name,
                            'driver_id' => $driver_id,
                            'driver_name' => $driver_name,

                            'user_update' => $user_action,
                            'date_update' => date('Y-m-d H:i:s'),
                        );

                        $whereArray = array(
                            'event_code' => $code,
                            'event_id' => $main['data']['id'],
                        );

                        // $ci->mdl_event_car->insert_data($SubDataArray, $whereArray);
                    }

                    // print_r($sid);
                    $VisitorValue = array(
                        'status_complete' => 1,
                        'status' => 0,
                        'date_update' => date('Y-m-d H:i:s'),
                        'user_update' => $user_action,
                    );

                    $VisWhere = array(
                        'event_code' => $code,
                        'event_id' => $main['data']['id'],

                    );
                    $ci->mdl_visitor->delete_data($VisitorValue, $VisWhere);

                    if ($visitor) {

                        $dataVis = [];
                        $visArray = explode(",", $visitor);
                        $dataArray = [];
                        foreach ($visArray as $k_sid => $sid) {
                            $dataVis = explode("-", $sid);

                            $dataArray = array(
                                'event_code' => $code,
                                'event_id' => $main['data']['id'],
                                'event_visitor' => $dataVis[0],
                                'status_complete' => $dataVis[1],
                                'status' => 1,
                                'date_start' => date('Y-m-d H:i:s'),
                                'user_start' => $user_action,
                            );
                            $ci->mdl_visitor->insert_data($dataArray);

                        }

                        // print_r($visitor);
                    }
                    $return = $main;
                }
            } else {
                $return = $check;
            }
        }
        return $return;
    }

    public function delete_data($data = [])
    {
        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $result['error'][] = 'ไม่มีการทำรายการ';

        if (count($data)) {
            $item_id = $data['item_id'];
            $item_code = $data['item_code'];
            $user_action = $data['user_action'];

            $dataArray = array(
                'status' => 0,
                'user_update' => $user_action,
                'date_update' => date('Y-m-d H:i:s'),
            );

            $whereArray = array(
                'id' => $item_id,
                'code' => $item_code,
            );

            $main = $ci->mdl_event->delete_data($dataArray, $whereArray);

            if (!$main['error']) {

                $SubwhereArray = array(
                    'event_id' => $item_id,
                    'event_code' => $item_code,
                );

                $SubDataArray = array(
                    'status' => 0,
                    'user_update' => $user_action,
                    'date_update' => date('Y-m-d H:i:s'),
                );

                $ci->mdl_event_meeting->delete_data($SubDataArray, $SubwhereArray);

                $VisitorArray = array(
                    'status' => 0,
                    'user_update' => $user_action,
                    'date_update' => date('Y-m-d H:i:s'),
                );
                $vis = $ci->mdl_visitor->delete_data($VisitorArray, $SubwhereArray);

                $return = $main;
            }

        }
        return $return;
    }

    public function reject_visitor($data = [])
    {
        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $result['error'][] = 'ไม่มีการทำรายการ';

        if (count($data)) {
            $item_id = $data['item_id'];
            $item_code = $data['item_code'];
            $vid = $data['vid'];
            $user_action = $data['user_action'];

            $dataArray = array(
                'status' => 0,
                'user_update' => $user_action,
                'date_update' => date('Y-m-d H:i:s'),
            );

            $whereArray = array(
                'id' => $vid,
                'event_id' => $item_id,
                'event_code' => $item_code,
            );

            $main = $ci->mdl_visitor->delete_data($dataArray, $whereArray);

            if (!$main['error']) {

                $return = $main;
            }

        }
        return $return;
    }

    public function approval($apv = [])
    {
        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $result['error'][] = 'ไม่มีการทำรายการ';

        if (count($apv)) {

            $item_id = $apv['item_id'];
            $item_code = $apv['item_code'];
            $item_data = $apv['item_data'];
            $user_action = $apv['user_action'];

            if ($item_data == 2) {
                $item_field = 'approve_date';
                $status_complete = 5;
                $status_complete_name = "กำลังดำเนินการ";
            } elseif ($item_data == 3) {
                $item_field = 'disapprove_date';
                $status_complete = 3;
                $status_complete_name = "ดำเนินการไม่สำเร็จ";
            }

            $dataArray = array(
                $item_field => date('Y-m-d H:i:s'),
                'user_action' => 1,
                'status_complete' => $status_complete,
                'status_complete_name' => $status_complete_name,
                'user_update' => $user_action,
                'date_update' => date('Y-m-d H:i:s'),
            );

            $whereArray = array(
                'id' => $item_id,
                'code' => $item_code,
            );
            $main = $ci->mdl_event->approval($dataArray, $whereArray);

            if (!$main['error']) {

                $return = $main;
            }

        }
        return $return;
    }

    public function invitation($data = [])
    {
        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $result['error'][] = 'ไม่มีการทำรายการ';

        if (count($data)) {
            $vid = $data['vid'];
            $item_id = $data['item_id'];
            $item_code = $data['item_code'];
            $item_data = $data['item_data'];
            $user_action = $data['user_action'];

            if ($item_data == 2) {
                $remark = 'ตอบรับ';
            } elseif ($item_data == 3) {
                $remark = 'ปฏิเสธ';
            }

            $dataArray = array(
                'status_complete' => $item_data,
                'status_remark' => $remark,
                'user_update' => $user_action,
                'date_update' => date('Y-m-d H:i:s'),
            );

            $whereArray = array(
                'id' => $vid,
                'event_id' => $item_id,
                'event_code' => $item_code,
            );

            $main = $ci->mdl_visitor->invitation($dataArray, $whereArray);

            if (!$main['error']) {

                $return = $main;
            }

        }
        return $return;
    }

    public function processing($data = [])
    {
        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $result['error'][] = 'ไม่มีการทำรายการ';

        if (count($data)) {
            $item_id = $data['item_id'];
            $item_code = $data['item_code'];
            $item_data = $data['item_data'];
            $user_action = $data['user_action'];

            if ($item_data == 2) {
                $item_field = 'date_update';
                $complete_name = 'ดำเนินการสำเร็จ';
                $user_action = 1;
            } elseif ($item_data == 4) {
                $complete_name = 'ยกเลิก';
                $item_field = 'cancle_date';
                $user_action = 1;
            }

            $dataArray = array(
                $item_field => date('Y-m-d H:i:s'),
                'status_complete' => $item_data,
                'status_complete_name' => $complete_name,
                'user_action' => $user_action,
                'user_update' => $user_action,
                'date_update' => date('Y-m-d H:i:s'),
            );

            $whereArray = array(
                'id' => $item_id,
                'code' => $item_code,
            );
            // print_r($dataArray);

            $main = $ci->mdl_event->processing($dataArray, $whereArray);

            if (!$main['error']) {

                $return = $main;
            }

        }
        return $return;
    }

    public function restore($data = [])
    {
        //=     call database    =//
        $ci = &get_instance();
        $ci->load->database();
        //===================//

        $result['error'][] = 'ไม่มีการทำรายการ';

        if (count($data)) {
            $item_id = $data['item_id'];
            $item_code = $data['item_code'];
            $item_data = $data['item_data'];
            $user_action = $data['user_action'];

            $dataArray = array(
                'approve_date' => null,
                'disapprove_date' => null,
                'cancle_date' => null,
                'status_complete' => $item_data,
                'status_complete_name' => "รอดำเนินการ",
                'user_action' => null,
                'user_update' => $user_action,
                'date_update' => date('Y-m-d H:i:s'),
            );

            $whereArray = array(
                'id' => $item_id,
                'code' => $item_code,
            );
            $main = $ci->mdl_event->restore($dataArray, $whereArray);

            if (!$main['error']) {

                $check_approve = $this->auto_approve($item_id, $item_code, $user_action);
                if (!$check_approve['error']) {
                    if ($check_approve['auto_approve']) {
                        $apv['item_id'] = $item_id;
                        $apv['item_code'] = $item_code;
                        $apv['item_data'] = 2;
                        $apv['user_action'] = $user_action;
                        $this->approval($apv);
                    }
                }
                $return = $main;
            }
        }
        return $return;
    }
}
