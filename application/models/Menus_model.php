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
    public function get_liniage_rows($id)
    {
        $this->db->select("
        *,
        concat('".base_url()."uploads/images/',image_url) as image,
		name as product_name,
		name as machine_name,
        menu_id as page_id,
        menu_id as product_id,
        parent_id as category_id"
        );
        $this->db->from($this->table);
        $this->db->like('liniage', '/'.$id);
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
    public function add_update_product_cities($product_id,$data)
    {
        if ($this->db->delete('product_cities',array('product_id' => $product_id))){
            if(isset($data[0]) ){
                $this->db->insert_batch('product_cities', $data);
                return true;
            }
           return false;
        }else{
            return false;
        }
    }
    public function get_product_cities($statement)
    {
        $this->db->select("
        c.id,
        c.id as city_id,
        c.name as city_name,
        p.url,
        p.image_url,
        p.name as product_name,
        p.content,
        concat('".base_url()."uploads/images/',p.image_url) as image,
        p.menu_id as page_id,
        p.menu_id as product_id,
        p.parent_id as category_id,
        `owner_name`,
  `owner_address`,
  `owner_gender`,
  `owner_email`,
  `owner_phone`,
  `owner_aadhaar`,
  `owner_licence` ,
  `machine_name`,
  `machine_category`,
  `machine_company`,
  `machine_model_type`,
  `machine_purchase_year`,
  `machine_registration_number`,
  `machine_insurance_details`,
  `machine_city_id`,
  `machine_description` ,
  `operator_name`,
  `operator_address` ,
  `operator_gender`,
  `operator_email`,
  `operator_phone`,
  `operator_aadhaar`,
  `operator_licence`
        ");
        $this->db->where($statement);
        $this->db->from('product_cities pc');
        $this->db->join('menus p', ' p.menu_id= pc.product_id', 'left');
        $this->db->join('supplier_orders sp', 'sp.product_id = p.menu_id', 'left');
        $this->db->join('cities c', 'pc.city_id = c.id', 'left');
        $this->db->order_by('c.name', 'ASC');
        $this->db->group_by('c.id, p.menu_id');
        $query = $this->db->get();
        return $query->result();
    }
	
	
	 public function get_product_cities_admin($statement)
    {
        $this->db->select("
        c.id,
        c.id as city_id,
        c.name,
		c.name as city_name
        ");
        $this->db->where($statement);
        $this->db->from('product_cities pc');
        $this->db->join('menus p', ' p.menu_id= pc.product_id', 'left');        
        $this->db->join('cities c', 'pc.city_id = c.id', 'left');
        $this->db->order_by('c.name', 'ASC');
        $this->db->group_by('c.id, p.menu_id');
        $query = $this->db->get();
        return $query->result();
    }
}
