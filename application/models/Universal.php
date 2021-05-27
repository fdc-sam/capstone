<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Universal extends CI_Model {
    public function __construct(){
        parent::__construct();
    }
    /*
        function get
        @param boolean $distinct
        @param string $table
        @param string $select
        @param string $result --> 'row' (return row), 'all' (return all[obj])
        @param array('string'=>'string') $where --> array('column name'=>'value')
        @param array('string'=>'string') $like --> array('column name'=>'value')
        @param array('string'=>'string') $join --> array('table name' => 'table.foreignkey = table.foreignkey')
        @param array(int,int) $limit --> array(10[limit],0[offset])
        @param array(string,string) $order --> array('column name','sort order [ASC/DESC]')
        @param array(string) group --> array('column1','column2')
  */
    public function get($distinct=false,$table="",$select="*",$result="all",$where=array(),$like=array(),$join=array(),$limit=array(),$order=array(),$group=array(),$jointype = "left", $or_like=array(),$having=array()){
        $this->db->reset_query();
        if($distinct){
            $this->db->distinct();
        }
        $this->db->select($select);
        if(!empty($where)){
            foreach ($where as $key => $value) {
                if(is_array($value)){
                    $this->db->where_in($key, $value);
                }else{
                    $this->db->where($key,$value);
                }
            }
        }
        if(!empty($like)){
            $this->db->like($like);
        }

        if(!empty($or_like)){
            $this->db->group_start();
            foreach ($or_like as $key => $value) {
                $this->db->or_like($key,$value);
            }
            $this->db->group_end();
        }
        if(!empty($join)){
            foreach ($join as $key => $value) {
                $this->db->join($key,$value,$jointype);
            }
        }
        if(!empty($limit)){
            $this->db->limit($limit[0],$limit[1]);
        }
        if(!empty($order)){
            $this->db->order_by($order[0],$order[1]);
        }
        if(!empty($group)){
            $this->db->group_by($group);
        }
        if(!empty($having)){
            $this->db->having($having);
        }

        $query = $this->db->get($table);
        switch ($result) {
            case 'all':
                $data = $query->result();
            break;
            case 'row':
                $data = $query->row();
            break;
            case 'array':
                $data = $query->result_array();
            break;
            default:
                $data = $query->result();
            break;
        }
        return $data;
    }
    /*
        function update
        @param string $table
        @param array(string=>string) $data --> array('column name' => 'value')
        @param array(string=>string) $where --> array('column name' => 'value')
    */
    public function update($table = "", $data = array(), $where = array()){
        return $this->db->update($table, $data, $where);
    }
    /*
        function delete
        @param string $table
        @param array(string=>string) $where --> array('column name' => 'value')
    */
    public function delete($table = "", $where = array()){
        $this->db->delete($table,$where);
        return true;
    }
    /*
        function insert
        @param string $table
        @param array(string=>string) $data --> array('column name' => 'value')
    */
    public function insert($table = '', $data = array()){
        $result = $this->db->insert($table, $data);
        if ($result) return $this->db->insert_id();
        if (!$result) return false;
    }


    //DATATABLES CONTROLLER SAMPLE TEMPLATE
    /*
        $draw = $this->input->post('draw');
        $length = $this->input->post('length');
        $offset = $this->input->post('start');
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        $columns = $this->input->post('columns');

        $where = array();

        // ordering
        if(!empty($order)){
          $setorder =  array($columns[$order[0]['column']]['data'] => $order[0]['dir']);
        }else{
          $setorder = array();
        }

        // filtering
        if(empty($search['value'])){
          $like = array();
        }else{
          $like = array(
            'address_log.id' => $search['value'],
            'users.first_name' => $search['value'],
            'users.last_name' => $search['value'],
            'users.phone' => $search['value'],
            'address_log.pickup_datetime' => $search['value'],
            'users.id' => $search['value']
          );
        }

        $result = $this->universal->datatables(
          'address_log',
          'address_log.*',
          $where,
          array(
            'users' => 'users.id = address_log.user_id'
          ),
          array($length => $offset),
          $setorder,
          $like
        );
        echo json_encode(
          array(
            'draw' => intval($draw),
            "recordsTotal" => $result['recordsTotal'],
            "recordsFiltered" => $result['recordsFiltered'],
            "data" => $result['data']
          )
        );
    */

    /*
       function datatables
       @param string $table  ---> set tbble name ex. "address_log"
       @param string $select --> set your select query ex. "address_log.id as orders"
       @param array $where --> set your where statement ex. array("adress_log.del" => 0, "address_log.status" => 1)
       @param array $join --> set your join statements ex array("users" => "users.id = address_log.user_id")
       @param array $limit --> set limit of requested query ex array(10,5) limit/offset  10 results start with 5th row
       @param array $order --> set your ORDER BY ex. array("address_log.id" => "DESC")  will set ORDER BY address_log.id DESC
       @param array $like ---> set you LIKE in query ex. array("users.first_name" => "Nyuu") will set to LIKE users.first_name = %Nyuu%
       @param boolean $distinct --> set if DISTINCT or not
      */
    public function datatables($table = "", $select = "",  $where = array(), $join = array(), $limit = array(), $order = array(), $like = array(), $distinct = false, $group = array()){
        $this->db->select($select);
        $this->db->from($table);
        if(!empty($where)){
            foreach ($where as $key => $value) {
                $this->db->where($key,$value);
            }
        }
        if(!empty($join)){
            foreach ($join as $key => $value) {
                $this->db->join($key,$value,'LEFT');
            }
        }
       if(!empty($group)){
         $this->db->group_by($group);
       }
        if($distinct){
            $this->db->distinct();
        }
        //count number of rows before filter like
        $allData = $this->db->count_all_results('', false);

        if(!empty($like)){
            $this->db->group_start();
            foreach ($like as $key => $value) {
                $this->db->or_like($key,$value);
            }
            $this->db->group_end();
        }
        //count number of rows after filter
        $filterdData = $this->db->count_all_results('', false);

        if(!empty($limit)){
            foreach ($limit as $key => $value) {
                $this->db->limit($key,$value);
            }
        }

        if(!empty($order)){
            foreach ($order as $key => $value) {
                $this->db->order_by($key,$value);
            }
        }
        $resultData = $this->db->get()->result_array();
        return array(
            "recordsTotal" => $allData,
            "recordsFiltered" => $filterdData,
            "data" => $resultData
        );
    }


    public function getBalanceLogPointByUserId($user_id){

        $transaction = $this->getNumberOfTransactions($user_id);

        if($transaction > 0){

            $sql = "SELECT (debit - credit) as balance
                FROM ((SELECT SUM(transection) as credit,user_id
                FROM logpoint_log
                    WHERE user_id = '$user_id'
                        AND status = 0) as credit
                        LEFT JOIN (SELECT SUM(log_point) as debit,user_id
                            FROM logpoint
                            WHERE user_id = '$user_id') as debit
                            ON debit.user_id = credit.user_id
                )
            ";
            $result = $this->db->query($sql);
            return $result->row()->balance;

        }else{
            $sql = "SELECT SUM(log_point) as balance FROM logpoint WHERE user_id = '$user_id'";
            $result = $this->db->query($sql);
            return $result->row()->balance;
        }
    }

    public function getNumberOfTransactions($user_id){
        $this->db->from('logpoint_log');
        $this->db->where("user_id",$user_id);
        $this->db->where("status",0);
        return $this->db->count_all_results();
    }

    public function batchInsert($table = '', $data = array()){
        $result = $this->db->insert_batch($table, $data);
        if ($result) return true;
        if (!$result) return false;
    }

    public function select2($distinct=false,$table="",$select="*",$result="all",$where=array(),$like=array(),$orlike=array(),$join=array(),$limit=array(),$order = array(),$group = array(),$jointype = "left"){
        if($distinct){
            $this->db->distinct();
        }
        $this->db->select($select);
        if(!empty($where)){
            foreach ($where as $key => $value) {
                if(is_array($value)){
                    $this->db->where_in($key, $value);
                }else{
                    $this->db->where($key,$value);
                }
            }
        }
        if(!empty($like)){
            $this->db->like($like);
        }
        if(!empty($orlike)){
            $this->db->or_like($orlike, 'match');
        }
        if(!empty($join)){
            foreach ($join as $key => $value) {
                $this->db->join($key,$value,$jointype);
            }
        }
        if(!empty($limit)){
            $this->db->limit($limit[0],$limit[1]);
        }
        if(!empty($order)){
            $this->db->order_by($order[0],$order[1]);
        }
        if(!empty($group)){
            $this->db->group_by($group);
        }
        $query = $this->db->get($table);
        switch ($result) {
            case 'all':
                $data = $query->result();
            break;
            case 'row':
                $data = $query->row();
            break;
            case 'array':
                $data = $query->result_array();
            break;
            default:
                $data = $query->result();
            break;
        }
        return $data;
    }

    public function customQuery($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
