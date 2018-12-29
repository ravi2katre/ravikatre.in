<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notifications_model extends CI_Model {


	 var $table = 'notifications';
    var $primary_key_field = 'id';
    var $column = array('','id','group_name','user_ids','subject','msg','msg_type','date'); //set column field database for order and search
    var $order = array('id' => 'desc'); // default order
    var $group_ids = array(ADMINISTRATOR, MEMBER, EXECUTIVE, SUPPLIER, FARMER); // default order



    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function set_column($column= array()){
        $this->column = $column;
    }

    public function get_rows()
    {
        $this->db->from($this->table);
        $this->db->order_by($this->primary_key_field, 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_rows_with_products()
    {
        $this->db->select('m.*, sm.*, c.name AS `city_name`' );
        $this->db->from($this->table." sm");
        $this->db->order_by($this->primary_key_field, 'ASC');
        $this->db->join("menus m", 'm.menu_id = sm.product_id','left');
        $this->db->join("cities c", 'c.id = sm.machine_city_id','left');
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query()
    {
        $this->db->select('*');
        $this->db->from($this->table);

        $i = 0;
        foreach ($this->column as $item) // loop column
        {
           if(empty($item) && !empty($this->input->post('search[value]'))){
            
              if($i===0 ) // first loop
              {
               $this->db->group_start();
              }
                $i++;
            continue;
           }
        
            if($this->input->post('search[value]')) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search[value]'));
                }
                else
                {
                    $this->db->or_like($item, $this->input->post('search[value]'));
                }
                if(count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }
        //cidb($this->input->post('order'));
        if($this->input->post('order')) // here order processing
        {
            $this->db->order_by($column[$this->input->post('order[0][column]')], $this->input->post('order[0][dir]'));
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($this->input->post('length') != -1)
        $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where($this->primary_key_field,$id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where($this->primary_key_field, $id);
        $this->db->delete($this->table);
    }


}
