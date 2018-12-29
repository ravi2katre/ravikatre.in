<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menus_model extends CI_Model {

    var $table = 'menus';
    var $column = array('t1.menu_id','t1.name','t2.name','t1.url','t1.icon','t1.sort_by'); //set column field database for order and search
    var $order = array('menu_id' => 'desc'); // default order

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_rows()
    {

        $this->db->from($this->table);
        $this->db->order_by('menu_id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query()
    {
        $this->db->select('t1.*,t2.name as parent_menu');
        $this->db->from($this->table." t1");
        $this->db->join($this->table." t2", 't1.parent_id = t2.menu_id','left');

        $i = 0;
        foreach ($this->column as $item) // loop column
        {
            if(empty($item)){
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
    function export()
    {
        $this->_get_datatables_query();
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
        $this->db->where('menu_id',$id);
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
        $this->db->where('menu_id', $id);
        $this->db->delete($this->table);
    }

    public function delete_by_menu_id($id)
    {
        $this->db->where('menu_id', $id);
        $this->db->delete('menus_groups');
    }

    public function insert_menus_groups($data=array(),$menu_id)
    {
        $this->delete_by_menu_id($menu_id);
        if(count($this->input->post('group_ids')) >0){
            $data = array();
            foreach($this->input->post('group_ids') as $key=>$val){
                $data[$key]['menu_id'] = $menu_id;
                $data[$key]['group_id'] = $val;
            }
        }
//cidb($this->input->post());
        if(empty($data)){
            return true;
        }
        $this->db->insert_batch('menus_groups', $data);
    }

    public function menus_groups_get_by_id($id)
    {
        $this->db->from('menus_groups');
        $this->db->where('menu_id',$id);
        $query = $this->db->get();

        return $query->result();
    }
}
