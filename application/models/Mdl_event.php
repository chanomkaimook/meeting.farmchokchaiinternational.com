<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_event extends CI_Model
{
    private $table = "event";
    private $fildstatus = "status";

    public function __construct()
    {
        parent::__construct();
    }

    //  =========================
    //  =========================
    //  CRUD
    //  =========================
    //  =========================

    //  *
    //  * CRUD
    //  * read
    //  * 
    //  * get data
    //  *
    /**
     * data
     *
     * @param integer|null $id = primary key
     * @param array $optionnal = [
     *                          select=array(a,b,c),
     *                          where=array(a=>desc,b=asc),
     *                          orderby=array(a=>desc,b=asc),
     *                          groupby=array(a,b),
     *                          limit=0,10,
     *                          join="meeting","car",
     *                           ]
     * @return void
     */
    public function get_data(int $id = null, array $optionnal = [], string $type = "result")
    {
        $sql = (object) $this->get_sql($id, $optionnal);
        $query = $sql->get();

        if ($type == "row" || $id) {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    #
    # count data to show all
    public function get_data_all(int $id = null, array $optionnal = [])
    {
        # code...
        $optionnal['select'] = 'count(' . $this->table . '.id) as total';

        $data = (object) $this->get_dataShow($id, $optionnal, 'row');
        $num = $data->total;

        return $num;
    }

    //  *
    //  * CRUD
    //  * read
    //  * 
    //  * get data only for display (not data delete)
    //  *
    public function get_dataShow(int $id = null, array $optionnal = [], string $type = "result")
    {
        # code...
        $sql = (object) $this->get_sql($id, $optionnal, $type);
        $sql->where($this->table . '.' . $this->fildstatus, 1);

        $query = $sql->get();

        if ($type == "row") {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    //  *
    //  * CRUD
    //  * insert
    //  * 
    //  * insert data
    //  *
    public function insert_data()
    {
        $result = array(
            'error' => 1,
            'txt' => 'ไม่มีการทำรายการ',
        );

        if (count($this->input->post())) {
            $data = array(
                'type_id' => textShow($this->input->post('insert-type')),
                'event_name' => textShow($this->input->post('insert-name')),
                'staff_id' => textShow($this->input->post('insert-head')),
                'event_description' => textShow($this->input->post('insert-description')),
                'date_begin' => textShow($this->input->post('insert-dates')),
                'date_end' => textShow($this->input->post('insert-datee')),
                'time_begin' => textShow($this->input->post('insert-times')),
                'time_end' => textShow($this->input->post('insert-timee')),
                'status_complete' => 1,
                'status_complete_name' => "รอดำเนินการ",
                'status' => 1,

                'user_start' => 0,
            );

            $this->db->insert($this->table, $data);
            $new_id = $this->db->insert_id();

            // keep log
            log_data(array('insert ' . $this->table, 'insert', $this->db->last_query()));

            if ($new_id) {

                $result = array(
                    'error' => 0,
                    'txt' => 'ทำรายการสำเร็จ',
                    'data' => array(
                            'id' => $new_id
                        )
                );
            }
        }


        return $result;
    }

    //  *
    //  * CRUD
    //  * update
    //  * 
    //  * update data
    //  *
    public function update_data()
    {
        $item_id = $this->input->post('item_id');

        /* $begin_date = "";
        if ($this->input->post('item_begin_date')) {
            $ex = explode('-', $this->input->post('item_begin_date'));
            $begin_date = $ex[2] . "-" . $ex[1] . "-" . $ex[0];
        } */
        $data = array(
            'type_id' => textShow($this->input->post('update-type')),
            'event_name' => textShow($this->input->post('update-name')),
            'staff_id' => textShow($this->input->post('update-head')),
            'event_description' => textShow($this->input->post('update-description')),
            'date_begin' => textShow($this->input->post('update-dates')),
            'date_end' => textShow($this->input->post('update-datee')),
            'time_begin' => textShow($this->input->post('update-times')),
            'time_end' => textShow($this->input->post('update-timee')),
            
            'date_update' => date('Y-m-d H:i:s'),
            'user_update' => 0,
        );

        $this->db->where('id', $item_id);
        $this->db->update($this->table, $data);

        // keep log
        log_data(array('update ' . $this->table, 'update', $this->db->last_query()));

        $result = array(
            'error' => 0,
            'txt' => 'ทำรายการสำเร็จ',
            'data' => array(
                    'id' => $item_id
                )
        );

        return $result;
    }

    //  *
    //  * CRUD
    //  * delete
    //  * 
    //  * delete data
    //  *
    public function delete_data()
    {
        $item_id = textShow($this->input->post('item_id'));
        $item_remark = textShow($this->input->post('item_remark'));

        $result = array(
            'error' => 1,
            'txt' => 'ไม่มีการทำรายการ'
        );

        if (!$item_id) {
            return $result;
        }

        $data_array = array(
            $this->fildstatus => 0,

            'date_update' => date('Y-m-d H:i:s'),
            'user_update' => $this->session->userdata('user_code'),
        );

        if ($item_remark) {
            $data_array['remark_delete'] = $item_remark;
        }

        $this->db->update($this->table, $data_array, array('id' => $item_id));

        // keep log
        log_data(array('delete ' . $this->table, 'update', $this->db->last_query()));

        $result = array(
            'error' => 0,
            'txt' => 'ทำรายการสำเร็จ'
        );

        return $result;
    }
    //  =========================
    //  =========================
    //  End CRUD
    //  =========================
    //  =========================



    //  =========================
    //  =========================
    //  Query
    //  =========================
    //  =========================
    /**
     * query
     *
     * @param integer|null $id
     * @param array $optionnal
     * @param string $type
     * @return void
     */
    function get_sql(int $id = null, array $optionnal = [], string $type = 'result')
    {
        $request = $_REQUEST;

        $hidden_start = "";
        $hidden_end = "";

        $sql = $this->db->from($this->table);

        if ($optionnal['join']) {
            switch($optionnal['join']){
                case "meeting":
                    $sql->join('event_meeting','event.id=event_meeting.event_id','inner');
                    break;
                case "car":
                    $sql->join('event_car','event.id=event_car.event_id','inner');
                    break;
                default:
                    $sql->join('event_meeting','event.id=event_meeting.event_id','left');
                    $sql->join('event_car','event.id=event_car.event_id','left');
                    break;

            }
        }

        if (textShow($request['hidden_datestart'])) {
            $hidden_start = textShow($request['hidden_datestart']);
        }
        if (textShow($request['hidden_dateend'])) {
            $hidden_end = textShow($request['hidden_dateend']);
        }

        if ($hidden_start && $hidden_end) {
            $sql->where('date(' . $this->table . '.date_starts) >=', $hidden_start);
            $sql->where('date(' . $this->table . '.date_starts) <=', $hidden_end);
        }

        if ($id) {
            $sql->where($this->table . '.id', $id);
        }

        if ($optionnal['select']) {
            $sql->select($optionnal['select']);
        }

        if ($optionnal['where'] && count($optionnal['where'])) {
            foreach ($optionnal['where'] as $column => $value) {
                $sql->where($column, $value);
            }
        }

        if ($optionnal['order_by'] && count($optionnal['order_by'])) {
            foreach ($optionnal['order_by'] as $column => $value) {
                $sql->order_by($column, $value);
            }
        } else {
            $sql->order_by($this->table . '.id', 'desc');
        }

        if ($optionnal['group_by'] && count($optionnal['group_by'])) {
            foreach ($optionnal['group_by'] as $column) {
                $sql->group_by($column);
            }
        }

        if ($type != "row") {
            if ($optionnal['limit']) {
                $sql->limit($optionnal['limit']);
            } else {

                if (isset($request['start']) && isset($request['length'])) {
                    $sql->limit($request['length'], $request['start']);
                } else {
                    // $sql->limit(10, 0);
                }
            }
        }

        return $sql;
    }
    //  =========================
    //  =========================
    //  End Query
    //  =========================
    //  =========================
}